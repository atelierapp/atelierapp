<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileImageRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\MediaService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __construct(
        private MediaService $mediaService,
        private UserService $userService
    ) {
        //
    }

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

    public function image(ProfileImageRequest $request)
    {
        $user = auth()->user();
        $user->load('featured_media');

        $this->mediaService->delete($user->featured_media->path);
        $this->mediaService->model($user)->path('users');
        $media = $this->mediaService->saveImage($request->file('avatar'));

        $user->fill([
           'avatar' => $media->url,
        ]);
        $user->save();

        return UserResource::make($user);
    }

    public function destroy()
    {
        $this->userService->downAccount();

        return response()->json([], 204);
    }
}
