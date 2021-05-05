<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaTypeStoreRequest;
use App\Http\Requests\MediaTypeUpdateRequest;
use App\Http\Resources\MediaTypeResource;
use App\Models\MediaType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MediaTypeController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $mediaTypes = MediaType::paginate();

        return MediaTypeResource::collection($mediaTypes);
    }

    public function store(MediaTypeStoreRequest $request): MediaTypeResource
    {
        $mediaType = MediaType::create($request->validated());

        return MediaTypeResource::make($mediaType);
    }

    public function show(MediaType $mediaType): MediaTypeResource
    {
        return MediaTypeResource::make($mediaType);
    }

    public function update(MediaTypeUpdateRequest $request, MediaType $mediaType): MediaTypeResource
    {
        $mediaType->update($request->validated());

        return MediaTypeResource::make($mediaType);
    }

    public function destroy(MediaType $mediaType): JsonResponse
    {
        $mediaType->delete();

        return $this->responseNoContent();
    }

}
