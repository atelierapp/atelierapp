<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

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

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MediaType::class);
    }
}
