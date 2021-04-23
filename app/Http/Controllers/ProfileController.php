<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class ProfileController extends Controller {

    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        return $this->response(new UserResource(auth()->user()));
    }
}
