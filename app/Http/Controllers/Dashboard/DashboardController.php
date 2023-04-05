<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Services\DashboardService;
use Illuminate\Support\Str;

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
                    'percent' => $this->dashboardService->percentTotalEarningsHistory(),
                    'history' => $this->dashboardService->productTotalEarningsHistory(),
                ],
            ],
        ];
    }

    public function kpiProducts()
    {
        return [
            'data' => [
                'total_revenue' => $this->dashboardService->totalRevenueForSellerUser(0),
                'revenue' => $this->dashboardService->totalRevenueForSellerUser(30),
                'growth' => $this->dashboardService->growth(),
            ],
        ];
    }

    public function statics()
    {
        $values = [];

        for ($i = 0; $i < 6; $i++) {
            $tmp = [
                'month' => Str::title(now()->subMonths($i)->monthName),
                'sales' => 0,
                'views' => 0,
            ];

            $values[] = $tmp;
        }

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
                'customers' => Order::filterByRole()->groupBy('user_id')->distinct()->count('user_id'),
                'awaiting_orders' => Order::filterByRole()->whereSellerStatusId(OrderStatus::_SELLER_PENDING)->select('id')->count('id'),
                'on_hold_orders' => 0,
                'low_stock_orders' => 0, // todo:  remove
                'out_stock_orders' => 0, // todo: remoce
                'low_stock_orders' => 0,
                'out_stock_orders' => 0,
            ],
        ]);
    }

}
