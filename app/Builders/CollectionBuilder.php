<?php

namespace App\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use Illuminate\Database\Eloquent\Builder;

class CollectionBuilder extends Builder implements AuthUserContractBuilder
{
    public function authUser(): static
    {
        $this->where('user_id', '=', auth()->user()->id);

        return $this;
    }
}
