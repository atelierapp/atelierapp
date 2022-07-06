<?php

namespace App\Services;

use App\Models\StoreUserQualify;

class QualifyService
{

    public function qualifyAStore($store, $params)
    {
        $store = app(StoreService::class)->getById($store);
        $params['user_id'] = auth()->id();
        $params['store_id'] = $store->id;

        return StoreUserQualify::query()->create($params);
    }
}
