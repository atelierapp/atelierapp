<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductUserQualifyRequest;
use App\Http\Resources\ProductQualifyResource;
use App\Services\QualifyService;

class ProductUserQualifyController extends Controller
{
    public function __construct(private QualifyService $qualifyService)
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $qualifications = $this->qualifyService->productQualifications();

        return ProductQualifyResource::collection($qualifications);
    }

    public function store(ProductUserQualifyRequest $request, $product)
    {
        $qualify = $this->qualifyService->qualifyAProduct($product, $request->validated());

        return ProductQualifyResource::make($qualify);
    }
}
