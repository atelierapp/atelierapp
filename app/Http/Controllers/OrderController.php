<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $orders = $this->orderService->getFilteredByAuthRole();

        return OrderResource::collection($orders);
    }
}
