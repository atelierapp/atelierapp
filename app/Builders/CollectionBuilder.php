<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class CollectionBuilder extends Builder
{
    public function authUser(): static
    {
        $this->where('user_id', '=', auth()->user()->id);

        return $this;
    }
}
