<?php

namespace App\Http\Controllers;

use App\Exceptions\AtelierException;
use App\Http\Requests\Order\OrderIndexRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Role;
use App\Services\OrderService;
use App\Services\PaypalService;
use Throwable;

class OrderController extends Controller
{
    public function __construct(
        private PaypalService $paypalService,
        private OrderService $orderService,
    ) {
        $this->middleware('auth:sanctum');
        $this->middleware('role:' . Role::SELLER)->only('accept', 'update');
    }

    public function index(OrderIndexRequest $request)
    {
        $orders = Order::applyFilters($request->validated())
            ->filterByRole()
            ->with(['user', 'seller', 'seller_status', 'paidStatus'])
            ->latest()
            ->get();

        return OrderResource::collection($orders);
    }

    /**
     * @throws Throwable
     * @throws AtelierException
     */
    public function store()
    {
        $order = $this->orderService->createFromShoppingCart((int)auth()->id());

        return $this->paypalService->createOrder($order);
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

    /**
     * @throws Throwable
     * @throws AtelierException
     */
    public function accept($order)
    {
        $order = Order::where('id', '=', $order)->filterByRole()->first();

        if ($order->seller_status_id == OrderStatus::_SELLER_APPROVAL) {
            throw new AtelierException('This document was accepted', 409);
        }

        $this->paypalService->capturePaymentOrder($order);

        $order->seller_status_id = OrderStatus::_SELLER_APPROVAL;
        $order->seller_status_at = now();
        $order->save();

        return OrderResource::make($order);
    }
}
