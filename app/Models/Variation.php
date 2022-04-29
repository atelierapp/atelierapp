<?php

namespace App\Models;

use App\Traits\Models\HasMediasRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperVariation
 */
class Variation extends Model
{
    use HasFactory;
    use HasMediasRelation;

    protected $fillable = [
        'product_id',
        'name',
        'is_duplicated'
    ];

    protected $casts = [
        'is_duplicated' => 'boolean',
    ];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
