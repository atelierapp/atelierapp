<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Media;
use App\Models\MediaType;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    private function loadRelations(Product $productModel)
    {
        $productModel->load('categories', 'style', 'materials', 'medias', 'tags', 'featured_media');
    }

    public function index(): AnonymousResourceCollection
    {
        $products = Product::with('style')->search(request('search'))->paginate();

        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request): ProductResource
    {
        $product = Product::create($request->validated());

        if (! empty($request->get('tags'))) {
            $tags = [];
            foreach ($request->tags as $tag) {
                $tags[] = Tag::query()->firstOrNew([
                    'name' => $tag['name']
                ]);
            }
            $product->tags()->saveMany($tags);
        }

        if ($request->has('attach')) {
            foreach ($request->file('attach') as $attach) {
                $mediaTypeId = MediaType::getIdFromMimeType($attach['file']->getClientMimeType());
                $path = Storage::disk('s3')->put('media', $attach['file']);
                $product->medias()->save(
                    new Media(['url' => $path, 'type_id' => $mediaTypeId])
                );
            }
        }

        $this->loadRelations($product);

        return ProductResource::make($product);
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
