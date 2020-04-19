<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\CreateUserRequest;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\SocialLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Services\SocialService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    /**
     * @param \App\Http\Requests\Authentication\LoginRequest $request
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::firstByEmailOrUsername($request->get('username'));

        if ( ! $user || ! Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException(trans('auth.failed'));
        }

        return response()->json(['data' => [
            'access_token' => $user->createToken('login')->plainTextToken,
        ]]);
    }

    public function socialLogin(SocialLoginRequest $request)
    {
        $data = SocialService::getDetailsFromDriver($request->get('social_driver'), $request->get('social_token'));
        $user = SocialService::getUser($data->social_id);

        if ( ! $user) {
            return $this->response($data, __('auth.unregistered'), Response::HTTP_ACCEPTED);
        }

        return $this->response([
            'access_token' => $user->createToken('social-login')->plainTextToken,
        ], __('response.login.correct', ['user_first_name' => $user->first_name]));

    }

    public function signUp(CreateUserRequest $request)
    {
        $data = collect($request->validated())->except(['social_driver', 'social_id']);
        $user = User::query()->create($data->toArray());
        $user->assignRole(Role::USER);

        if ($request->has('social_driver')) {
            $user->socialAccounts()->create([
                'driver'    => $request->get('social_driver'),
                'social_id' => $request->get('social_id'),
            ]);
        }

        return $this->response([
            'user'         => $response ?? new UserResource($user->refresh()),
            'access_token' => $user->createToken('login')->plainTextToken,
        ], __('users.sign_up.success'), Response::HTTP_CREATED);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->response([], __('auth.logout.success'));
    }
}
