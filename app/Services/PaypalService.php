<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\PaypalPlan;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\StreamInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

class PaypalService
{
    private int $paymentGatewayId = 1;
    private mixed $orderService;

    /** @throws Throwable */
    public function __construct(private PayPalClient $provider)
    {
        $this->orderService = app(OrderService::class);
        $this->provider->getAccessToken();
    }

    /**
     * @throws AtelierException
     * @throws Throwable
     */
    public function createOrder(Order $order): array
    {
        $structure = [
            'intent' => 'AUTHORIZE',
            'application_context' => [
                'brand_name' => config('app.name'),
                'return_url' => route('paypal.check-payment'),
                'cancel_url' => route('paypal.notify'),
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $order->total_price,
                    ]
                ]
            ],
        ];

        $response = $this->provider->createOrder($structure);

        if (! isset($response['id'])) {
            throw new AtelierException(
                Arr::get($response, 'error.details.0.description', 'An error occurred in the integration with Paypal'),
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $response
            );
        }

        $this->orderService->updatePaymentGateway($order, $this->paymentGatewayId, $response['id']);
        $this->orderService->updatePaymentGatewayMetadata($order, 'order_created', $response);
        $response['order_id'] = $order->id;

        return [
            'order_id' => $order->id,
            'links' => [
                'to_pay' => $response['links'][1]['href'],
                'method' => $response['links'][1]['method'],
            ],
        ];
    }

    /**
     * @throws AtelierException
     * @throws Throwable
     * @throws InvalidArgumentException
     */
    public function createSubscription(string $planId): array
    {
        $securityToken = Uuid::uuid4();

        $structure = [
            'plan_id' => $planId,
            'start_time' => ($start = now()->addDay()->startOfDay())->toIso8601String(),
            'application_context' => [
                'brand_name' => config('app.name'),
                'locale' => 'es-PE',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'SUBSCRIBE_NOW',
                'payment_method' => [
                    'payer_selected' => 'PAYPAL',
                    'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                ],
                'return_url' => route('paypal.confirm-subscription', [
                    'success' => true,
                    'token' => $securityToken,
                ]),
                'cancel_url' => route('paypal.confirm-subscription', [
                    'success' => false,
                    'token' => $securityToken,
                ]),
            ],
        ];

        $response = $this->provider->createSubscription($structure);

        if (! isset($response['id'])) {
            Log::error(__CLASS__ . ': Error creating PayPal subscription', [
                'response' => $response,
            ]);

            throw new AtelierException(
                Arr::get($response, 'error.details.0.description', 'An error occurred in the integration with Paypal'),
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $response
            );
        }

        Cache::set("paypal-subscriptions:$securityToken", [
            'store_id' => auth()->user()->store->id,
            'plan_id' => $planId,
            'external_subscription_id' => $response['id'],
        ], 3600 * 24); // 1 day

        return [
            'subscription_id' => $response['id'],
            'status' => $response['status'],
            'plan_id' => PaypalPlan::where('external_plan_id', $planId)->value('id'),
            'start_time' => Carbon::parse($start),
            'create_time' => Carbon::parse($response['create_time']),
            'links' => [
                Arr::first(
                    $response['links'],
                    fn($link) => $link['rel'] === 'approve',
                ),
            ],
        ];
    }

    /** @throws Throwable */
    public function capturePaymentOrder(Order $order): void
    {
        $diff = $order->paid_on->diffInDays(now());

        if ($diff > 29) {
            throw new AtelierException(__('paypal.payment.create-authorized-payment'), Response::HTTP_CONFLICT);
        }

        if ($diff > 3) {
            $this->provider->reAuthorizeAuthorizedPayment($order->payment_gateway_code, $order->parent->total_price);
        }

        $authorizationCode = Arr::get(
            $order->payment_gateway_metadata,
            'order_authorization.purchase_units.0.payments.authorizations.0.id'
        );

        $orders = Order::whereParentId($order->id)->sellerStatus(OrderStatus::_SELLER_APPROVAL)->get();
        $amount = $orders->sum('total_price');

        $capture = $this->provider->captureAuthorizedPayment($authorizationCode, '', $amount, '');
        $this->orderService->updatePaymentGatewayMetadata($order, 'payment_capture', $capture);

        if (isset($capture['error'])) {
            throw new AtelierException(__('paypal.payment.payout-error'));
        }

        $this->orderService->updatePaidStatusTo(
            $orders->pluck('id')->merge($order->id)->toArray(),
            PaymentStatus::PAYMENT_CAPTURED
        );
    }

    /** @throws Throwable */
    public function updateToPendingApproval(mixed $token): Order
    {
        // TODO : implement by orderService
        $order = Order::withoutGlobalScopes()->paymentGateway($this->paymentGatewayId, $token)->firstOrFail();

        $response = $this->provider->authorizePaymentOrder($token);
        $this->orderService->updateToPendingApprovalStatus($order);
        $this->orderService->updatePaymentGatewayMetadata($order, 'order_authorization', $response);

        return $order;
    }


    public function transferPaymentsToSellers(): void
    {
        $orders = Order::with('store:id,commission_percent,user_id')
            ->where('paid_status_id', '=', PaymentStatus::PAYMENT_CAPTURED)
            ->whereNotNull('store_id')
            ->get();
        $orders->loadMissing('store.admin:id,email');

        $checkoutId = now()->format('YmdHis');
        $requestQuery = [
            'sender_batch_header' => [
                'sender_batch_id' => "Payouts_{$checkoutId}",
                "email_subject" => "You have money!",
                "email_message" => "You received a payment. Thanks for using our service!",
            ],
            'items' => [],
        ];

        foreach ($orders as $position => $order) {
            $requestQuery['items'][] = $this->prepareTrnsferItem($checkoutId, $position, $order);
        }

        $result = $this->provider->createBatchPayout($requestQuery);

        $orders->each(fn ($order) => $this->orderService->updatePaymentGatewayMetadata($order, 'transfer_status', $result));
        // TODO : guardar en algun lado el resultado de los pagos para mayor trazabilidad cuando se junten los montos por tienda
    }

    private function prepareTrnsferItem($checkoutId, $position, Order $order)
    {
        $payload = [
            'recipient_type' => 'EMAIL',
            'amount' => [
                'value' => $order->amount_to_transfer,
                'currency' => 'USD'
            ],
            'sender_item_id' => $checkoutId . str_pad($position + 1, 3, '0', STR_PAD_LEFT),
            'recipient_wallet' => 'PAYPAL',
            'receiver' => $order->store->admin->email,
        ];

        $this->orderService->updatePaymentGatewayMetadata($order, 'sender_item_id', [$payload['sender_item_id']]);

        return $payload;
    }
        
    /** @throws Throwable */
    public function getSubscription(string $subscriptionId): StreamInterface|array|string
    {
        return $this->provider->showSubscriptionDetails($subscriptionId);
    }
}
