<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    public function __invoke(Request $request, int $id)
    {
        $products = Product::query()
            ->where('store_id', $id)
            ->with(['style', 'medias', 'tags'])
            ->applyFiltersFrom(request()->all())
            ->paginate(request('pageSize') ?? 10);

        return ProductResource::collection($products);
    }
}
