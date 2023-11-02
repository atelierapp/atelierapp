<?php

namespace App\Imports\ProductSimpleImport;

use App\Models\Product;
use App\Services\VariationService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductSimpleImport implements ToCollection, WithHeadingRow
{
    private VariationService $variationService;

    public function __construct(
        private string $storeId,
    ) {
        $this->variationService = app(VariationService::class);
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
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
                    'manufacturer_process' => 'handmade', // TODO: validate this value by default
                    'sku' => $register['sku'],
                    'title' => $register['name'],
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

            $this->variationService->duplicateFromProduct($product, []);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
