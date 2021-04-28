<?php

namespace App\Models;

use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'active',
        'taggable_type',
        'taggable_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    public static function newFactory(): Factory
    {
        return TagFactory::new();
    }

    public function taggable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

}
