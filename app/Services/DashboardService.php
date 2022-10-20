<?php

namespace App\Services;

use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Support\Arr;

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

    public function productsSold()
    {
        $products = Product::select('id')->authUser()->get();
        $orders = OrderDetail::whereIn('product_id', $products->pluck('id'))
            ->whereHas('order', fn ($order) => $order->sellerStatus([
                OrderStatus::_SELLER_APPROVAL,
                OrderStatus::_SELLER_SEND,
                OrderStatus::_SELLER_IN_TRANSIT,
                OrderStatus::_SELLER_DELIVERED,
            ])->paidStatus([
                PaymentStatus::PAYMENT_APPROVAL,
                PaymentStatus::PAYMENT_PENDING_APPROVAL,
            ]))
            ->get();

        return $orders->sum('quantity');
    }

    public function percentProductsSoldHistory(): float
    {
        $products = Product::select('id')->authUser()->get();
        $currentMonthBegin = now()->firstOfMonth()->toDateString();
        $currentMonthEnd = now()->toDateString();
        $lastMonthBegin = now()->subMonth()->firstOfMonth()->toDateString();
        $lastMonthEnd = now()->subMonth()->toDateString();

        $result = OrderDetail::whereIn('product_id', $products->pluck('id'))
            ->selectRaw('month(created_at) as month')
            ->selectRaw('count(1) as sales')
            ->whereRawDateBetween('created_at', [$lastMonthBegin, $lastMonthEnd])
            ->orWhereRawDateBetween('created_at', [$currentMonthBegin, $currentMonthEnd])
            ->whereHas('order', fn ($order) => $order->sellerStatus([
                OrderStatus::_SELLER_APPROVAL,
                OrderStatus::_SELLER_SEND,
                OrderStatus::_SELLER_IN_TRANSIT,
                OrderStatus::_SELLER_DELIVERED,
            ])->paidStatus([
                PaymentStatus::PAYMENT_APPROVAL,
                PaymentStatus::PAYMENT_PENDING_APPROVAL,
            ]))
            ->groupByRaw('month(created_at)')
            ->get()
            ->sortBy('month')
            ->toArray();

        return empty($result)
            ? 0
            : round(((Arr::get($result, '1.sales', Arr::get($result, '0.sales', 0)) / Arr::get($result, '0.sales', 0)) - 1) * 100, 2);
    }

    public function productProductsSoldHistory(int $lastDays = 15): array
    {
        $products = Product::select('id')->authUser()->get();

        return OrderDetail::whereIn('product_id', $products->pluck('id'))
            ->selectRaw('date(created_at) as date')
            ->selectRaw('sum(quantity) as sales')
            ->whereDate('created_at', '>=', now()->subDays($lastDays)->toDateString())
            ->groupByRaw('date(created_at)')
            ->get()
            ->sortBy('date')
            ->pluck('sales', 'date')
            ->toArray();
    }
}
