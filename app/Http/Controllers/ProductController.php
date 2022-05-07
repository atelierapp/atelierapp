<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth:sanctum')->only(['store', 'update']);
    }

    public function index(): AnonymousResourceCollection
    {
        // Refactor this to a better way. Maybe use a standardized way to do it: categories[]=1&categories[]=2&..
        $categories = request('categories') ? explode(',', request('categories')) : null;

        $products = Product::query()
            ->with([
                'style',
                'medias',
                'tags',
                'store',
                'categories' => fn($query) => $query->when($categories,
                    fn($query) => $query->whereIn('id', $categories)),
            ])
            ->when($categories,
                fn($query) => $query->whereHas('categories', fn($query) => $query->whereIn('id', $categories)))
            ->search(request('search'))
            ->paginate();

        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request): ProductResource
    {
        $product = $this->productService->store($request->validated());

        return ProductResource::make($product);
    }

    private function loadRelations(Product $productModel)
    {
        $productModel->load('categories', 'style', 'store', 'materials', 'medias', 'tags', 'featured_media');
    }

    public function show(Product $product): ProductResource
    {
        $this->loadRelations($product);

        return ProductResource::make($product);
    }

    public function update(ProductUpdateRequest $request, $product): ProductResource
    {
        $product = $this->productService->update($product, $request->validated());

        return ProductResource::make($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return $this->responseNoContent();
    }
}
