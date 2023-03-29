<?php

namespace App\Models;

use App\Models\Builders\CouponBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperCoupon
 */
class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;

    const MODE_TOTAL = 'total';
    const MODE_PRODUCT = 'product';
    const MODE_SELLER = 'seller';
    const MODE_INFLUENCER = 'influencer';

    protected $table = 'coupons';

    protected $fillable = [
        'is_active',
        'store_id',
        'code',
        'name',
        'description',
        'mode',
        'start_date',
        'end_date',
        'is_fixed',
        'amount',
        'max_uses',
        'current_uses',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_fixed' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'max_uses' => 'integer',
        'current_uses' => 'integer',
    ];

    public function newEloquentBuilder($query): CouponBuilder
    {
        return new CouponBuilder($query);
    }

    public function details(): hasMany
    {
        return $this->hasMany(CouponDetail::class);
    }

    public function appliedProducts(): hasMany
    {
        return $this->hasMany(CouponDetail::class)->where('model_type', '=', Product::class);
    }

    public function appliedUsers(): hasMany
    {
        return $this->hasMany(CouponDetail::class)->where('model_type', '=', User::class);
    }

}
