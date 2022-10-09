<?php

namespace App\Models;

use App\Builders\OrderBuilder;
use App\Traits\Models\HasSellerRelation;
use App\Traits\Models\HasUserRelation;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
    use HasSellerRelation;
    use HasUserRelation;

    public const _SELLER_PENDING = 1;
    public const _SELLER_APPROVAL = 2;
    public const _SELLER_REJECT = 3;
    public const _SELLER_SEND = 4;
    public const _SELLER_IN_TRANSIT = 5;
    public const _SELLER_DELIVERED = 6;

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

    protected function sellerStatus(): Attribute
    {
        $values = [
            Order::_SELLER_PENDING => 'Pending',
            Order::_SELLER_APPROVAL => 'Accepted',
            Order::_SELLER_REJECT => 'Reject',
            Order::_SELLER_SEND => 'Send',
            Order::_SELLER_IN_TRANSIT => 'In Transit',
            Order::_SELLER_DELIVERED => 'Delivered',
        ];

        return Attribute::get(fn () => $values[$this->seller_status_id]);
    }

    protected function paidStatus(): Attribute
    {
        $values = [
            Invoice::PAYMENT_PENDING => 'Pending',
            Invoice::PAYMENT_PENDING_APPROVAL => 'Pending Sellers Approval',
            Invoice::PAYMENT_APPROVAL => 'Accepted',
            Invoice::PAYMENT_REJECT => 'Reject',
        ];

        return Attribute::get(fn () => $values[$this->paid_status_id]);
    }
}
