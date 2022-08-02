<?php

namespace App\Services;

use App\Models\StoreUserRating;

class QualifyService
{

    public function qualifyAStore($store, $params)
    {
        $store = app(StoreService::class)->getById($store);
        $params['user_id'] = auth()->id();
        $params['store_id'] = $store->id;

        return StoreUserRating::query()->create($params);
    }
}
