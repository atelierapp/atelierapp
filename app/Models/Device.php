<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin \Eloquent
 */
class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'uuid',
        'user_id',
    ];

    public function shopping_cart(): BelongsToMany
    {
        return $this->morphToMany(Variation::class, 'customer')->with('product')->using(ShoppingCart::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
