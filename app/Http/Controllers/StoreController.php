<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Http\Resources\StoreCollection;
use App\Http\Resources\StoreResource;
use App\Models\Store;

class StoreController extends Controller
{

    public function index(): StoreCollection
    {
        $stores = Store::all();

        return new StoreCollection($stores);
    }

    public function store(StoreStoreRequest $request): StoreResource
    {
        $store = Store::create($request->validated());

        return new StoreResource($store);
    }

    public function show(Store $store): StoreResource
    {
        return new StoreResource($store);
    }

    public function update(StoreUpdateRequest $request, Store $store): StoreResource
    {
        $store->update($request->validated());

        return new StoreResource($store);
    }

    public function destroy(Store $store): \Illuminate\Http\Response
    {
        $store->delete();

        return response()->noContent();
    }
}
