<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\ProductAdvanceImport\ProductAdvanceImport;
use App\Models\Store;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductAdvanceController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'template' => ['required', 'file'],
            'images' => ['nullable'],
            'images.*' => ['file', 'image'],
        ]);

        $storeId = Store::where('user_id', auth()->id())->firstOrFail()->id;
        Excel::import(new ProductAdvanceImport($storeId, $request->file('images', [])), $request->file('template'));

        return [
            'message' => 'Productos cargados masivamente',
            'data' => [],
        ];
    }
}
