<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Excel;

class WixExport implements FromView, Responsable
{
    use Exportable;

    private $fileName = "";

    private $writerType = Excel::CSV;

    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    private mixed $store;

    public function __construct()
    {
        $this->store = Store::where('user_id', auth()->id())->firstOrFail();
        $this->fileName = Str::slug("products " . $this->store->name . " " . now()->toDateString()) . '.csv';
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $products = Product::where('store_id', $this->store->id)
            ->with(['store:id,name', 'categories:id,name'])
            ->get();

        return view('exports.wix-products', [
            'products' => $products
        ]);
    }
}
