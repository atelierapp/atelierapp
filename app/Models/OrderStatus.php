<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin IdeHelperOrderStatus
 */
class OrderStatus extends Model
{
    use HasTranslations;

    protected $table = 'order_statuses';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $translatable = [
        'name'
    ];
}
