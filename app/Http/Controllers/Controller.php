<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function response($data, $message = null, $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'message' => $message ?? __('response.success.ok'),
            'data'    => $data,
        ], $statusCode);
    }
}
