<?php

namespace App\Builders;

use App\Models\Role;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;

class OrderBuilder extends Builder
{
    public function applyFilters(array $filters): static
    {
        if (isset($filters['seller_status_id'])) {
            $this->where('seller_status_id', '=', $filters['seller_status_id']);
        }

        return $this;
    }

    public function filterByAuthenticatedRole(): static
    {
        if (Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this->where('seller_id', '=', auth()->id());
        } elseif (Bouncer::is(auth()->user())->an(Role::USER)) {
            $this->where('user_id', '=', auth()->id());
        }

        return $this;
    }
}
