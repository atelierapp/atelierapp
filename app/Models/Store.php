<?php

namespace App\Models;

use App\Builders\StoreBuilder;
use App\Traits\Models\HasMediasRelation;
use App\Traits\Models\HasQualitiesRelation;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JetBrains\PhpStorm\Pure;

/**
 * @mixin Eloquent
 * @property int|null user_id
 * @property string name
 * @property string story
 * @property int customer_rating
 * @property int internal_rating
 * @property string|null logo
 * @property string|null cover
 * @property string|null team
 * @property bool active
 * @property string|null stripe_connect_id
 * @property string vendor_mode
 * @property bool has_active_store
 * @mixin IdeHelperStore
 */
class Store extends BaseModelCountry
{
    use HasFactory;
    use HasMediasRelation;
    use HasQualitiesRelation;
    use SoftDeletes;

    public const VENDOR_MODE_SUBSCRIPTION = 'subscription';
    public const VENDOR_MODE_COMMISSION = 'commission';

    protected $fillable = [
        'user_id',
        'name',
        'story',
        'logo',
        'cover',
        'team',
        'active',
        'stripe_connect_id',
        'customer_rating',
        'internal_rating',
        'website',
        'country',
    ];

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    #[Pure]
    public function newEloquentBuilder($query): StoreBuilder
    {
        return new StoreBuilder($query);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userRatings(): HasMany
    {
        return $this->hasMany(StoreUserRating::class, 'store_id');
    }

    public function scopeSearch($query, $value)
    {
        return empty($value)
            ? $query
            : $query
                ->where('name', 'like', "%{$value}%")
                ->orWhere('legal_name', 'like', "%{$value}%")
                ->orWhere('team', 'like', "%{$value}%");
    }

    public function getLogoAttribute(): ?string
    {
        return $this->getFromMedia('logo');
    }

    public function getCoverAttribute(): ?string
    {
        return $this->getFromMedia('cover');
    }

    public function getTeamAttribute(): ?string
    {
        return $this->getFromMedia('team');
    }

    private function getFromMedia(string $type): ?string
    {
        $file = $this->loadMissing('medias')
            ->medias
            ->where('orientation', '=', $type)
            ->first();

        return empty($file)
            ? null
            : $file->url;
    }

    public function getHasActiveStoreAttribute(): bool
    {
        return ! is_null($this->stripe_connect_id);
    }
}
