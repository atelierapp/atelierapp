<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class MediaBuilder extends Builder
{
    public function model(string $model): static
    {
        $this->where('mediable_type', '=', $model);

        return $this;
    }

    public function featured(): static
    {
        $this->where('featured', true);

        return $this;
    }

    public function nonFeatured(): static
    {
        $this->where('featured', false);

        return $this;
    }
}
