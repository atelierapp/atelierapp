<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Variation;

class VariationService
{
    private string $path = 'variations';

    public function __construct(private MediaService $mediaService)
    {
        //
    }

    /**
     * @param \App\Models\Product $product
     * @param array $variations [[name => string, images => [[orientation => string, file => file]]]]
     * @return void
     */
    public function createManyToProduct(Product $product, array $variations)
    {
        $this->mediaService->path($this->path);

        foreach ($variations as $variation) {
            $variationModel = $this->create([
                'product_id' => $product->id,
                'name' => $variation['name']
            ]);
            $this->processImages($variationModel, $variation['images']);
        }
    }

    public function create(array $values): Variation
    {
        return Variation::create($values);
    }

    /**
     * @param \App\Models\Variation $variation
     * @param array $images  [[orientation => front|side|perspective|plan, file => UploadedFile]]
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
}
