<?php

namespace App\Http\Controllers;

use App\Http\Requests\VariationStoreRequest;
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
}
