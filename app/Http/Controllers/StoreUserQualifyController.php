<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserQualifyRequest;
use App\Http\Resources\StoreUserQualifyResource;
use App\Services\QualifyService;

class StoreUserQualifyController extends Controller
{
    public function __construct(private QualifyService $qualifyService)
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke(StoreUserQualifyRequest $request, $store)
    {
        $qualify = $this->qualifyService->qualifyAStore($store, $request->validated());

        return StoreUserQualifyResource::make($qualify);
    }
}
