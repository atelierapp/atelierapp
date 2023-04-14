<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class VariationBuilder extends Builder
{
    use \App\Models\Traits\CountryBuilderTrait;
}
