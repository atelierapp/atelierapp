<?php

namespace App\Models;

use Database\Factories\MediaTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaType extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const VIDEO = 'video';
    public const IMAGE = 'image';

    protected $fillable = [
        'name',
        'image',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

}
