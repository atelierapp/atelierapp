<?php

namespace App\Http\Controllers;

use App\Http\Resources\ColorResource;
use App\Models\Color;

class ColorController extends Controller
{

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $colors = Color::paginate(5);

        return ColorResource::collection($colors)
            ->additional(['brand' => 'CLARE']);
    }

}
