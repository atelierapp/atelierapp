<?php

namespace App\Trais\Models;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasMediasRelation
{
    public function featured_media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('featured', '=', true)
            ->withDefault();
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
