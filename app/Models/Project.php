<?php

namespace App\Models;

use App\Models\Builders\ProjectBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @property ?array $orders
 * @mixin IdeHelperProject
 */
class Project extends BaseModelCountry
{
    use HasFactory;
    use SoftDeletes;
    use Traits\HasMediasRelation;
    use Traits\HasTagsRelation;

    protected $fillable = [
        'name',
        'style_id',
        'author_id',
        'forked_from_id',
        'published',
        'public',
        'settings',
        'image',
        'country',
    ];

    protected $casts = [
        'id' => 'integer',
        'style_id' => 'integer',
        'author_id' => 'integer',
        'forked_from' => 'integer',
        'published' => 'boolean',
        'public' => 'boolean',
        'settings' => 'array',
        'orders' => 'array',
    ];

    public function newEloquentBuilder($query): ProjectBuilder
    {
        return new ProjectBuilder($query);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function forkedFrom(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'forked_from_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(ProductProject::class, 'project_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
    }
}
