<?php

namespace App\Models;

use App\Models\Builders\BannerBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperBanner
 */
class Banner extends BaseModelCountry
{
    use HasFactory;
    use Traits\HasMediasRelation;

    public const TYPE_POPUP = 'popup';
    public const TYPE_CAROUSEL = 'carousel';

    protected $fillable = [
        'name',
        'order',
        'segment',
        'type',
        'country',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'order' => 'integer',
        'segment' => 'string',
        'type' => 'string',
    ];

    public function newEloquentBuilder($query): BannerBuilder
    {
        return new BannerBuilder($query);
    }

}
