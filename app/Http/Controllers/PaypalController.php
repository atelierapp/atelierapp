<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function __construct(private PaypalService $paypalService)
    {
    }

    public function test()
    {
        $order = Order::find(7);

        return response()->json(['data' => $this->paypalService->createOrder($order)]);
        // $this->paypalService->authorizePaymentOrder($order);

    }

    /**
     * @throws \Throwable
     */
    public function checkPayment(Request $request)
    {
        $result = $this->paypalService->capturePaymentOrder($request->get('token'));

        return OrderResource::make($result);
    }

    public function notify(Request $request)
    {
        Log::info('paypal-notify', $request->all());
    }
}
