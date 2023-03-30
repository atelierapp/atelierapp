<?php

namespace App\Builders;

use App\Models\PaymentStatus;
use App\Models\Role;
use App\Traits\Builders\CountryBuilderTrait;
use App\Traits\Builders\WhereRawDateBetweenTrait;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OrderBuilder extends Builder
{
    use CountryBuilderTrait;
    use WhereRawDateBetweenTrait;

    public function applyFilters(array $filters): static
    {
        if (isset($filters['seller_status_id'])) {
            $this->where('seller_status_id', '=', $filters['seller_status_id']);
        }

        if (isset($filters['store_id'])) {
            $this->where('store_id', '=', $filters['store_id']);
        }

        if (isset($filters['start_date'])) {
            $this->whereDatBetween('created_at', $filters['start_date'], $filters['end_date']);
        }

        return $this;
    }

    public function filterByRole(): static
    {
        if (Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this->where('seller_id', '=', auth()->id());
        } elseif (Bouncer::is(auth()->user())->an(Role::USER)) {
            $this->where('user_id', '=', auth()->id())->whereNull('parent_id');
        }

        return $this;
    }

    public function paidBetween($startDate, $endDate): static
    {
        $this->where('paid_status_id', PaymentStatus::PAYMENT_APPROVAL)
            ->whereBetween(DB::raw('date(paid_on)'), [$startDate, $endDate]);

        return $this;
    }

    public function whereDatBetween($field, $startDate, $endDate): static
    {
        $this->whereBetween(DB::raw('date(' . $field . ')'), [$startDate, $endDate]);

        return $this;
    }

    public function paymentGateway($paymentId, $paymentCode): static
    {
        $this->where('payment_gateway_id', $paymentId)
            ->where('payment_gateway_code', $paymentCode);

        return $this;
    }

    public function sellerStatus(int|array $statusId): static
    {
        if (is_array($statusId)) {
            $this->whereIn('seller_status_id', $statusId);
        } else {
            $this->where('seller_status_id', $statusId);
        }

        return $this;
    }

    public function paidStatus(int|array $statusId): static
    {
        if (is_array($statusId)) {
            $this->whereIn('paid_status_id', $statusId);
        } else {
            $this->where('paid_status_id', $statusId);
        }

        return $this;
    }
}
