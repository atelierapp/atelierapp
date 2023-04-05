<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\ProductSimpleImport;
use App\Models\Store;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductSimpleController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'template' => ['required']
        ]);

        $storeId = Store::where('user_id', auth()->id())->firstOrFail()->id;
        Excel::import(new ProductSimpleImport($storeId), $request->file('template'));

        return [
            'message' => 'Productos cargados masivamente',
            'data' => []
        ];
    }
}
