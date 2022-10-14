<?php

namespace App\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Traits\Builders\AuthBuilderTrait;
use App\Traits\Builders\CountryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class CollectionBuilder extends Builder implements AuthUserContractBuilder
{
    use AuthBuilderTrait;
    use CountryBuilderTrait;

    public function featured()
    {
        $this->where('is_featured', '=', true);

        return $this;
    }

    public function nonFeatured()
    {
        $this->where('is_featured', '=', false);

        return $this;
    }
}
