<?php

namespace App\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Models\Role;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;

class ProductBuilder extends Builder implements AuthUserContractBuilder
{
    public function authUser(): static
    {
        if (Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this->whereHas('store', fn ($has) => $has->where('user_id', '=', auth()->id()));
        }

        return $this;
    }
}
