<?php

namespace App\Http\Controllers\Process;

use App\Exceptions\AtelierException;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Role;
use Illuminate\Http\Response;

class OrderAcceptController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum');
        $this->middleware('role:' . Role::SELLER);
    }

    /**
     * @throws AtelierException
     */
    public function __invoke($order)
    {
        $order = Order::where('id', '=', $order)->filterByRole()->first();

        if ($order->seller_status_id == OrderStatus::_SELLER_APPROVAL) {
            throw new AtelierException(__('order.errors.accepted'), Response::HTTP_CONFLICT);
        }

        if ($order->created_at->diffInHours(now()) > 24) {
            throw new AtelierException(__('order.errors.time_over'), Response::HTTP_CONFLICT);
        }

        $order->seller_status_id = OrderStatus::_SELLER_APPROVAL;
        $order->seller_status_at = now();
        $order->save();

        return OrderResource::make($order);
    }
}
