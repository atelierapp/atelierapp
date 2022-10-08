<?php

namespace App\Traits\Builders;

trait CountryBuilderTrait
{
    public function country($country): static
    {
        $this->where('country', '=', $country);

        return $this;
    }
}
