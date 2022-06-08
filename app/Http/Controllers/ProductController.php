<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): AnonymousResourceCollection
    {
        $products = $this->productService->list();

        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request): ProductResource
    {
        $product = $this->productService->store($request->validated());

        return ProductResource::make($product);
    }

    public function show($product): ProductResource
    {
        $product = $this->productService->getBy($product);
        $this->productService->loadRelations($product);

        return ProductResource::make($product);
    }

    private function loadRelations(Product $productModel)
    {
        $productModel->load('categories', 'style', 'store', 'materials', 'medias', 'tags', 'featured_media');
    }

    public function update(ProductUpdateRequest $request, $product): ProductResource
    {
        $product = $this->productService->update($product, $request->validated());

        return ProductResource::make($product);
    }

    public function image(ProductImageRequest $request, $product): ProductResource
    {
        $product = $this->productService->image($product, $request->validated());

        return ProductResource::make($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return $this->responseNoContent();
    }
}
