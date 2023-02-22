<?php

namespace App\Models;

use App\Models\Traits\HasCouponRelation;
use App\Models\Traits\HasUserRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUse extends Model
{
    use HasFactory;
    use HasCouponRelation;
    use HasUserRelation;

    protected $table = 'coupon_uses';

    protected $fillable = [
        'coupon_id',
        'customer_id',
    ];
}
