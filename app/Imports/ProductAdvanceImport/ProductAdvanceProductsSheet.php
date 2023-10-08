<?php

namespace App\Imports\ProductAdvanceImport;

use App\Models\Product;
use App\Services\VariationService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductAdvanceProductsSheet implements ToCollection, WithHeadingRow
{
    private VariationService $variationService;

    public function __construct(private string $storeId)
    {
        $this->variationService = app(VariationService::class);
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function collection(Collection $collection): void
    {
        foreach ($collection as $position => $register) {
            if ($position == 0) {
                next($collection);
                continue;
            }

            $product = Product::where('sku', $register['sku'])
                ->where('store_id', $this->storeId)
                ->firstOrNew()
                ->fill([
                    'country' => config('app.country'),
                    'store_id' => $this->storeId,
                    'manufacturer_process' => empty($register['manufacture']) ? 'handmade' : $register['manufacture'], // TODO: validate this value by default
                    'sku' => $register['sku'],
                    'title' => $register['name'],
                    'description' => $register['description'],
                    'active' => false,
                    'price' => $register['price'],
                    'quantity' => $register['quantity'],
                    'properties' => [
                        'dimensions' => [
                            'width' => $register['width'],
                            'height' => $register['height'],
                            'depth' => $register['depth'],
                        ],
                    ],
                ]);
            $product->save();

            $this->variationService->duplicateFromBaseProduct($product, []);
        }
    }
}
