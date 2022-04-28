<?php

namespace App\Services;

use App\Models\Collection as CollectionModel;

class CollectionService
{
    public function getCollectionToAuth(mixed $collectionName): CollectionModel
    {
        return CollectionModel::updateOrCreate(['name' => $collectionName, 'user_id' => auth()->id()]);
    }
}
