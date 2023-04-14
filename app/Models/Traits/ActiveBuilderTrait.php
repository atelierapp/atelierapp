<?php

namespace App\Models\Traits;

trait ActiveBuilderTrait
{
    public string $activeColumn = 'is_active';

    public function active(): static
    {
        $this->where($this->activeColumn, '=', true);

        return $this;
    }
}
