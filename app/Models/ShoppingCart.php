<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin Eloquent
 * @property Variation $variation
 * @property User $user
 * @property int $user_id
 * @property int $variation_id
 * @property int $quantity
 * @mixin IdeHelperShoppingCart
 */
class ShoppingCart extends Pivot
{
    use HasFactory;

    protected $table = 'shopping_cart';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'variation_id',
        'quantity',
        'country',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(Variation::class);
    }
}
