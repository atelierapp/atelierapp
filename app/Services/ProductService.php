<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class ProductService
{
    private string $path = 'stores';

    public function __construct(
        private TagService $tagService
    )
    {
        //
    }

    public function store(array $params): Product
    {
        $data = $params;
        $product = Product::create($data);
        $this->processCategories($product, [$data['category_id']]);

        if (isset($data['tags'])) {
            $this->processTags($product,$data['tags']);
            $product->load('tags');
        }

        return $product;
    }

    public function processCategories(Product|int $product, array $categories): void
    {
        if (is_int($product)) {
            $product = $this->getBy($product);
        }

        $product->categories()->sync($categories);
    }

    public function processTags(Product|int $product, array $tags = []): void
    {
        if (is_int($product)) {
            $product = $this->getBy($product);
        }

        $productTag = [];
        foreach ($tags as $tag) {
            $productTag[] = $this->tagService->getTag($tag['name']);
        }

        $product->tags()->saveMany($productTag);
    }

    public function getBy(int $product, string $field = 'id'): Product
    {
        return Product::where($field, '=', $product)->firstOrFail();
    }

}
