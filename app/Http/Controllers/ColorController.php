<?php

namespace App\Http\Controllers;

use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ColorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $colors = Color::paginate(1000);

        return ColorResource::collection($colors)
            ->additional(['brand' => 'CLARE']);
    }
}
