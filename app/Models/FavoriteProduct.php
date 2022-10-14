<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperFavoriteProduct
 */
class FavoriteProduct extends Model
{
    use HasFactory;

    protected $table = 'favorite_products';

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public $timestamps = false;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
