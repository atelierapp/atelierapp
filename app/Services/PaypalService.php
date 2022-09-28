<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Order;
use Illuminate\Support\Arr;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalService
{
    private int $paymentGatewayId = 1;
    private mixed $orderService;

    public function __construct(private PayPalClient $provider)
    {
        $this->orderService = app(OrderService::class);
        $this->provider->getAccessToken();
    }

    /**
     * @throws \App\Exceptions\AtelierException
     * @throws \Throwable
     */
    public function createOrder(Order $order): array
    {
        $structure = [
            'intent' => 'CAPTURE',
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
                422,
                $response
            );
        }

        $this->orderService->updatePaymentGateway($order, $this->paymentGatewayId, $response['id']);
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
     * @throws \Throwable
     */
    public function capturePaymentOrder(string $token): Order
    {
        // TODO : implement by orderService
        $order = Order::where('payment_gateway_id', $this->paymentGatewayId)
            ->where('payment_gateway_code', $token)
            ->firstOrFail();

        $capture = $this->provider->capturePaymentOrder($token);

        if (isset($capture['error'])) {
            throw new AtelierException($capture['error']['details'][0]['description']);
        }

        $this->orderService->updateToPayedStatus($order, $capture);

        return $order;
    }
}
