<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductQualification extends Model
{
    use HasFactory;

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
