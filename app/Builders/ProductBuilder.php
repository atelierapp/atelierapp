<?php

namespace App\Builders;

use App\Contracts\Builders\AuthUserContractBuilder;
use App\Models\Role;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductBuilder extends Builder implements AuthUserContractBuilder
{
    public function authUser(): static
    {
        if (auth()->check() && Bouncer::is(auth()->user())->an(Role::SELLER)) {
            $this->whereHas('store', fn ($has) => $has->where('user_id', '=', auth()->id()));
        }

        return $this;
    }

    public function applyFiltersFrom(array $filters): static
    {
        // maybe implement a pipeline ...
        if (isset($filters['categories'])) {
            $this->filterByCategories($filters['categories']);
        }

        if (isset($filters['search'])) {
            $this->search($filters['search']);
        }

        if (isset($filters['collection'])) {
            $this->filterByCollection($filters['collection']);
        }

        if (isset($filters['store_id'])) {
            $this->filterByStore($filters['store_id']);
        }

        if (isset($filters['price-min']) && isset($filters['price-max'])) {
            $this->filterByPriceRange($filters['price-min'] * 100, $filters['price-max'] * 100);
        }

        if (isset($filters['price-order'])) {
            $this->orderBy('price', $filters['price-order']);
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
                ->orWhereHas('style', fn ($q) => $q->where('name', 'like', "%{$value}%"))
                ->orWhereHas('categories', fn ($q) => $q->where('name', 'like', "%{$value}%"));
        }

        return $this;
    }

    public function filterByStore(string|int $storeId): static
    {
        $this
            ->where('store_id', $storeId)
            ->with(['store' => fn ($query) => $query->where('id', $storeId)]);

        return $this;
    }

    public function filterByPriceRange(int|string $min, int|string $max): static
    {
        $this->whereBetween('price', [$min, $max]);

        return $this;
    }
}
