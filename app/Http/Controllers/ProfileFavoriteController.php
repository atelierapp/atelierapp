<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProfileFavoriteController extends Controller
{
    public function __invoke()
    {
        $products = Product::whereHas('authFavorite')
            ->with('store', 'medias', 'authFavorite')
            ->get();

        return ProductResource::collection($products);
    }
}
