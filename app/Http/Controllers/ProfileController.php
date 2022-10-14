<?php

namespace App\Http\Controllers;

use App\Exceptions\AtelierException;
use App\Http\Requests\Authentication\ChangePasswordRequest;
use App\Http\Requests\ProfileImageRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Services\MediaService;
use App\Services\UserService;
use Bouncer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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

    public function terms()
    {
        $user = auth()->user();

        if (!Bouncer::is($user)->a(Role::SELLER)) {
            throw new AtelierException(__('errors.profile.terms'), Response::HTTP_UNAUTHORIZED);
        }

        $user->is_accepted_terms = true;
        $user->save();

        return UserResource::make($user);
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        if (! Hash::check($request->get('old_password'), auth()->user()->password)) {
            return throw new AtelierException(__('passwords.changePassword'), 422);
        }

        $user = auth()->user();
        $user->password = $request->get('password');
        $user->save();

        return response()->json([
            'data' => [
                'message' => __('passwords.changedPassword'),
            ],
        ], 200);
    }

    public function destroy()
    {
        $this->userService->downAccount();

        return response()->json([], 204);
    }
}
