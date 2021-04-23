<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitSystemStoreRequest;
use App\Http\Requests\UnitSystemUpdateRequest;
use App\Http\Resources\UnitSystemCollection;
use App\Http\Resources\UnitSystemResource;
use App\Models\UnitSystem;

class UnitSystemController extends Controller
{

    public function index(): UnitSystemCollection
    {
        $unitSystems = UnitSystem::all();

        return new UnitSystemCollection($unitSystems);
    }

    public function store(UnitSystemStoreRequest $request): UnitSystemResource
    {
        $unitSystem = UnitSystem::create($request->validated());

        return new UnitSystemResource($unitSystem);
    }

    public function show(UnitSystem $unitSystem): UnitSystemResource
    {
        return new UnitSystemResource($unitSystem);
    }

    public function update(UnitSystemUpdateRequest $request, UnitSystem $unitSystem): UnitSystemResource
    {
        $unitSystem->update($request->validated());

        return new UnitSystemResource($unitSystem);
    }

    public function destroy(UnitSystem $unitSystem): \Illuminate\Http\Response
    {
        $unitSystem->delete();

        return response()->noContent();
    }
}
