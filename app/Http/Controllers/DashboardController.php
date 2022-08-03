<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function kpi()
    {
        return [
            'data' => [
                'views' => [
                    'value' => 0,
                    'percent' => 0,
                    'history' => $this->prepareHistory(),
                ],
                'products' => [
                    'value' => 0,
                    'percent' => 0,
                    'history' => $this->prepareHistory(),
                ],
                'earnings' => [
                    'value' => 0,
                    'percent' => 0,
                    'history' => $this->prepareHistory(),
                ],
            ],
        ];
    }

    private function prepareHistory(): array
    {
        $values = [];
        for ($i = 0; $i < 13; $i++) {
            $values[] = 0;
        }

        return $values;
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

        for ($i = 0; $i < 6; $i++) {
            $tmp = [
                'month' => Str::title(now()->subMonths($i)->monthName),
                'sales' => rand(10000, 30000),
                'views' => rand(10000, 30000),
            ];

            $values[] = $tmp;
        }

        return response()->json(['data' => $values]);
    }

    public function orders()
    {
        $products = Product::query()->inRandomOrder()->take(10)->get();
        $data = [];

        foreach ($products as $product) {
            $tmp = [
                'product' => $product->title,
                'price' => $product->price,
                'is_accepted' => (boolean) rand(0, 1),
                'email' => User::query()->inRandomOrder()->first()->email,
                'delivery_notes' => 'lorem ipsum',
            ];
            $data[] = $tmp;
        }

        return response()->json(['data' => $data]);
    }

    public function topProduct()
    {
        $products = Product::query()->inRandomOrder()->take(5)->get();
        $data = [];

        foreach ($products as $product) {
            $tmp = [
                'image' => $product->featured_media->url,
                'name' => $product->title,
                'availability' => rand(0, 150),
                'sales' => rand(10000, 30000),
            ];
            $data[] = $tmp;
        }

        return response()->json(['data' => $data]);
    }

    public function quickDetails()
    {
        return response()->json(['data' => [
            'customers' => rand(50, 150),
            'awaiting_orders' => rand(150, 300),
            'on_hold_orders' => rand(50, 150),
            'low_stock_orders' => rand(25, 75),
            'out_stock_orders' => rand(0, 25),
        ]]);
    }

}
