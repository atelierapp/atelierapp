<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{

    public function __invoke(): JsonResponse
    {
        return $this->response(new UserResource(auth()->user()));
    }

}
