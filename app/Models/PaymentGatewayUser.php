<?php

namespace App\Models;

use App\Models\Traits\HasUserRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPaymentGatewayUser
 */
class PaymentGatewayUser extends Model
{
    use HasFactory;
    use HasUserRelation;

    protected $table = 'payment_gateway_user';

    protected $fillable = [
        'user_id',
        'payment_gateway_id',
        'properties',
    ];

    protected $casts = [
        'properties' => 'json',
    ];
}
