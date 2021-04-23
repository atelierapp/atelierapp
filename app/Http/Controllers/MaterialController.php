<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialStoreRequest;
use App\Http\Requests\MaterialUpdateRequest;
use App\Http\Resources\MaterialCollection;
use App\Http\Resources\MaterialResource;
use App\Models\Material;

class MaterialController extends Controller
{

    public function index(): MaterialCollection
    {
        $materials = Material::all();

        return new MaterialCollection($materials);
    }

    public function store(MaterialStoreRequest $request): MaterialResource
    {
        $material = Material::create($request->validated());

        return new MaterialResource($material);
    }

    public function show(Material $material): MaterialResource
    {
        return new MaterialResource($material);
    }

    public function update(MaterialUpdateRequest $request, Material $material): MaterialResource
    {
        $material->update($request->validated());

        return new MaterialResource($material);
    }

    public function destroy(Material $material): \Illuminate\Http\Response
    {
        $material->delete();

        return response()->noContent();
    }
}
