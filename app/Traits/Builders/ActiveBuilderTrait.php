<?php

namespace App\Traits\Builders;

use function auth;

trait ActiveBuilderTrait
{
    public string $activeColumn = 'is_active';

    public function active(): static
    {
        $this->where($this->activeColumn, '=', true);

        return $this;
    }
}
