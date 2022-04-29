<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperMediaType
 */
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

    public static function getIdFromMimeType($mimeType): ?int
    {
        if (Str::contains($mimeType, 'video')) {
            return self::where('name', self::VIDEO)->first()->id;
        }

        if (Str::contains($mimeType, 'image')) {
            return self::where('name', self::IMAGE)->first()->id;
        }

        return null;
    }
}
