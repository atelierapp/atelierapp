<?php

namespace App\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Traits\Builders\ActiveBuilderTrait;
use App\Traits\Builders\AuthBuilderTrait;
use App\Traits\Builders\CountryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class StoreBuilder extends Builder implements AuthUserContractBuilder
{
    use AuthBuilderTrait;
    use CountryBuilderTrait;
    use ActiveBuilderTrait;

    public function __construct(QueryBuilder $query)
    {
        parent::__construct($query);
        $this->activeColumn = 'active';
    }
}
