<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductQualificationFiles extends Model
{
    use HasFactory;

    protected $table = 'product_qualifications_files';

    protected $fillable = [
        'product_qualification_id',
        'type_id',
        'url',
    ];

    public function productRating(): BelongsTo
    {
        return $this->belongsTo(ProductQualification::class, 'product_qualification_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MediaType::class)->withDefault();
    }
}
