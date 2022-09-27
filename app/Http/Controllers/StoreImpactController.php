<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImpactRequest;
use App\Http\Resources\StoreImpactScoreResource;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StoreImpactController extends Controller
{
    public function __construct(private StoreService $storeService)
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:seller');
    }

    public function __invoke(StoreImpactRequest $request, $store)
    {
        $store = $this->storeService->processImpactQualities($store, $request->validated());

        return StoreImpactScoreResource::make($store);
    }
}
