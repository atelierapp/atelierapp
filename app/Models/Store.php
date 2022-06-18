<?php

namespace App\Models;

use App\Builders\StoreBuilder;
use App\Traits\Models\HasMediasRelation;
use App\Traits\Models\HasQualitiesRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JetBrains\PhpStorm\Pure;

/**
 * @mixin IdeHelperStore
 * @property bool has_active_store
 */
class Store extends Model
{
    use HasFactory;
    use HasMediasRelation;
    use HasQualitiesRelation;
    use SoftDeletes;

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
        return $this->belongsTo(User::class);
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
