<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaStoreRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Http\Resources\MediaIndexResource;
use App\Http\Resources\MediumCollection;
use App\Models\Media;

class MediaController extends Controller
{

    public function index(): MediumCollection
    {
        $media = Media::all();

        return new MediumCollection($media);
    }

    public function show(Media $media): MediaIndexResource
    {
        return new MediaIndexResource($media);
    }

    public function update(MediaUpdateRequest $request, Media $media): MediaIndexResource
    {
        $media->update($request->validated());

        return new MediaIndexResource($media);
    }

    public function destroy(Media $media): \Illuminate\Http\Response
    {
        $media->delete();

        return response()->noContent();
    }
}
