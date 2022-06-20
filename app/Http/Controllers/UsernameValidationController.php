<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsernameValidationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class UsernameValidationController extends Controller
{
    public function __invoke(UsernameValidationRequest $request): JsonResponse
    {
        $username = (string)Str::of($request->get('username'))->remove('.')->lower();

        return $this->response([
           'is_available' => ! User::query()
               ->whereRaw("REPLACE(LOWER(username), '.', '') LIKE ?", [$username])
               ->exists(),
        ]);
    }
}
