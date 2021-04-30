<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Http\Resources\StoreIndexResource;
use App\Http\Resources\StoreDetailResource;
use App\Models\Store;

class StoreController extends Controller
{

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $stores = Store::search(request('search'))->paginate();

        return StoreIndexResource::collection($stores);
    }

    public function store(StoreStoreRequest $request): StoreDetailResource
    {
        $store = Store::create($request->validated());

        return StoreDetailResource::make($store);
    }

    public function show(Store $store): StoreDetailResource
    {
        return StoreDetailResource::make($store);
    }

    public function update(StoreUpdateRequest $request, Store $store): StoreDetailResource
    {
        $store->update($request->validated());

        return StoreDetailResource::make($store);
    }

    public function destroy(Store $store): \Illuminate\Http\Response
    {
        $store->delete();

        return response()->noContent();
    }
}
