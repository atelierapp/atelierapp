<?php

namespace App\Models;

use App\Models\Traits\HasUserRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperProductQualification
 */
class ProductQualification extends Model
{
    use HasFactory;
    use HasUserRelation;

    protected $table = 'product_qualifications';

    protected $fillable = [
        'user_id',
        'product_id',
        'score',
        'comment',
    ];

    public function files(): HasMany
    {
        return $this->hasMany(ProductQualificationFiles::class, 'product_qualification_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
