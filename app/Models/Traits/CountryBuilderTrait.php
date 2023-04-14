<?php

namespace App\Models\Traits;

trait CountryBuilderTrait
{
    public function country($country): static
    {
        $this->where('country', '=', $country);

        return $this;
    }
}
