<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Models\Collection;

class CollectionFeatureController extends Controller
{
    public function __invoke()
    {
        $collections = Collection::featured()->get();

        return CollectionResource::collection($collections);
    }
}
