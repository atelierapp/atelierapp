<?php

namespace App\Models;

use App\Builders\ProjectBuilder;
use App\Traits\Models\HasMediasRelation;
use App\Traits\Models\HasTagsRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperProject
 */
class Project extends BaseModelCountry
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
    ];

    public function newEloquentBuilder($query): ProjectBuilder
    {
        return new ProjectBuilder($query);
    }

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
}
