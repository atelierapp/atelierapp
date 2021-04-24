<?php

namespace App\Models;

use App\Enums\ManufacturerTypeEnum;
use Carbon\Carbon;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function media(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Media::class);
    }

    public function medias(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function setManufacturedAtAttribute($value)
    {
        $this->attributes['manufactured_at'] = Carbon::parse($value)->format('Y-m-d');
    }
}
