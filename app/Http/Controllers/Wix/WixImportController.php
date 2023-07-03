<?php

namespace App\Http\Controllers\Wix;

use App\Http\Controllers\Controller;
use App\Imports\Wix\WixProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class WixImportController extends Controller
{
    public function __invoke()
    {
        Excel::import(new WixProductsImport, request()->file('file'));

        return response()->json(['message' => 'File charged'], 202);
    }
}
