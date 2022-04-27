<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionStoreRequest;
use App\Http\Requests\CollectionUpdateRequest;
use App\Http\Resources\QualityResource;
use App\Http\Resources\TagResource;
use App\Models\Collection;
use Bouncer;
use Illuminate\Auth\Access\AuthorizationException;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $collections = Collection::all();

        return TagResource::collection($collections);
    }

    public function store(CollectionStoreRequest $request)
    {
        $collection = Collection::create($request->validated());

        return QualityResource::make($collection);
    }

    public function update(CollectionUpdateRequest $request, $collection)
    {
        $collection = Collection::findOrFail($collection);
        $collection->update($request->validated());

        return QualityResource::make($collection);
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
