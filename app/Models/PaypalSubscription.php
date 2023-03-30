<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperPaypalSubscription
 */
class PaypalSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'paypal_plan_id',
        'subscribable_type',
        'subscribable_id',
        'external_subscription_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(PaypalPlan::class);
    }

    public function subscribable(): MorphTo
    {
        return $this->morphTo();
    }
}
