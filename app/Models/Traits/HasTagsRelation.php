<?php

namespace App\Models\Traits;

use App\Models\Tag;

trait HasTagsRelation
{
    public function tags(): \Illuminate\Database\Eloquent\Relations\morphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
