<?php

namespace App\Models;

use App\Enums\ManufacturerTypeEnum;
use App\Trais\Models\HasMediasRelation;
use App\Trais\Models\HasTagsRelation;
use Carbon\Carbon;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasMediasRelation;
    use HasTagsRelation;

    protected $fillable = [
        'title',
        'manufacturer_type',
        'manufactured_at',
        'description',
        'category_id',
        'price',
        'quantity',
        'sku',
        'active',
        'properties',
    ];

    protected $casts = [
        'id' => 'integer',
        'manufactured_at' => 'date',
        'category_id' => 'integer',
        'active' => 'boolean',
        'properties' => 'array',
    ];

    protected $enums = [
        'manufacturer_type' => ManufacturerTypeEnum::class,
    ];

    public static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function materials(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    public function setManufacturedAtAttribute($value)
    {
        $this->attributes['manufactured_at'] = Carbon::parse($value)->format('Y-m-d');
    }
}
