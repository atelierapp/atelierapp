<?php

namespace App\Http\Controllers\Wix;

use App\Exports\WixExport;
use App\Http\Controllers\Controller;

class WixExportController extends Controller
{
    public function __invoke()
    {
        return new WixExport();
    }
}
