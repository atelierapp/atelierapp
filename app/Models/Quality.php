<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin IdeHelperQuality
 */
class Quality extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'name',
        'score',
    ];

    protected $translatable = [
        'name',
    ];

    public function store(): MorphToMany
    {
        return $this->morphedByMany(Store::class, 'qualityable');
    }

    public function product(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'qualityable');
    }
}
