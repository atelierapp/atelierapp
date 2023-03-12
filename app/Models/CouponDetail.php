<?php

namespace App\Models;

use App\Models\Traits\HasCouponRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperCouponDetail
 */
class CouponDetail extends Model
{
    use HasFactory;
    use HasCouponRelation;

    protected $table = 'coupon_details';

    protected $fillable = [
        'coupon_id',
        'model_type',
        'model_id',
    ];

    public function counponable(): MorphTo
    {
        return $this->morphTo('model');
    }
}
