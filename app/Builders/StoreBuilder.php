<?php

namespace App\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Traits\Builders\AuthBuilderTrait;
use App\Traits\Builders\CountryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class StoreBuilder extends Builder implements AuthUserContractBuilder
{
    use AuthBuilderTrait;
    use CountryBuilderTrait;
}
