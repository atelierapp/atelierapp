<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    private string $path = 'stores';

    public function __construct()
    {
        //
    }

    public function store(array $params): Product
    {
        $data = $params;
        $product = Product::create($data);
        $this->processCategories($product, [$data['category_id']]);

        return $product;
    }

    public function processCategories(int|Product $product, array $categories): void
    {
        if (is_int($product)) {
            $product = $this->getBy($product);
        }

        $product->categories()->sync($categories);
    }

    public function getBy(int $product, string $field = 'id')
    {
        return Product::where($field, '=', $product)->firstOrFail();
    }

}
