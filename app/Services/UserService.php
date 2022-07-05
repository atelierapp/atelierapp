<?php

namespace App\Services;

use App\Models\Role;
use App\Models\SocialAccount;
use App\Models\User;

class UserService
{

    public function getByActiveEmail(string $email, bool $throwable = true): User
    {
        $query = User::query()
            ->where('is_active', '=', true)
            ->where('email', '=', $email);

        return $throwable
            ? $query->firstOrFail()
            : $query->firstOrNew();
    }

    public function downAccount()
    {
        if (auth()->user()->isAn(Role::USER)) {
            $this->deleteUserAccount(auth()->user());
        }
    }

    private function deleteUserAccount(User $user): void
    {
        $user->tokens()->delete();
        SocialAccount::query()->where('user_id', $user->id)->delete();
        $user->email = md5(now());
        $user->username = null;
        $user->deleted_at = now();
        $user->save();
    }
}
