<?php

namespace App\Models;

use App\Models\Builders\CouponBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Coupon extends Model
{
    use HasFactory;

    const TOTAL = 'total';
    const PRODUCT = 'product';

    protected $table = 'coupons';

    protected $fillable = [
        'is_active',
        'code',
        'name',
        'description',
        'start_date',
        'end_date',
        'is_fixed',
        'amount',
        'max_uses',
        'current_uses',
        'stock',
        'mode',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function newEloquentBuilder($query): CouponBuilder
    {
        return new CouponBuilder($query);
    }

    public function details(): hasMany
    {
        return $this->hasMany(CouponDetail::class);
    }

    /**
     * Determine if this coupon can be applied
     *
     * @return bool
     */
    public function canApply(): bool
    {
        return $this->is_active && $this->canUse() && $this->isValid();
    }

    /**
     * Determine if this coupon has available uses
     *
     * @return bool
     */
    public function canUse(): bool
    {
        return (int) $this->max_uses > (int) $this->current_uses;
    }

    /**
     * Determine if this coupon your dates are valid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return now()->betweenIncluded($this->start_date, $this->end_date->isEndOfDay());
    }
}
