<?php

namespace App\Http\Controllers\Process;

use App\Exceptions\AtelierException;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Role;
use App\Services\PaypalService;
use Illuminate\Http\Response;

class OrderAcceptController extends Controller
{
    public function __construct(
        private PaypalService $paypalService,
    ) {
        $this->middleware('auth:sanctum');
        $this->middleware('role:' . Role::SELLER);
    }

    /**
     * @throws Throwable
     * @throws AtelierException
     */
    public function __invoke($order)
    {
        $order = Order::where('id', '=', $order)->filterByRole()->first();

        if ($order->seller_status_id == OrderStatus::_SELLER_APPROVAL) {
            throw new AtelierException('This document was accepted', Response::HTTP_CONFLICT);
        }

        $this->paypalService->capturePaymentOrder($order);

        $order->seller_status_id = OrderStatus::_SELLER_APPROVAL;
        $order->seller_status_at = now();
        $order->save();

        return OrderResource::make($order);
    }
}
