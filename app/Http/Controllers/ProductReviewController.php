<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductUserQualifyRequest;
use App\Http\Resources\ProductQualifyResource;
use App\Models\Product;
use App\Models\ProductQualification;
use App\Services\QualifyService;

class ProductReviewController extends Controller
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

    public function show($product)
    {
        $product = Product::authUser()->find($product);
        $reviews = ProductQualification::whereProductId($product->id)
            ->with([
                'product.featured_media',
                'user'
            ])
            ->get();

        return ProductQualifyResource::collection($reviews);
    }
}
