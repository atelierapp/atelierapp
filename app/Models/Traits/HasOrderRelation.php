<?php

namespace App\Models\Traits;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOrderRelation
{
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
