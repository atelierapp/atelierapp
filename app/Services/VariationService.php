<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Support\Collection;

class VariationService
{
    private string $path = 'variations';

    public function __construct(
        private MediaService $mediaService
    ) {
        $this->mediaService->path($this->path);
    }

    public function indexFromProduct(Product|int $product): Collection
    {
        if (is_int($product)) {
            $product = app(ProductService::class)->getBy($product);
        }

        $product->load('variations.medias');

        return $product->variations;
    }

    // TODO :: i think that this can improvement, maybe passing each param and not an array
    public function create(array $values): Variation
    {
        return Variation::create($values);
    }

    /**
     * @param \App\Models\Product|int $product
     * @param array $params [name => string, images => [[orientation => string, file => file]]]
     * @return Variation
     */
    public function store(Product|int $product, array $params): Variation
    {
        if (is_int($product)) {
            $product = app(ProductService::class)->getBy($product);
        }

        $variation = $this->createToProduct($product, $params);
        $variation->load('medias');

        return $variation;
    }

    /**
     * @param \App\Models\Product $product
     * @param array $variations [[name => string, images => [[orientation => string, file => file]]]]
     * @return void
     */
    public function createManyToProduct(Product $product, array $variations)
    {
        collect($variations)->each(fn($variation) => $this->createToProduct($product, $variation));
    }

    /**
     * @param \App\Models\Product $product
     * @param array $params [name => string, images => [[orientation => string, file => file]]]
     * @return Variation
     */
    public function createToProduct(Product $product, array $params): Variation
    {
        $variation = $this->create([
            'product_id' => $product->id,
            'name' => $params['name']
        ]);
        $this->processImages($variation, $params['images']);

        return $variation;
    }

    public function duplicateFromProduct(Product $product, array $images)
    {
        $variation = $this->create([
            'product_id' => $product->id,
            'name' => $product->title,
            'is_duplicated' => true,
        ]);
        $this->mediaService->path($this->path);
        $this->processImages($variation, $images);
    }

    /**
     * @param \App\Models\Variation $variation
     * @param array $images  [ [orientation => front|side|perspective|plan, file => UploadedFile] ]
     * @return void
     */
    public function processImages(Variation $variation, array $images): void
    {
        $this->mediaService->model($variation);
        foreach ($images as $image) {
            $this->processImage($image);
        }
    }

    /**
     * @param array $image  [orientation => front|side|perspective|plan, file => UploadedFile]
     * @return void
     */
    public function processImage(array $image): void
    {
        $this->mediaService->save($image['file'], [
            'orientation' => $image['orientation'],
            'featured' => $image['orientation'] == 'front',
            'type_id' => 1 // App\Models\MediaType::IMAGE
        ]);
    }
}
