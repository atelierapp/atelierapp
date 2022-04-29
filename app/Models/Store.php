<?php

namespace App\Models;

use App\Traits\Models\HasMediasRelation;
use App\Traits\Models\HasQualitiesRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperStore
 */
class Store extends Model
{
    use HasFactory;
    use HasMediasRelation;
    use HasQualitiesRelation;
    use SoftDeletes;

    protected $fillable = [
        'name',
        // 'legal_name',
        // 'legal_id',
        'story',
        'logo',
        'cover',
        'team',
        'active',
    ];

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
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
}
