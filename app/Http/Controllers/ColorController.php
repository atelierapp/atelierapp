<?php

namespace App\Http\Controllers;

use App\Http\Resources\ColorResource;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ColorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        // TODO :: Temporally commented
        // $colors = Color::paginate(1000);
        //
        // return ColorResource::collection($colors)
        //     ->additional(['brand' => 'Ecocolor']);

        $colors = Product::query()
            ->whereHas('categories', fn ($category) => $category->whereType('color'))
            ->with('featured_media')
            ->paginate(1000);

        return ColorResource::collection($colors)
            ->additional(['brand' => 'Ecocolor']);
    }
}
