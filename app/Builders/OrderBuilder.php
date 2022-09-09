<?php

namespace App\Builders;

use App\Models\Order;
use App\Models\Role;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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

    public function paidBetween($startDate, $endDate): static
    {
        $this->where('paid_status_id', Order::PAYMENT_APPROVAL)
            ->whereBetween(DB::raw('date(paid_on)'), [$startDate, $endDate]);

        return $this;
    }
}
