<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionImageRequest;
use App\Http\Requests\CollectionStoreRequest;
use App\Http\Requests\CollectionUpdateRequest;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use App\Services\CollectionService;
use Bouncer;
use Illuminate\Auth\Access\AuthorizationException;

class CollectionController extends Controller
{
    public function __construct(private CollectionService $collectionService)
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $query = Collection::query();
        $collections = request()->has('with_all')
            ? $query->get()
            : $query->where('is_active', true)->get();

        return CollectionResource::collection($collections);
    }

    public function store(CollectionStoreRequest $request)
    {
        $collection = Collection::create($request->validated());

        return CollectionResource::make($collection);
    }

    public function update(CollectionUpdateRequest $request, $collection)
    {
        $collection = Collection::findOrFail($collection);
        $collection->update($request->validated());

        return CollectionResource::make($collection);
    }

    public function image(CollectionImageRequest $request, $collection): CollectionResource
    {
        $collection = $this->collectionService->processImage($collection, $request->file('image'));

        return CollectionResource::make($collection);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($collection)
    {
        if (Bouncer::is(auth()->user())->notAn('admin')) {
            throw new AuthorizationException();
        }

        $collection = Collection::query()
            ->where('id', '=', $collection)
            ->withCount(['products'])
            ->firstOrFail();

        if ($collection->products_count) {
            return response()->json(['message' => 'Collection cannot delete because has associated stores']);
        }

        $collection->delete();

        return response()->json([], 204);
    }
}
