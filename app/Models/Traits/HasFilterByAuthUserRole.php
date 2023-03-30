<?php

namespace App\Models\Traits;

use App\Models\Role;
use Bouncer;

trait HasFilterByAuthUserRole
{
    public function filterByAuthenticatedUserRole(): static
    {
        if (auth()->check() && Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this->whereHas('store', fn ($has) => $has->where('user_id', '=', auth()->id()));
        }

        return $this;
    }
}