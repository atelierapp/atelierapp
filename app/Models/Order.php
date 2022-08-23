<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperOrder
 */
class Order extends Model
{
    use HasFactory;

    public const SELLER_PENDING = 1;
    public const SELLER_APPROVAL = 2;
    public const SELLER_REJECT = 3;

    public const PAYMENT_PENDING = 1;
    public const PAYMENT_APPROVAL = 2;
    public const PAYMENT_REJECT = 3;

    protected $fillable = [
        'user_id',
        'store_id',
        'seller_id',
        'items',
        'total_price',
        'is_accepted',
        'accepted_on',
        'payment_gateway_code',
        'is_paid',
        'paid_on',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function sellerOrders(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
