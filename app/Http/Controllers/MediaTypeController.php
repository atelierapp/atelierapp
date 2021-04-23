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
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\MediaTypeCollection
     */
    public function index(Request $request)
    {
        $mediaTypes = MediaType::all();

        return new MediaTypeCollection($mediaTypes);
    }

    /**
     * @param \App\Http\Requests\MediaTypeStoreRequest $request
     * @return \App\Http\Resources\MediaTypeResource
     */
    public function store(MediaTypeStoreRequest $request)
    {
        $mediaType = MediaType::create($request->validated());

        return new MediaTypeResource($mediaType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MediaType $mediaType
     * @return \App\Http\Resources\MediaTypeResource
     */
    public function show(Request $request, MediaType $mediaType)
    {
        return new MediaTypeResource($mediaType);
    }

    /**
     * @param \App\Http\Requests\MediaTypeUpdateRequest $request
     * @param \App\Models\MediaType $mediaType
     * @return \App\Http\Resources\MediaTypeResource
     */
    public function update(MediaTypeUpdateRequest $request, MediaType $mediaType)
    {
        $mediaType->update($request->validated());

        return new MediaTypeResource($mediaType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MediaType $mediaType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MediaType $mediaType)
    {
        $mediaType->delete();

        return response()->noContent();
    }
}
