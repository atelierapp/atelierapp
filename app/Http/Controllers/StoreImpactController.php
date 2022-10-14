<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImpactRequest;
use App\Http\Resources\StoreImpactScoreResource;
use App\Services\StoreService;

class StoreImpactController extends Controller
{
    public function __construct(private StoreService $storeService)
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:seller');
    }

    public function index($store)
    {
        $store = $this->storeService->getById($store);
        $store->load('qualities');
        $store->load(['medias' => fn ($media) => $media->where('orientation', 'impact_store')]);

        return StoreImpactScoreResource::make($store);
    }

    public function store(StoreImpactRequest $request, $store)
    {
        $store = $this->storeService->processImpactQualities($store, $request->validated());

        return StoreImpactScoreResource::make($store);
    }
}
