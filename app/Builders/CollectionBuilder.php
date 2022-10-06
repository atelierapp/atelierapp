<?php

namespace App\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Traits\Builders\AuthBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class CollectionBuilder extends Builder implements AuthUserContractBuilder
{
    use AuthBuilderTrait;

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
