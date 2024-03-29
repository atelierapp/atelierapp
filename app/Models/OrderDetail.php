<?php

namespace App\Models;

use App\Models\Builders\OrderDetailBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Eloquent
 * @mixin IdeHelperOrderDetail
 */
class OrderDetail extends BaseModelCountry
{
    use HasFactory;
    use Traits\HasOrderRelation;

    protected $fillable = [
        'order_id',
        'product_id',
        'variation_id',
        'unit_price',
        'quantity',
        'total_price', // TODO : evaluate if this value store in database or calculate by accessor
        'total_revenue',
        'seller_status_id',
        'seller_status_at',
        'seller_notes',
        'country',
        'discount_amount',
        'final_price',
    ];

    protected $casts = [
        'total_price' => 'double'
    ];

    public function newEloquentBuilder($query): OrderDetailBuilder
    {
        return new OrderDetailBuilder($query);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sellerStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'seller_status_id');
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class);
    }

}
