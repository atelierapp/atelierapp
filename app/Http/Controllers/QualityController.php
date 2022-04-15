<?php

namespace App\Http\Controllers;

use App\Http\Requests\QualityStoreRequest;
use App\Http\Requests\QualityUpdateRequest;
use App\Http\Resources\QualityResource;
use App\Models\Quality;

class QualityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update']);
    }

    public function index()
    {
        $qualities = Quality::all();

        return QualityResource::collection($qualities);
    }

    public function store(QualityStoreRequest $request)
    {
        $quality = Quality::create($request->validated());

        return QualityResource::make($quality);
    }

    public function update(QualityUpdateRequest $request, $quality)
    {
        $quality = Quality::findOrFail($quality);
        $quality->update($request->validated());

        return QualityResource::make($quality);
    }
}
