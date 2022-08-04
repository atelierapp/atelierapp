<?php

namespace App\Builders;

use App\Models\Role;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductViewBuilder extends Builder
{
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

    public function whereRawDateBetween(string $column, array $values, $boolean = 'and')
    {
        $this->whereBetween(DB::raw('DATE('.$column.')'), $values, $boolean);

        return $this;
    }

    public function orWhereRawDateBetween(string $column, array $values)
    {
        $this->whereRawDateBetween($column, $values, 'or');

        return $this;
    }
}
