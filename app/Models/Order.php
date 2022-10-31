<?php

namespace App\Models;

use App\Builders\OrderBuilder;
use App\Traits\Models\HasSellerRelation;
use App\Traits\Models\HasUserRelation;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperOrder
 * @mixin Eloquent
 * @mixin OrderBuilder
 * @property int $id
 * @property int $seller_status_id
 * @property ?Carbon $seller_accepted_on
 * @property int|mixed $paid_status_id
 * @property ?Carbon $paid_on
 * @property ?int $seller_id
 * @property ?Carbon $seller_status_at
 * @property array|object|null $payment_gateway_metadata
 * @property int $items
 * @property $total_price
 */
class Order extends BaseModelCountry
{
    use HasFactory;
    use HasSellerRelation;
    use HasUserRelation;

    protected $fillable = [
        'parent_id',
        'user_id',
        'store_id',
        'seller_id',
        'unit_price',
        'items',
        'total_price',
        'seller_status_id',
        'seller_status_at',
        'payment_gateway_id',
        'payment_gateway_code',
        'payment_gateway_metadata',
        'paid_status_id',
        'paid_on',
        'country'
    ];

    protected $casts = [
        'payment_gateway_metadata' => 'json',
        'paid_on' => 'datetime',
    ];

    public function newEloquentBuilder($query): OrderBuilder
    {
        return New OrderBuilder($query);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function seller_status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'seller_status_id');
    }

    public function paidStatus(): BelongsTo
    {
        return $this->belongsTo(PaymentStatus::class, 'paid_status_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function subOrders(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }
}
