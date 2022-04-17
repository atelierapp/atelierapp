<?php

namespace App\Traits\Models;

use App\Models\Quality;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasQualitiesRelation
{
    public function qualities(): MorphToMany
    {
        return $this->morphToMany(Quality::class, 'qualityable');
    }
}
