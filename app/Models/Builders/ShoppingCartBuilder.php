<?php

namespace App\Models\Builders;

use App\Models\Traits\CountryBuilderTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ShoppingCartBuilder extends Builder
{
    use CountryBuilderTrait;

    public function customer(int|string $customerId): ShoppingCartBuilder
    {
        $this
            ->where('customer_type', User::class)
            ->where('customer_id', $customerId);

        return $this;
    }

}
