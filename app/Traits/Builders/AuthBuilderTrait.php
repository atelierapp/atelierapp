<?php

namespace App\Traits\Builders;

use function auth;

trait AuthBuilderTrait
{
    public function authUser(): static
    {
        $this->where('user_id', '=', auth()->id());

        return $this;
    }
}
