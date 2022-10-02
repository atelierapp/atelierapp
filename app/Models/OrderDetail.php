<?php

namespace App\Models;

use App\Traits\Models\HasOrderRelation;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperOrderDetail
 */
class OrderDetail extends Model
{
    use HasFactory;
    use HasOrderRelation;

    protected $fillable = [
        'order_id',
        'product_id',
        'variation_id',
        'unit_price',
        'quantity',
        'total_price', // TODO : evaluate if this value store in database or calculate by accessor
        'seller_status_id',
        'seller_status_at',
        'seller_notes',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class);
    }

    protected function sellerStatus(): Attribute
    {
        $values = [
            Order::_SELLER_PENDING => 'Pending',
            Order::_SELLER_APPROVAL => 'Accepted',
            Order::_SELLER_REJECT => 'Reject',
        ];

        return Attribute::get(fn () => $values[$this->seller_status_id]);
    }
}
