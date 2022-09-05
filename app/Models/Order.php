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

    public const SELLER_PENDING = 1;
    public const SELLER_APPROVAL = 2;
    public const SELLER_REJECT = 3;

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
        'payment_gateway_code',
        'paid_status_id',
        'paid_on',
    ];

    public function newEloquentBuilder($query): OrderBuilder
    {
        return New OrderBuilder($query);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function parent(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    protected function sellerStatus(): Attribute
    {
        $values = [
            Order::SELLER_PENDING => 'Pending',
            Order::SELLER_APPROVAL => 'Accepted',
            Order::SELLER_REJECT => 'Reject',
        ];

        return Attribute::get(fn () => $values[$this->seller_status_id]);
    }
}
