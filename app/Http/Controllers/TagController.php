<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $tags = Tag::paginate();

        return TagResource::collection($tags);
    }

    public function store(TagStoreRequest $request): TagResource
    {
        $tag = Tag::create($request->validated());

        return TagResource::make($tag);
    }

    public function show(Tag $tag): TagResource
    {
        return TagResource::make($tag);
    }

    public function update(TagUpdateRequest $request, Tag $tag): TagResource
    {
        $tag->update($request->validated());

        return TagResource::make($tag);
    }

    public function destroy(Tag $tag): JsonResponse
    {
        $tag->delete();

        return $this->responseNoContent();
    }

}
