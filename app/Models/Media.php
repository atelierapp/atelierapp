<?php

namespace App\Models;

use Database\Factories\MediaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'url',
        'properties',
        'main',
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

    public static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return MediaFactory::new();
    }

    public function mediable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MediaType::class);
    }
}
