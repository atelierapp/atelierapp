<?php

namespace App\Http\Controllers;

use App\Models\Color;

class ColorController extends Controller
{
    public function index(): array
    {
        $colors = Color::paginate();

        return [
            [
                'brand' => 'CLARE',
                'items' => $colors,
            ],
        ];
    }
}
