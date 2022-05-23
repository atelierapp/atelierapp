<?php

namespace App\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Traits\Builders\AuthBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class StoreBuilder extends Builder implements AuthUserContractBuilder
{
    use AuthBuilderTrait;
}
