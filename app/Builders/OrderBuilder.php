<?php

namespace App\Builders;

use App\Models\Invoice;
use App\Models\Role;
use App\Traits\Builders\CountryBuilderTrait;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OrderBuilder extends Builder
{
    use CountryBuilderTrait;

    public function applyFilters(array $filters): static
    {
        if (isset($filters['seller_status_id'])) {
            $this->where('seller_status_id', '=', $filters['seller_status_id']);
        }

        if (isset($filters['store_id'])) {
            $this->where('store_id', '=', $filters['store_id']);
        }

        return $this;
    }

    public function filterByAuthenticatedRole(): static
    {
        if (Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this->where('seller_id', '=', auth()->id());
        } elseif (Bouncer::is(auth()->user())->an(Role::USER)) {
            $this->where('user_id', '=', auth()->id())
                ->whereNotNull('parent_id');
        }

        return $this;
    }

    public function paidBetween($startDate, $endDate): static
    {
        $this->where('paid_status_id', Invoice::PAYMENT_APPROVAL)
            ->whereBetween(DB::raw('date(paid_on)'), [$startDate, $endDate]);

        return $this;
    }

    public function paymentGateway($paymentId, $paymentCode): static
    {
        $this->where('payment_gateway_id', $paymentId)
            ->where('payment_gateway_code', $paymentCode);

        return $this;
    }
}
