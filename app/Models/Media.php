<?php

namespace App\Models;

use App\Models\Builders\MediaBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperMedia
 */
class Media extends Model
{
    use HasFactory;

    public const IMAGE = '1';
    public const VIDEO = '2';

    protected $fillable = [
        'type_id',
        'url',
        'path',
        'properties',
        'featured',
        'mediable_id',
        'mediable_type',
        'extra',
        'orientation',
    ];

    protected $casts = [
        'id' => 'integer',
        'type_id' => 'integer',
        'main' => 'boolean',
        'properties' => 'json',
        'extra' => 'json',
    ];

    #[Pure]
    public function newEloquentBuilder($query): MediaBuilder
    {
        return new MediaBuilder($query);
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MediaType::class);
    }

    public function product(): MorphTo
    {
        return $this->morphTo(Product::class);
    }
}
