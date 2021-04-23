<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Http\Resources\StoreCollection;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function index(Request $request): StoreCollection
    {
        $stores = Store::all();

        return new StoreCollection($stores);
    }

    public function store(StoreStoreRequest $request): StoreResource
    {
        $store = Store::create($request->validated());

        return new StoreResource($store);
    }

    public function show(Request $request, Store $store): StoreResource
    {
        return new StoreResource($store);
    }

    public function update(StoreUpdateRequest $request, Store $store): StoreResource
    {
        $store->update($request->validated());

        return new StoreResource($store);
    }

    public function destroy(Request $request, Store $store): \Illuminate\Http\Response
    {
        $store->delete();

        return response()->noContent();
    }
}
