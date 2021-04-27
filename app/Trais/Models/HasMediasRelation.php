<?php

namespace App\Trais\Models;

use App\Models\Media;

trait HasMediasRelation
{

    public function featured_media(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('featured', '=', true);
    }

    public function medias(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

}
