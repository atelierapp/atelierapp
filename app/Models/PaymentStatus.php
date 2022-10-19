<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin IdeHelperPaymentStatus
 */
class PaymentStatus extends Model
{
    use HasTranslations;

    public const PAYMENT_PENDING = 1;
    public const PAYMENT_APPROVAL = 2;
    public const PAYMENT_REJECT = 3;
    public const PAYMENT_PENDING_APPROVAL = 4;

    protected $table = 'payment_statuses';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $translatable = [
        'name'
    ];
}
