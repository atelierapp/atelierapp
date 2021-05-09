<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaUpdateRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MediaController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $media = Media::paginate();

        return MediaResource::collection($media);
    }

    public function show(Media $media): MediaResource
    {
        return MediaResource::make($media);
    }

    public function update(MediaUpdateRequest $request, Media $media): MediaResource
    {
        $media->update($request->validated());

        return MediaResource::make($media);
    }

    public function destroy(Media $media): JsonResponse
    {
        $media->delete();

        return $this->responseNoContent();
    }
}
