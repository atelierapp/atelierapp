<?php

namespace App\Models\Builders;

use App\Models\Traits\CountryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class OrderDetailBuilder extends Builder
{
    use CountryBuilderTrait;
    use \App\Models\Traits\WhereRawDateBetweenTrait;

    public function filterByRole(): static
    {
        $this->whereHas('order', fn ($order) => $order->filterByRole());

        return $this;
    }
}
