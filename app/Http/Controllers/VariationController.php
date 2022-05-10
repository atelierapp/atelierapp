<?php

namespace App\Http\Controllers;

use App\Http\Resources\VariationResource;
use App\Services\VariationService;
use Illuminate\Http\Request;

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
}
