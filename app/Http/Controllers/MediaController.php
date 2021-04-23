<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaStoreRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Http\Resources\MediumCollection;
use App\Http\Resources\MediumResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\MediumCollection
     */
    public function index(Request $request)
    {
        $media = Medium::all();

        return new MediumCollection($media);
    }

    /**
     * @param \App\Http\Requests\MediaStoreRequest $request
     * @return \App\Http\Resources\MediumResource
     */
    public function store(MediaStoreRequest $request)
    {
        $medium = Medium::create($request->validated());

        return new MediumResource($medium);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Media $medium
     * @return \App\Http\Resources\MediumResource
     */
    public function show(Request $request, Medium $medium)
    {
        return new MediumResource($medium);
    }

    /**
     * @param \App\Http\Requests\MediaUpdateRequest $request
     * @param \App\Models\Media $medium
     * @return \App\Http\Resources\MediumResource
     */
    public function update(MediaUpdateRequest $request, Medium $medium)
    {
        $medium->update($request->validated());

        return new MediumResource($medium);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Media $medium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Medium $medium)
    {
        $medium->delete();

        return response()->noContent();
    }
}
