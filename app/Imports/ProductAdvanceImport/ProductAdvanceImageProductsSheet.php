<?php

namespace App\Imports\ProductAdvanceImport;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductAdvanceImageProductsSheet implements ToCollection
{
    public function __construct(private string $storeId)
    {
        //
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
