<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @mixin IdeHelperQuality
 */
class Quality extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function store(): MorphToMany
    {
        return $this->morphedByMany(Store::class, 'qualityable');
    }
}
