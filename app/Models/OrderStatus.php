<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin IdeHelperOrderStatus
 * @property string $name
 */
class OrderStatus extends Model
{
    use HasTranslations;

    public const _SELLER_PENDING = 1;
    public const _SELLER_APPROVAL = 2;
    public const _SELLER_REJECT = 3;
    public const _SELLER_SEND = 4;
    public const _SELLER_IN_TRANSIT = 5;
    public const _SELLER_DELIVERED = 6;

    protected $table = 'order_statuses';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $translatable = [
        'name'
    ];
}
