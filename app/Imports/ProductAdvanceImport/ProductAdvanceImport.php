<?php

namespace App\Imports\ProductAdvanceImport;

use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductAdvanceImport implements WithMultipleSheets, SkipsUnknownSheets
{
    public function __construct(private int $storeId)
    {
        //
    }

    public function sheets(): array
    {
        return [
            'Productos' => new ProductAdvanceProductsSheet($this->storeId),
            'Variaciones' => new ProductAdvanceVariationsSheet($this->storeId),
            'ImagenProductos' => new ProductAdvanceImageProductsSheet($this->storeId),
        ];
    }

    public function onUnknownSheet($sheetName): void
    {
        info("Sheet {$sheetName} was skipped");
    }
}
