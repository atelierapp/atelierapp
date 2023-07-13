<?php

namespace App\Imports\Wix;

use App\Models\Product;
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
                $properties = $product->properties;
                $properties['wix'] = [
                    'handleId' => $register['handleid'],
                    'fieldtype' => $register['fieldtype'],
                    'productImageUrl' => $register['productimageurl'] ?? '',
                    'collection' => $register['collection'],
                ];
                $product->properties = $properties;
                $product->save();
            }
        });
    }
}
