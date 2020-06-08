<?php

namespace App\Models;

use App\Enums\ManufacturerTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Enum\Laravel\HasEnums;

class Product extends Model
{
    use SoftDeletes, HasEnums;

    protected $fillable = [
        'store_id',
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
        'store_id' => 'integer',
        'manufacturer_type' => 'integer',
        'category_id' => 'integer',
        'active' => 'boolean',
        'properties' => 'array',
    ];

    protected $enums = [
        'manufacturer_type' => ManufacturerTypeEnum::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function media()
    {
        return $this->hasOne(Media::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
