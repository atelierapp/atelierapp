<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FileImport
{
    public function handle(Request $request, Closure $next)
    {
        ini_set('upload_max_filesize', '2G');
        ini_set('max_file_uploads', 100);

        return $next($request);
    }
}
