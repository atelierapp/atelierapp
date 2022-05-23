<?php

namespace App\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Models\Role;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;

class ProductBuilder extends Builder implements AuthUserContractBuilder
{
    public function authUser(): static
    {
        if (Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this->whereHas('store', fn ($has) => $has->where('user_id', '=', auth()->id()));
        }

        return $this;
    }

    public function applyFiltersFrom(array $filters): static
    {
        // maybe implement pipeline ...
        if (isset($filters['categories'])) {
            $this->filterByCategories($filters['categories']);
        }

        if (isset($filters['search'])) {
            $this->search($filters['search']);
        }

        if (isset($filters['collection'])) {
            $this->filterByCollection($filters['collection']);
        }

        return $this;
    }

    public function filterByCategories(array $categories): static
    {
        $this
            ->with([
                'categories' => fn ($query) => $query->when($categories, fn ($query) => $query->whereIn('id', $categories)),
            ])
            ->when($categories,
                fn ($query) => $query->whereHas('categories', fn ($query) => $query->whereIn('id', $categories)));

        return $this;
    }

    public function filterByCollection(string|int $collection): static
    {
        $this
            ->with([
                'collections' => fn ($query) => $query->when($collection, fn ($query) => $query->where('id', $collection)),
            ])
            ->when($collection,
                fn ($query) => $query->whereHas('collections', fn ($query) => $query->where('id', $collection)));

        return $this;
    }

    public function search($value): static
    {
        if (! empty($value)) {
            $this
                ->where('title', 'like', "%{$value}%")
                ->orWhereHas('style', function ($q) use ($value) {
                    $q->where('name', 'like', "%{$value}%");
                });
        }

        return $this;
    }
}
