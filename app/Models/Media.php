<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'url',
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

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MediaType::class);
    }

    public function getUrlAttribute(): ?string
    {
        if (empty($this->attributes['url'])) {
            return null;
        }

        return Storage::disk('s3')->url($this->attributes['url']);
    }

}
