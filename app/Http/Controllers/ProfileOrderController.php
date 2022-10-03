<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;

class ProfileOrderController extends Controller
{
    public function __invoke()
    {
        $projects = Order::whereUserId(auth()->id())
            ->with('user', 'seller')
            ->get();

        return OrderResource::collection($projects);
    }
}
