<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaTypeStoreRequest;
use App\Http\Requests\MediaTypeUpdateRequest;
use App\Http\Resources\MediaTypeCollection;
use App\Http\Resources\MediaTypeResource;
use App\Models\MediaType;
use Illuminate\Http\Request;

class MediaTypeController extends Controller
{

    public function index(Request $request): MediaTypeCollection
    {
        $mediaTypes = MediaType::all();

        return new MediaTypeCollection($mediaTypes);
    }

    public function store(MediaTypeStoreRequest $request): MediaTypeResource
    {
        $mediaType = MediaType::create($request->validated());

        return new MediaTypeResource($mediaType);
    }

    public function show(Request $request, MediaType $mediaType): MediaTypeResource
    {
        return new MediaTypeResource($mediaType);
    }

    public function update(MediaTypeUpdateRequest $request, MediaType $mediaType): MediaTypeResource
    {
        $mediaType->update($request->validated());

        return new MediaTypeResource($mediaType);
    }

    public function destroy(Request $request, MediaType $mediaType): \Illuminate\Http\Response
    {
        $mediaType->delete();

        return response()->noContent();
    }
}
