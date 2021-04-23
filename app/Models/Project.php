<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'style_id',
        'author_id',
        'forked_from',
        'published',
        'public',
    ];

    protected $casts = [
        'id' => 'integer',
        'style_id' => 'integer',
        'author_id' => 'integer',
        'forked_from' => 'integer',
        'published' => 'boolean',
        'public' => 'boolean',
    ];

    public static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return ProjectFactory::new();
    }

    public function rooms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function style(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Style::class);
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function forkedFrom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
