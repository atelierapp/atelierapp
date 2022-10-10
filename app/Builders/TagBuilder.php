<?php

namespace App\Builders;

use App\Traits\Builders\CountryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class TagBuilder extends Builder
{
    use CountryBuilderTrait;
}
