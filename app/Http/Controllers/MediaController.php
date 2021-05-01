<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaUpdateRequest;
use App\Http\Resources\MediaResource;
use App\Http\Resources\MediumCollection;
use App\Models\Media;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{

    public function index(): MediumCollection
    {
        $media = Media::all();

        return new MediumCollection($media);
    }

    public function show(Media $media): MediaResource
    {
        return new MediaResource($media);
    }

    public function update(MediaUpdateRequest $request, Media $media): MediaResource
    {
        $media->update($request->validated());

        return new MediaResource($media);
    }

    public function destroy(Media $media): JsonResponse
    {
        $media->delete();

        return $this->responseNoContect();
    }

}
