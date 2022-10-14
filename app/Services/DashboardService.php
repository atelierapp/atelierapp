<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductView;

class DashboardService
{
    public function productViews(): int
    {
        return Product::authUser()->sum('view_count');
    }

    public function percentViewsHistory(): float
    {
        $currentMonthBegin = now()->firstOfMonth()->toDateString();
        $currentMonthEnd = now()->toDateString();
        $lastMonthBegin = now()->subMonth()->firstOfMonth()->toDateString();
        $lastMonthEnd = now()->subMonth()->toDateString();

        $result = ProductView::authUser()
            ->selectRaw('month(product_views.created_at) as month')
            ->selectRaw('count(1) as views')
            ->whereRawDateBetween('product_views.created_at', [$lastMonthBegin, $lastMonthEnd])
            ->orWhereRawDateBetween('product_views.created_at', [$currentMonthBegin, $currentMonthEnd])
            ->groupByRaw('month(product_views.created_at)')
            ->get()
            ->sortBy('month')
            ->toArray();

        return empty($result)
            ? 0
            : round((($result[1]['views'] / $result[0]['views']) - 1) * 100, 2);
    }

    public function productViewsHistory(int $lastDays = 15): array
    {
        return ProductView::authUser()
            ->selectRaw('date(product_views.created_at) as date')
            ->selectRaw('count(1) as views')
            ->whereDate('product_views.created_at', '>=', now()->subDays($lastDays)->toDateString())
            ->groupByRaw('date(product_views.created_at)')
            ->get()
            ->sortBy('date')
            ->pluck('views', 'date')
            ->toArray();
    }
}
