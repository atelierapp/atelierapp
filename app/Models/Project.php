<?php

namespace App\Models;

use App\Trais\Models\HasMediasRelation;
use App\Trais\Models\HasTagsRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property array|mixed settings
 */
class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasMediasRelation;
    use HasTagsRelation;

    protected $fillable = [
        'name',
        'style_id',
        'author_id',
        'forked_from_id',
        'published',
        'public',
        'settings',
    ];

    protected $casts = [
        'id' => 'integer',
        'style_id' => 'integer',
        'author_id' => 'integer',
        'forked_from' => 'integer',
        'published' => 'boolean',
        'public' => 'boolean',
        'settings' => 'array',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function forkedFrom(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'forked_from_id');
    }

    public function scopeSearch($query, $value)
    {
        if (empty($value)) {
            return $query;
        }

        return $query
            ->where('name', 'like', "%{$value}%")
            ->orWhereHas('style', function ($q) use ($value) {
                $q->where('name', 'like', "%{$value}%");
            })
            ->orWhereHas('author', function ($q) use ($value) {
                $q->where('first_name', 'like', "%{$value}%")
                    ->orWhere('last_name', 'like', "%{$value}%");
            });
    }
}
