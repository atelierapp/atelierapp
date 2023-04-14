<?php

namespace App\Models;

use App\Models\Builders\VariationBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property Product $product
 * @mixin IdeHelperVariation
 */
class Variation extends BaseModelCountry
{
    use HasFactory;
    use Traits\HasMediasRelation;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'is_duplicated',
        'country',
    ];

    protected $casts = [
        'is_duplicated' => 'boolean',
    ];

    public function newEloquentBuilder($query): VariationBuilder
    {
        return new VariationBuilder($query);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
