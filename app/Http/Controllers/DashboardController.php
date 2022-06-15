<?php

namespace App\Http\Controllers;

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
                    'value' => rand(100000, 200000),
                    'percent' => rand(-200, 200) / 10,
                    'history' => $this->prepareHistory(),
                ],
                'products' => [
                    'value' => rand(100000, 200000),
                    'percent' => rand(-200, 200) / 10,
                    'history' => $this->prepareHistory(),
                ],
                'earnings' => [
                    'value' => rand(100000, 200000),
                    'percent' => rand(-200, 200) / 10,
                    'history' => $this->prepareHistory(),
                ],
            ],
        ];
    }

    private function prepareHistory(): array
    {
        $values = [];
        for ($i = 0; $i < 13; $i++) {
            $values[] = rand(10000, 30000);
        }

        return $values;
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

}
