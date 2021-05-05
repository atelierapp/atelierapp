<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function response($data, $message = null, $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'message' => $message ?? __('response.success.ok'),
            'data'    => $data,
        ], $statusCode);
    }

    protected function responseNoContent(): JsonResponse
    {
        return $this->response([], null, Response::HTTP_NO_CONTENT);
    }

}
