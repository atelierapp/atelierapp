<?php

namespace App\Http\Controllers;

use App\Exceptions\AtelierException;
use App\Http\Requests\Order\OrderIndexRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Role;
use App\Services\OrderService;
use App\Services\PaypalService;

class OrderController extends Controller
{
    public function __construct(
        private PaypalService $paypalService,
        private OrderService $orderService
    ) {
        $this->middleware('auth:sanctum');
        $this->middleware('role:' . Role::SELLER)->only('accept', 'update');
    }

    public function index(OrderIndexRequest $request)
    {
        $orders = Order::applyFilters($request->validated())
            ->filterByAuthenticatedRole()
            ->with(['user', 'seller', 'seller_status'])
            ->latest()
            ->get();

        return OrderResource::collection($orders);
    }

    public function show($order)
    {
        $order = $this->orderService->getByAuthRole($order);
        $order->load('user', 'seller');

        return OrderResource::make($order);
    }

    public function update(OrderUpdateRequest $request, $order)
    {
        $order = $this->orderService->updateSellerStatus($order, $request->get('seller_status_id'));

        return OrderResource::make($order);
    }

    public function accept($order)
    {
        $order = Order::where('id', '=', $order)->filterByAuthenticatedRole()->first();

        if ($order->seller_status_id == Order::_SELLER_APPROVAL){
            throw new AtelierException('This document was aceppted', 409);
        }

        $this->paypalService->capturePaymentOrder($order);

        $order->seller_status_id = Order::_SELLER_APPROVAL;
        $order->seller_status_at = now();
        $order->save();

        return OrderResource::make($order);
    }
}
