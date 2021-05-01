<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends Controller
{

    public function index(): TagCollection
    {
        $tags = Tag::paginate();

        return new TagCollection($tags);
    }

    public function store(TagStoreRequest $request): TagResource
    {
        $tag = Tag::create($request->validated());

        return new TagResource($tag);
    }

    public function show(Tag $tag): TagResource
    {
        return new TagResource($tag);
    }

    public function update(TagUpdateRequest $request, Tag $tag): TagResource
    {
        $tag->update($request->validated());

        return new TagResource($tag);
    }

    public function destroy(Tag $tag): \Illuminate\Http\JsonResponse
    {
        $tag->delete();

        return $this->responseNoContect();
    }
}
