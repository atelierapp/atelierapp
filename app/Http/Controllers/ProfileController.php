<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        return $this->response(new UserResource(auth()->user()));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        $user->fill($request->validated());
        $user->save();

        return UserResource::make($user);
    }
}
