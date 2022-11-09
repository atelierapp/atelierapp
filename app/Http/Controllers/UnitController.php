<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UnitController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $units = Unit::paginate(1000);

        return UnitResource::collection($units);
    }

    public function store(UnitStoreRequest $request): UnitResource
    {
        $unit = Unit::create($request->validated());

        return UnitResource::make($unit);
    }

    public function show(Unit $unit): UnitResource
    {
        return UnitResource::make($unit);
    }

    public function update(UnitUpdateRequest $request, Unit $unit): UnitResource
    {
        $unit->update($request->validated());

        return UnitResource::make($unit);
    }

    public function destroy(Unit $unit): JsonResponse
    {
        $unit->delete();

        return $this->responseNoContent();
    }
}
