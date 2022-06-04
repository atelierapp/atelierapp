<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class AtelierException extends Exception
{
    private array $structure;

    public function __construct($message, int $code = 400, $errors = [])
    {
        $this->message = $message;
        $this->code = $code;
        $this->structure = $this->structureResponse($code, $message, $errors);
    }

    public function structureResponse(int $code, string $message, array $errors = []): array
    {
        return [
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
        ];
    }

    public function render(): JsonResponse
    {
        return response()->json($this->structure, $this->code);
    }
}
