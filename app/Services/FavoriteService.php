<?php

namespace App\Services;

use App\Models\FavoriteProduct;
use App\Models\Product;

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
}
