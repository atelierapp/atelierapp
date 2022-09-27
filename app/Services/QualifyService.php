<?php

namespace App\Services;

use App\Models\ProductQualification;
use App\Models\ProductQualificationFiles;
use App\Models\StoreUserRating;
use Illuminate\Support\Facades\Storage;

class QualifyService
{
    public function qualifyAStore($store, $params)
    {
        $store = app(StoreService::class)->getById($store);
        $params['user_id'] = auth()->id();
        $params['store_id'] = $store->id;

        return StoreUserRating::query()->create($params);
    }

    public function qualifyAProduct($product, array $values): ProductQualification
    {
        $product = app(ProductService::class)->getBy($product);
        $values['user_id'] = auth()->id();
        $values['product_id'] = $product->id;

        $rating = ProductQualification::query()->create($values);

        if (isset($values['attaches'])) {
            foreach ($values['attaches'] as $attach) {
                $file = Storage::disk('s3')->putFile('product_qualification', $attach, ['visibility' => 'public']);
                ProductQualificationFiles::create([
                    'product_qualification_id' => $rating->id,
                    'url' => $file
                ]);
            }
        }

        $product->score = $product->qualifications()->avg('score');
        $product->save();

        return $rating->loadMissing('files');
    }
}
