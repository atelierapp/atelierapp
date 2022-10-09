<?php

namespace App\Builders;

use App\Traits\Builders\CountryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class OrderDetailBuilder extends Builder
{
    use CountryBuilderTrait;
}
