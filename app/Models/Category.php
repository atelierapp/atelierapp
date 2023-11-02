<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    use HasFactory;
    use HasTranslations;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'image',
        'parent_id',
        'active',
    ];

    protected $translatable = [
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'active' => 'boolean',
        'properties' => 'json',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function sub_categories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function setPropertiesAttribute($properties)
    {
        $this->attributes['properties'] = json_encode($properties);
    }

    public function getPropertiesAttribute($properties)
    {
        return json_decode($properties, true);
    }

    protected function getWixAttribute(): string
    {
        return $this->properties
            ? Arr::get($this->properties, 'wix', '')
            : '';
    }
}
