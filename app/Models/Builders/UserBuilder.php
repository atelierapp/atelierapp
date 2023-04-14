<?php

namespace App\Models\Builders;

use App\Models\Traits\CountryBuilderTrait;
use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    use CountryBuilderTrait;
}
