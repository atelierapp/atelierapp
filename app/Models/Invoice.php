<?php

namespace App\Models;

use App\Traits\Models\HasOrderRelation;
use App\Traits\Models\HasSellerRelation;
use App\Traits\Models\HasUserRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperInvoice
 */
class Invoice extends Model
{
    use HasFactory;
    use HasOrderRelation;
    use HasSellerRelation;
    use HasUserRelation;

    public const PAYMENT_PENDING = 1;
    public const PAYMENT_APPROVAL = 2;
    public const PAYMENT_REJECT = 3;
    public const PAYMENT_PENDING_APPROVAL = 4;

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
