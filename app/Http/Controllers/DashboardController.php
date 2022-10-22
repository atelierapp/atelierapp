<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
        $this->middleware('auth:sanctum');
    }

    public function kpi()
    {
        return [
            'data' => [
                'views' => [
                    'value' => $this->dashboardService->productViews(),
                    'percent' => $this->dashboardService->percentViewsHistory(),
                    'history' => $this->dashboardService->productViewsHistory(),
                ],
                'products' => [
                    'value' => $this->dashboardService->productsSold(),
                    'percent' => $this->dashboardService->percentProductsSoldHistory(),
                    'history' => $this->dashboardService->productProductsSoldHistory(),
                ],
                'earnings' => [
                    'value' => $this->dashboardService->totalEarnings(),
                    'percent' => 0,
                    'history' => [],
                ],
            ],
        ];
    }

    public function kpiProducts()
    {
        return [
            'data' => [
                'total_revenue' => 0,
                'revenue' => 0,
                'growth' => 0,
            ],
        ];
    }

    public function statics()
    {
        $values = [];

        // for ($i = 0; $i < 6; $i++) {
        //     $tmp = [
        //         'month' => Str::title(now()->subMonths($i)->monthName),
        //         'sales' => rand(10000, 30000),
        //         'views' => rand(10000, 30000),
        //     ];
        //
        //     $values[] = $tmp;
        // }

        return response()->json(['data' => $values]);
    }

    public function orders()
    {
        $positions = OrderDetail::filterByRole()->with('product:id,title')->get();
        $positions->loadMissing('order.user');
        $data = [];

        foreach ($positions as $position) {
            $tmp = [
                'product' => $position->product->title,
                'price' => $position->total_price,
                'is_accepted' => $position->order->seller_status_id == OrderStatus::_SELLER_APPROVAL,
                'email' => $position->order->user->email,
                'delivery_notes' => $position->seller_notes,
            ];
            $data[] = $tmp;
        }

        return response()->json(['data' => $data]);
    }

    public function topProduct()
    {
        $positions = OrderDetail::filterByRole()
            ->selectRaw('sum(total_price) as total_price')
            ->addSelect(['product_id'])
            ->groupBy('product_id')
            ->get()
            ->sortByDesc('total_price');
        $positions->loadMissing('product:id,title', 'product.featured_media:mediable_id,mediable_type,url');
        $data = [];

        foreach ($positions as $position) {
            $data[] = [
                'name' => $position->product->title,
                'image' => $position->product->featured_media->url,
                'availability' => 0,
                'sales' => $position->total_price,
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function quickDetails()
    {
        return response()->json([
            'data' => [
                // 'customers' => rand(50, 150),
                // 'awaiting_orders' => rand(150, 300),
                // 'on_hold_orders' => rand(50, 150),
                // 'low_stock_orders' => rand(25, 75),
                // 'out_stock_orders' => rand(0, 25),
                'customers' => 0,
                'awaiting_orders' => 0,
                'on_hold_orders' => 0,
                'low_stock_orders' => 0,
                'out_stock_orders' => 0,
            ],
        ]);
    }

}
