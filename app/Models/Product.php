<?php

namespace App\Models;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use App\Models\Builders\ProductBuilder;
use App\Models\Traits\HasMediasRelation;
use App\Models\Traits\HasQualitiesRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\morphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperProduct
 */
class Product extends BaseModelCountry
{
    use HasFactory;
    use SoftDeletes;
    use HasMediasRelation;
    use HasQualitiesRelation;
    use Traits\HasTagsRelation;

    protected $fillable = [
        'title',
        'store_id',
        'score',
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
        'is_on_demand',
        'is_unique',
        'country',
        'has_discount',
        'is_discount_fixed',
        'discount_value',
        'discounted_amount',
    ];

    protected $casts = [
        'manufactured_at' => 'date',
        'category_id' => 'integer',
        'active' => 'boolean',
        'extra' => 'array',
        'is_on_demand' => 'boolean',
        'is_unique' => 'boolean',
        'has_discount' => 'boolean',
        'is_discount_fixed' => 'boolean',
        'discount_start' => 'date',
        'discount_end' => 'date',
    ];

    protected $enums = [
        'manufacturer_type' => ManufacturerTypeEnum::class,
        'manufacturer_process' => ManufacturerProcessEnum::class,
    ];

    public function newEloquentBuilder($query): ProductBuilder
    {
        return new ProductBuilder($query);
    }

    public function authFavorite(): HasOne
    {
        return $this->hasOne(FavoriteProduct::class, 'product_id', 'id')
            ->where('user_id', '=', request()->user('sanctum')->id);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function collections(): morphToMany
    {
        return $this->morphToMany(Collection::class, 'collectionable');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(FavoriteProduct::class, 'product_id');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function qualifications(): HasMany
    {
        return $this->hasMany(ProductQualification::class, 'product_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class)->withDefault();
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }

    public function setManufacturedAtAttribute($value)
    {
        $this->attributes['manufactured_at'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function setPropertiesAttribute($properties)
    {
        $this->attributes['properties'] = json_encode($properties);
    }

    public function getPropertiesAttribute($properties)
    {
        return json_decode($properties, true);
    }

    protected function discountedAmount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    protected function finalPrice(): Attribute
    {
        return new Attribute(get: function ($value) {
            if (is_null($this->discount_start) && is_null($this->discount_end)) {
                return $this->price - $this->discounted_amount;
            }

            if (now()->lte($this->discount_start) || now()->gte($this->discount_end)) {
                return $this->price;
            }

            return $this->price - $this->discounted_amount;
        });
    }

}
