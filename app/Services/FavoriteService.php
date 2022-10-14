<?php

namespace App\Services;

use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class FavoriteService
{
    public function __construct(private ProductService $productService)
    {
        //
    }

    public function manageToProduct($product): bool
    {
        $product = $this->productService->getBy($product);
        $where = [
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ];

        $favorite = FavoriteProduct::query()->where($where)->firstOrNew();

        if ($favorite->exists) {
            $favorite->delete();
        } else {
            $favorite->fill($where);
            $favorite->save();
        }

        return $favorite->exists;
    }

    public function trending()
    {
        $trending = FavoriteProduct::whereHas('product.store', fn ($has) => $has->where('user_id', auth()->id()))
            ->addSelect([
                'product_id',
                DB::raw('count(1) as favorites'),
            ])
            ->groupBy('product_id')
            ->get()
            ->sortByDesc('favorites')
            ->loadMissing('product.featured_media');

        // TODO : implement map when product is used in projects in projects

        return $trending;
    }
}
