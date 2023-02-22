<?php

namespace App\Models\Traits;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCouponRelation
{
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}