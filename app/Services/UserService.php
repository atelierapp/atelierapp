<?php

namespace App\Services;

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
}
