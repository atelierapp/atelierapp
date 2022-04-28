<?php

namespace App\Models;

use App\Builders\CollectionBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use JetBrains\PhpStorm\Pure;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'user_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
