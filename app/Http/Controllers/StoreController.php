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
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\StoreCollection
     */
    public function index(Request $request)
    {
        $stores = Store::all();

        return new StoreCollection($stores);
    }

    /**
     * @param \App\Http\Requests\StoreStoreRequest $request
     * @return \App\Http\Resources\StoreResource
     */
    public function store(StoreStoreRequest $request)
    {
        $store = Store::create($request->validated());

        return new StoreResource($store);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \App\Http\Resources\StoreResource
     */
    public function show(Request $request, Store $store)
    {
        return new StoreResource($store);
    }

    /**
     * @param \App\Http\Requests\StoreUpdateRequest $request
     * @param \App\Models\Store $store
     * @return \App\Http\Resources\StoreResource
     */
    public function update(StoreUpdateRequest $request, Store $store)
    {
        $store->update($request->validated());

        return new StoreResource($store);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Store $store)
    {
        $store->delete();

        return response()->noContent();
    }
}
