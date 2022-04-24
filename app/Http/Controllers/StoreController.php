<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoreController extends Controller
{
    public function __construct(protected StoreService $storeService)
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'image']);
    }

    public function index(): AnonymousResourceCollection
    {
        $stores = Store::search(request('search'))->paginate();

        return StoreResource::collection($stores);
    }

    public function store(StoreStoreRequest $request): StoreResource
    {
        $store = $this->storeService->store($request);

        return StoreResource::make($store);
    }

    public function show(Store $store): StoreResource
    {
        return StoreResource::make($store);
    }

    public function update(StoreUpdateRequest $request, $store): StoreResource
    {
        $store = $this->storeService->update($request, $store);

        return StoreResource::make($store);
    }

    public function image(StoreImageRequest $request, $store)
    {
        $store = $this->storeService->image($request, $store);

        return StoreResource::make($store);
    }

    public function destroy(Store $store): JsonResponse
    {
        $store->delete();

        return $this->responseNoContent();
    }
}
