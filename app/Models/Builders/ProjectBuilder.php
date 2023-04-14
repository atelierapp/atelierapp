<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ProjectBuilder extends Builder
{
    use \App\Models\Traits\CountryBuilderTrait;

    public function authUser(int $userId = null): static
    {
        $this->where('author_id', '=', $userId ?: auth()->id());

        return $this;
    }

    public function search($value): static
    {
        if (! empty($value)) {
            $this
                ->where('name', 'like', "%{$value}%")
                ->orWhereHas('style', fn ($style) => $style->where('name', 'like', "%{$value}%"))
                ->orWhereHas('author', fn ($author) => $author->where('first_name', 'like', "%{$value}%")
                    ->orWhere('last_name', 'like', "%{$value}%")
                );
        }

        return $this;
    }
}
