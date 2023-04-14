<?php

namespace App\Models;

use App\Models\Traits\HasOrderRelation;
use App\Models\Traits\HasSellerRelation;
use App\Models\Traits\HasUserRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperInvoice
 */
class Invoice extends BaseModelCountry
{
    use HasFactory;
    use HasOrderRelation;
    use HasSellerRelation;
    use HasUserRelation;

    protected $fillable = [
        'order_id',
        'user_id',
        'store_id',
        'seller_id',
        'items',
        'total_price',
        'payment_gateway_id',
        'payment_gateway_code',
        'paid_status_id',
        'paid_on',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
