<?php

namespace App\Models;

use App\Traits\Models\HasMediasRelation;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperVariation
 * @mixin Eloquent
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property Product $product
 */
class Variation extends Model
{
    use HasFactory;
    use HasMediasRelation;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'is_duplicated',
    ];

    protected $casts = [
        'is_duplicated' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
