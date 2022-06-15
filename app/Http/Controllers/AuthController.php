<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\CreateUserRequest;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\ForgotPasswordRequest;
use App\Http\Requests\Authentication\ResetPasswordRequest;
use App\Http\Requests\Authentication\SocialLoginRequest;
use App\Http\Resources\UserResource;
use App\Mail\ForgotPasswordMail;
use App\Models\ForgotPassword;
use App\Models\Role;
use App\Models\User;
use App\Services\AuthService;
use App\Services\SocialService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct(
        private SocialService $socialService,
        private AuthService $authService
    ){
        //
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::firstByEmail($request->get('email'));
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException(trans('auth.failed'));
        }

        return $this->response([
            'access_token' => $user->createToken('login')->plainTextToken,
        ]);
    }

    public function socialLogin(SocialLoginRequest $request): JsonResponse
    {
        $data = $this->socialService->getDetailsFromDriver(
            (string)$request->get('social_driver'),
            (string)$request->get('social_token')
        );
        $user = $this->socialService->getUser($data->social_id);

        if (! $user) {
            return $this->response($data, __('auth.unregistered'), Response::HTTP_ACCEPTED);
        }

        return $this->response([
            'access_token' => $user->createToken('social-login')->plainTextToken,
        ], __('response.login.correct', ['user_first_name' => $user->first_name]));

    }

    public function signUp(CreateUserRequest $request): JsonResponse
    {
        $data = collect($request->validated())->except(['social_driver', 'social_id']);
        /** @var User $user */
        $user = User::query()->create($data->toArray());
        $role = $request->has('role') ? $request->get('role') : Role::USER;
        $user->assign($role);

        if ($request->has('social_driver')) {
            $user->socialAccounts()->create([
                'driver' => $request->get('social_driver'),
                'social_id' => $request->get('social_id'),
            ]);
        }

        return $this->response([
            'user' => $response ?? new UserResource($user->refresh()),
            'access_token' => $user->createToken('login')->plainTextToken,
        ], __('users.sign_up.success'), Response::HTTP_CREATED);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->response([], __('auth.logout.success'));
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        if (User::whereEmail($request->get('email'))->count()) {
            $recover = ForgotPassword::updateOrCreate([
                'email' => $request->get('email')
            ], [
                'token' => Str::random(48)
            ]);

            Mail::to($recover->email)->send(new ForgotPasswordMail($recover->token));
        }

        return $this->response([], __('passwords.sent'));
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPassword($request->validated());

        return $this->response([], __('passwords.reset'));
    }
}
