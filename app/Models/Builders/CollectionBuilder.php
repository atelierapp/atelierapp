<?php

namespace App\Models\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Models\Traits\AuthBuilderTrait;
use App\Models\Traits\CountryBuilderTrait;
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
