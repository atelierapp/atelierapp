<?php

namespace App\Http\Controllers;

use App\Exceptions\AtelierException;
use App\Http\Requests\OrderIndexRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Role;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:' . Role::SELLER)->only('accept');
    }

    public function index(OrderIndexRequest $request)
    {
        $orders = Order::applyFilters($request->validated())
            ->filterByAuthenticatedRole()
            ->with(['user', 'seller'])
            ->get();

        return OrderResource::collection($orders);
    }

    public function accept($order)
    {
        $order = Order::where('id', '=', $order)->filterByAuthenticatedRole()->first();

        if ($order->seller_status_id == Order::_SELLER_APPROVAL){
            throw new AtelierException('This document was aceppted', 409);
        }

        $order->seller_status_id = Order::_SELLER_APPROVAL;
        $order->seller_status_at = now();
        $order->save();

        return OrderResource::make($order);
    }
}
