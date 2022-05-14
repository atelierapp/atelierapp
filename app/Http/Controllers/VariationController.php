<?php

namespace App\Http\Controllers;

use App\Http\Requests\VariationImageRequest;
use App\Http\Requests\VariationStoreRequest;
use App\Http\Requests\VariationUpdateRequest;
use App\Http\Resources\VariationResource;
use App\Services\VariationService;

class VariationController extends Controller
{
    public function __construct(private VariationService $variationService)
    {
        $this->middleware('auth:sanctum');
    }

    public function index($product)
    {
        $variations = $this->variationService->indexFromProduct($product);

        return VariationResource::collection($variations);
    }

    public function store(VariationStoreRequest $request, $product)
    {
        $variation = $this->variationService->store($product, $request->validated());

        return VariationResource::make($variation);
    }

    public function update(VariationUpdateRequest $request, $product, $variation)
    {
        $variation = $this->variationService->update($product, $variation, $request->validated());

        return VariationResource::make($variation);
    }

    public function image(VariationImageRequest $request, $product, $variation)
    {
        $variation = $this->variationService->image($product, $variation, $request->validated());

        return VariationResource::make($variation);
    }
}
