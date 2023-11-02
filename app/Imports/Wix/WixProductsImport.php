<?php

namespace App\Imports\Wix;

use App\Models\Product;
use App\Models\Store;
use App\Services\VariationService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WixProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        $collection->each(function ($register) {
            $product = Product::withTrashed()->where('id', $register['sku'])->first();
            if (! is_null($product)) {
                $this->setWixData($product, $register);
            } else {
                $store = Store::where('name', $register['brand'])->first();
                if (! is_null($store)) {
                    $product = Product::updateOrCreate([
                        'store_id' => $store->id,
                        'title' => $register['name'],
                    ], [
                        'active' => false,
                        'sku' => $register['sku'],
                        'price' => $register['price'],
                        'description' => $register['description'],
                    ]);
                    $this->setWixData($product, $register);
                    app(VariationService::class)->duplicateFromBaseProduct($product, []);
                }
            }
        });
    }

    private function setWixData(Product $product, Collection $wixData): void
    {
        $properties = $product->properties;
        $properties['wix'] = [
            'handleId' => $wixData['handleid'],
            'fieldtype' => $wixData['fieldtype'],
            'productImageUrl' => $wixData['productimageurl'] ?? '',
            'collection' => $wixData['collection'],
            'description' => $wixData['description'],
            'visible' => (string) $wixData['visible'] ? "true" : "false",
            'inventory' => $wixData['inventory'],
        ];
        $product->properties = $properties;
        $product->title = $wixData['name'];
        $product->save();
    }
}
