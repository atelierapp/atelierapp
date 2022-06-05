<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\ForgotPassword;
use Illuminate\Support\Facades\Password;

class AuthService
{
    public function __construct(private UserService $userService)
    {
        //
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function resetPassword(array $params)
    {
        $token = $this->getByToken($params['token']);
        if (!$token->exists || $token->email != $params['email']) {
            throw new AtelierException(__('passwords.token'), 422);
        }

        $user = $this->userService->getByActiveEmail($params['email'], false);
        if (!$user->exists) {
            throw new AtelierException(__('passwords.user'), 422);
        }

        $user->password = $params['password'];
        $user->save();
        $token->delete();

    }

    private function getByToken(string $token): ForgotPassword
    {
        return ForgotPassword::query()->where('token', '=', $token)->firstOrNew();
    }
}
