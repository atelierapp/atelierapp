<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionImageRequest;
use App\Http\Requests\CollectionStoreRequest;
use App\Http\Requests\CollectionUpdateRequest;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use App\Models\Role;
use App\Services\CollectionService;
use Bouncer;
use Illuminate\Auth\Access\AuthorizationException;

class CollectionController extends Controller
{
    public function __construct(private CollectionService $collectionService)
    {
        //
    }

    public function index()
    {
        $query = Collection::query()->when(
            auth()->check(),
            fn ($query) => $query->where('user_id', auth()->id())
        );

        $collections = request()->has('with_all')
            ? $query->get()
            : $query->where('is_active', true)->get();

        return CollectionResource::collection($collections);
    }

    public function store(CollectionStoreRequest $request)
    {
        $collection = $this->collectionService->store($request->validated());

        return CollectionResource::make($collection);
    }

    public function update(CollectionUpdateRequest $request, $collection)
    {
        $collection = $this->collectionService->update($collection, $request->validated());

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
        if (Bouncer::is(auth()->user())->a(Role::USER)) {
            throw new AuthorizationException();
        }

        $query = Collection::whereId($collection)->withCount(['products']);

        if (Bouncer::is(auth()->user())->a(Role::SELLER)) {
            $query->authUser();
        }

        $collection = $query->firstOrFail();

        if ($collection->products_count) {
            return response()->json(['message' => 'Collection cannot delete because has associated stores']);
        }

        $collection->delete();

        return response()->json([], 204);
    }
}
