<?php

namespace App\Trais\Models;

use App\Models\Tag;

trait HasTagsRelation
{

    public function tags(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

}
