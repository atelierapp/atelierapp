<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
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

        if (!isset($response['id'])) {
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

    /** @throws Throwable */
    public function capturePaymentOrder(Order $order): Order
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

        // TODO: implement by service
        $orders = Order::whereParentId($order->id)->sellerStatus(OrderStatus::_SELLER_APPROVAL)->get();
        $amount = $orders->sum('total_price');

        $capture = $this->provider->captureAuthorizedPayment($authorizationCode, '', $amount, '');
        $this->orderService->updatePaymentGatewayMetadata($order, 'payment_capture', $capture);
            'sender_batch_header' => [
                'sender_batch_id' => $checkoutId,
                "recipient_type" => "EMAIL",
                "email_subject" => "You have money!",
                "email_message" => "You received a payment. Thanks for using our service!",
            ],
            'items' => [
                [
                    'amount' => [
                        'value' => '"' . $order->total_price * 0.75 . '"',
                        'currency' => 'USD'
                    ],
                    'sender_item_id' => $checkoutId . '001',
                    'recipient_wallet' => 'PAYPAL',
                    'receiver' => 'sb-a7bpl20773735@personal.example.com',
                ]
            ],
        ]);

        if (isset($capture['error'])) {
            throw new AtelierException(__('paypal.payment.payout-error'));
        }

        $this->orderService->updatePaidStatusTo(
            $orders->pluck('id')->merge($order->id)->toArray(),
            PaymentStatus::PAYMENT_CAPTURED
        );
        // aqui en adelante pasa al otro job
        // $checkoutId = now()->format('YmdHisv');
        // $result = $this->provider->createBatchPayout([
        //     'sender_batch_header' => [
        //         'sender_batch_id' => $checkoutId,
        //         "recipient_type" => "EMAIL",
        //         "email_subject" => "You have money!",
        //         "email_message" => "You received a payment. Thanks for using our service!",
        //     ],
        //     'items' => [
        //         [
        //             'amount' => [
        //                 'value' => '"' . $order->total_price * 0.75 . '"', // ajustar al redondeo de esta parte
        //                 'currency' => 'USD'
        //             ],
        //             'sender_item_id' => $checkoutId . '001',
        //             'recipient_wallet' => 'PAYPAL',
        //             'receiver' => 'sb-a7bpl20773735@personal.example.com',
        //         ]
        //     ],
        // ]);
        //
        // $this->orderService->updatePaymentGatewayMetadata($order, 'payout_status', $result);
        //
        //
        // $this->orderService->updateToPayedStatus($order, $capture);
        //
        // return $order;
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
}
