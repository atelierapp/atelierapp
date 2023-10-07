<?php

namespace App\Imports\ProductAdvanceImport;

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

    public function collection(Collection $collection): array
    {
        return [

        ];
    }
}
