<?php

namespace App\Builders;

use App\Traits\Builders\CountryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class BannerBuilder extends Builder
{
    use CountryBuilderTrait;
}
