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
        //
    }

    public function generateOrder($order)
    {
        $order = Order::withoutGlobalScopes()->whereId($order)->firstOrFail();

        return response()->json(['data' => $this->paypalService->createOrder($order)]);
    }

    /**
     * @throws \Throwable
     */
    public function checkPayment(Request $request)
    {
        $result = $this->paypalService->updateToPendingApproval($request->get('token'));

        return OrderResource::make($result);
    }
}
