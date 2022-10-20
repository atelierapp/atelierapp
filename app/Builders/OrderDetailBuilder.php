<?php

namespace App\Builders;

use App\Traits\Builders\CountryBuilderTrait;
use App\Traits\Builders\WhereRawDateBetweenTrait;
use Illuminate\Database\Eloquent\Builder;

class OrderDetailBuilder extends Builder
{
    use CountryBuilderTrait;
    use WhereRawDateBetweenTrait;
}
