<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    public function __invoke(Request $request, int $store)
    {
        $products = Product::query()
            ->where('store_id', $store)
            ->with(['style', 'medias', 'tags', 'categories'])
            ->applyFiltersFrom(request()->all())
            ->paginate(request('pageSize') ?? 1000);

        return ProductResource::collection($products);
    }
}
