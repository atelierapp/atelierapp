<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagIndexResource;
use App\Models\Tag;

class TagController extends Controller
{

    public function index(): TagCollection
    {
        $tags = Tag::paginate();

        return new TagCollection($tags);
    }

    public function store(TagStoreRequest $request): TagIndexResource
    {
        $tag = Tag::create($request->validated());

        return new TagIndexResource($tag);
    }

    public function show(Tag $tag): TagIndexResource
    {
        return new TagIndexResource($tag);
    }

    public function update(TagUpdateRequest $request, Tag $tag): TagIndexResource
    {
        $tag->update($request->validated());

        return new TagIndexResource($tag);
    }

    public function destroy(Tag $tag): \Illuminate\Http\Response
    {
        $tag->delete();

        return response()->noContent();
    }
}
