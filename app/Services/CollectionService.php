<?php

namespace App\Services;

use App\Models\Collection as CollectionModel;
use Illuminate\Support\Collection;

class CollectionService
{
    public function getByIds(array $collectionIds): Collection
    {
        return CollectionModel::whereIn('id', $collectionIds)->get();
    }
}
