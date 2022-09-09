<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\NetIncomeRequest;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class NetIncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:seller');
    }

    public function __invoke(NetIncomeRequest $request)
    {
        $orders = Order::where('seller_id', auth()->id())
            ->paidBetween($request->get('start_date'), $request->get('end_date'))
            ->addSelect(DB::raw('date(paid_on) paid_on'))
            ->addSelect(DB::raw('sum(total_price) total_price'))
            ->groupByRaw('date(paid_on)')
            ->orderBy('paid_on')
            ->get();

        return response()->json([
            'data' => [
                'average' => $orders->avg(fn ($order) => $order->total_price),
                'data' => $orders->toArray(),
            ],
        ]);
    }
}
