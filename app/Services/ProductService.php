<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    private string $path = 'products';

    public function __construct(
        private TagService $tagService,
        private CollectionService $collectionService,
        private MediaService $mediaService,
        private MaterialService $materialService
    ) {
        //
    }

    public function getBy(int $product, string $field = 'id'): Product
    {
        return Product::where($field, '=', $product)->firstOrFail();
    }

    public function store(array $params): Product
    {
        $data = $params;

        $product = Product::create($data);
        $this->processCategories($product, [$data['category_id']]);
        $this->processImages($product, $data['images']);
        $this->processTags($product, $data['tags']);
        $this->processMaterials($product, $data['materials']);
        $product->load('categories', 'medias', 'tags', 'materials');

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

    /**
     * @param \App\Models\Product|int $product
     * @param array $images  [[orientation => front|side|perspective|plan, file => UploadedFile]]
     * @return void
     */
    public function processImages(Product|int $product, array $images): void
    {
        if (! empty($images)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $this->mediaService->path($this->path)->model($product);
            foreach ($images as $image) {
                $this->processImage($product, $image);
            }
        }
    }

    /**
     * @param \App\Models\Product|int $product
     * @param array $image  [orientation => front|side|perspective|plan, file => UploadedFile]
     * @return void
     */
    public function processImage(Product|int $product, array $image): void
    {
        $this->mediaService->save($image['file'], [
            'orientation' => $image['orientation'],
            'featured' => $image['orientation'] == 'front',
            'type_id' => 1 // App\Models\MediaType::IMAGE
        ]);
    }

    public function processTags(Product|int $product, array $tags = []): void
    {
        if (! empty($tags)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $productTag = [];
            foreach ($tags as $tag) {
                $productTag[] = $this->tagService->getTag($tag['name']);
            }

            $product->tags()->saveMany($productTag);
        }
    }

    public function processMaterials(Product|int $product, array $materials)
    {
        if (! empty($materials)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $productMaterial = [];
            foreach ($materials as $material) {
                $productMaterial[] = $this->materialService->getMaterial($material['name'])->id;
            }

            $product->materials()->sync($productMaterial);
        }
    }

    public function processCollections(Product|int $product, array $collections): void
    {
        if (! empty($collections)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $productCollection = [];
            foreach ($collections as $collection) {
                $productCollection[] = $this->collectionService->getCollectionToAuth($collection['name']);
            }

            $product->collections()->saveMany($productCollection);
        }
    }

}
