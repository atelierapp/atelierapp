<?php

namespace App\Models;

use App\Models\Builders\CollectionBuilder;
use App\Models\Traits\HasMediasRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use JetBrains\PhpStorm\Pure;

/**
 * @mixin IdeHelperCollection
 */
class Collection extends BaseModelCountry
{
    use HasFactory;
    use HasMediasRelation;

    protected $fillable = [
        'name',
        'is_active',
        'user_id',
        'is_featured',
        'country',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    #[Pure]
    public function newEloquentBuilder($query): CollectionBuilder
    {
        return new CollectionBuilder($query);
    }

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'collectionable');
    }
}
