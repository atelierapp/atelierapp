<?php

namespace App\Builders;

use App\Models\Role;
use App\Traits\Builders\WhereRawDateBetweenTrait;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;

class ProductViewBuilder extends Builder
{
    use WhereRawDateBetweenTrait;

    public function authUser(): static
    {
        if (auth()->check() && Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this
                ->join('products', 'product_views.product_id', '=', 'products.id')
                ->join('stores', fn ($join) => $join->on('products.store_id', '=', 'stores.id')
                    ->where('stores.user_id', '=', auth()->id()));
        }

        return $this;
    }
}
