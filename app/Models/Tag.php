<?php

namespace App\Models;

use App\Builders\TagBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperTag
 */
class Tag extends BaseModelCountry
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'active',
    ];

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    public function newEloquentBuilder($query): TagBuilder
    {
        return new TagBuilder($query);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Project::class, 'taggable');
    }
}
