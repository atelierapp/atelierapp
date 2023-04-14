<?php

namespace App\Models\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Models\Traits\ActiveBuilderTrait;
use App\Models\Traits\AuthBuilderTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class StoreBuilder extends Builder implements AuthUserContractBuilder
{
    use AuthBuilderTrait;
    use \App\Models\Traits\CountryBuilderTrait;
    use ActiveBuilderTrait;

    public function __construct(QueryBuilder $query)
    {
        parent::__construct($query);
        $this->activeColumn = 'active';
    }


    public function search($value): StoreBuilder
    {
        if (! empty($value)) {
            $this->where('name', 'like', "%{$value}%")
                ->orWhere('team', 'like', "%{$value}%");
        }

        return $this;
    }
}
