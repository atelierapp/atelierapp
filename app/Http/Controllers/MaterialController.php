<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialStoreRequest;
use App\Http\Requests\MaterialUpdateRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MaterialController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $materials = Material::paginate();

        return MaterialResource::collection($materials);
    }

    public function store(MaterialStoreRequest $request): MaterialResource
    {
        $material = Material::create($request->validated());

        return MaterialResource::make($material);
    }

    public function show(Material $material): MaterialResource
    {
        return MaterialResource::make($material);
    }

    public function update(MaterialUpdateRequest $request, Material $material): MaterialResource
    {
        $material->update($request->validated());

        return MaterialResource::make($material);
    }

    public function destroy(Material $material): JsonResponse
    {
        $material->delete();

        return $this->responseNoContent();
    }

}
