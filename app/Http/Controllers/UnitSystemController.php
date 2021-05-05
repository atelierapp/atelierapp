<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitSystemStoreRequest;
use App\Http\Requests\UnitSystemUpdateRequest;
use App\Http\Resources\UnitSystemResource;
use App\Models\UnitSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UnitSystemController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $unitSystems = UnitSystem::paginate();

        return UnitSystemResource::collection($unitSystems);
    }

    public function store(UnitSystemStoreRequest $request): UnitSystemResource
    {
        $unitSystem = UnitSystem::create($request->validated());

        return UnitSystemResource::make($unitSystem);
    }

    public function show(UnitSystem $unitSystem): UnitSystemResource
    {
        return UnitSystemResource::make($unitSystem);
    }

    public function update(UnitSystemUpdateRequest $request, UnitSystem $unitSystem): UnitSystemResource
    {
        $unitSystem->update($request->validated());

        return UnitSystemResource::make($unitSystem);
    }

    public function destroy(UnitSystem $unitSystem): JsonResponse
    {
        $unitSystem->delete();

        return $this->responseNoContent();
    }

}
