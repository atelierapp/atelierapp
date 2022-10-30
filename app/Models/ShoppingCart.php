<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin Eloquent
 * @property Variation $variation
 * @property User $user
 * @property int $user_id
 * @property int $variation_id
 * @property int $quantity
 * @mixin IdeHelperShoppingCart
 */
class ShoppingCart extends MorphPivot
{
    use HasFactory;

    protected $table = 'shopping_cart';

    public $timestamps = false;

    protected $fillable = [
        'customer_type',
        'customer_id',
        'variation_id',
        'quantity',
        'country',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function customer(): MorphTo
    {
        return $this->morphTo();
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class);
    }
}
