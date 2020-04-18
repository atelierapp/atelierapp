<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class ProfileController extends Controller {

    public function __invoke()
    {
        return $this->response(new UserResource(auth()->user()));
    }
}
