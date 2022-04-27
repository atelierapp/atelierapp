<?php

namespace App\Services;

use App\Models\Collection;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class ProductService
{
    private string $path = 'stores';

    public function __construct(
        private TagService $tagService,
        private CollectionService $collectionService
    ) {
        //
    }

    public function store(array $params): Product
    {
        $data = $params;

        $product = Product::create($data);
        $this->processCategories($product, [$data['category_id']]);

        if (isset($data['tags'])) {
            $this->processTags($product, $data['tags']);
            $product->load('tags');
        }

        if (isset($data['collections'])) {
            $this->processCollections($product, $data['collections']);
            $product->load('collections');
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

    public function processCollections(Product|int $product, array $collections): void
    {
        if (! empty($collections)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $ids = collect($collections)->pluck('id')->toArray();
            $collections = $this->collectionService->getByIds($ids);
            $product->collections()->saveMany($collections);
        }
    }

}
