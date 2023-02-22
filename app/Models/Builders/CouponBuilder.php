<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class CouponBuilder extends Builder
{
    public function code($value): static
    {
        $this->where('code', '=', $value);

        return $this;
    }
}