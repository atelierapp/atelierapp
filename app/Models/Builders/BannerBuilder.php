<?php

namespace App\Models\Builders;

use App\Models\Traits\CountryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class BannerBuilder extends Builder
{
    use CountryBuilderTrait;
}
