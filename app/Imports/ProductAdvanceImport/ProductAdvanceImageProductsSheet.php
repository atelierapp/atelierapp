<?php

namespace App\Imports\ProductAdvanceImport;

use App\Models\Media;
use App\Models\Product;
use App\Services\MediaService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Mockery\Exception;
use PHPStan\PhpDocParser\Ast\Type\ThisTypeNode;

class ProductAdvanceImageProductsSheet implements ToCollection, WithHeadingRow
{
    private MediaService $service;

    public function __construct(private string $storeId)
    {
        $this->service = app(MediaService::class);
        $this->service->path('products');
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

            $product = Cache::remember(
                $register['sku'],
                now()->addSeconds(30),
                fn() => Product::whereSku($register['sku'])->whereStoreId($this->storeId)->firstOrFail()
            );

            $this->service
                ->model($product)
                ->saveImageFromUrl($register['url'], [
                    'orientation' => $this->getOrientation($register['orientation'])
                ]);
        }
    }

    private function getOrientation(string $value): string
    {
        $orientations = [
            'Frontal' => 'front',
            'Lateral' => 'side',
            'Perspectiva' => 'perspective',
            'Plano' => 'plan',
            'eCommerce' => 'ecommerce',
        ];

        return Arr::get($orientations, $value, '');
    }
}
