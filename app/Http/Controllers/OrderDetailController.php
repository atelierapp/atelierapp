<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderDetailResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function index(int|string $order)
    {
        $details = $this->orderService->getDetails($order);

        return OrderDetailResource::collection($details);
    }
}
