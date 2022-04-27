<?php

namespace App\Models;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use App\Traits\Models\HasMediasRelation;
use App\Traits\Models\HasTagsRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $title
 * @property string $sku
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasMediasRelation;
    use HasTagsRelation;

    protected $fillable = [
        'title',
        'store_id',
        'manufacturer_type',
        'manufacturer_process',
        'manufactured_at',
        'description',
        'style_id',
        'price',
        'quantity',
        'sku',
        'active',
        'properties',
        'url',
    ];

    protected $casts = [
        'manufactured_at' => 'date',
        'category_id' => 'integer',
        'active' => 'boolean',
        'extra' => 'array',
    ];

    protected $enums = [
        'manufacturer_type' => ManufacturerTypeEnum::class,
        'manufacturer_process' => ManufacturerProcessEnum::class,
    ];

    public function collections(): \Illuminate\Database\Eloquent\Relations\morphToMany
    {
        return $this->morphToMany(Collection::class, 'collectionable');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class)->withDefault();
    }

    public function setManufacturedAtAttribute($value)
    {
        $this->attributes['manufactured_at'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setPropertiesAttribute($properties)
    {
        $this->attributes['properties'] = json_encode($properties);
    }

    public function getPropertiesAttribute($properties)
    {
        return json_decode($properties, true);
    }

    public function scopeSearch($query, $value)
    {
        if (empty($value)) {
            return $query;
        }

        return $query
            ->where('title', 'like', "%{$value}%")
            ->orWhereHas('style', function ($q) use ($value) {
                $q->where('name', 'like', "%{$value}%");
            });
    }
}
