<?php

namespace App\Models\Builders;

use App\Models\Role;
use App\Models\Store;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;

class CouponBuilder extends Builder
{

    public function code($value): static
    {
        $this->where('code', '=', $value);

        return $this;
    }

    public function filterByRole(): static
    {
        if (Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this->where('store_id', '=', Store::where('user_id',auth()->id())->first()->id);
        }

        return $this;
    }

    public function authUser(): static
    {
        if (auth()->check() && Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this->where('store_id', auth()->id());
        }

        return $this;
    }
}