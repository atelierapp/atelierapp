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
        $this->middleware('auth:sanctum')->only(['store']);
    }

    public function index(): AnonymousResourceCollection
    {// Refactor this to a better way. Maybe use a standardized way to do it: categories[]=1&categories[]=2&..
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

        dd(__METHOD__ . ': ' . __LINE__, $product);

        $product = Product::create($request->validated());

        // if (! empty($request->get('tags'))) {
        //     $tags = [];
        //     foreach ($request->tags as $tag) {
        //         $tags[] = Tag::query()->firstOrNew([
        //             'name' => $tag['name']
        //         ]);
        //     }
        //     $product->tags()->saveMany($tags);
        // }

        // if ($request->has('attach')) {
        //     foreach ($request->file('attach') as $attach) {
        //         $mediaTypeId = MediaType::getIdFromMimeType($attach['file']->getClientMimeType());
        //         $path = Storage::disk('s3')->put('media', $attach['file']);
        //         $product->medias()->save(
        //             new Media(['url' => $path, 'type_id' => $mediaTypeId])
        //         );
        //     }
        // }

        $this->loadRelations($product);

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

    public function update(ProductUpdateRequest $request, Product $product): ProductResource
    {
        $product->update($request->validated());
        $this->loadRelations($product);

        return ProductResource::make($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return $this->responseNoContent();
    }
}
