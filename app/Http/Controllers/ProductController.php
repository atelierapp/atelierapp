<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductIndexResource;
use App\Models\Media;
use App\Models\MediaType;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $products = Product::with('style')->search(request('search'))->paginate();

        return ProductIndexResource::collection($products);
    }

    public function store(ProductStoreRequest $request): ProductDetailResource
    {
        $product = Product::create($request->validated());

        if (!empty($request->get('tags'))) {
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

        $product->load('style', 'tags', 'medias');

        return ProductDetailResource::make($product);
    }

    public function show(Product $product): ProductDetailResource
    {
        $product->load('categories', 'style', 'materials');

        return ProductDetailResource::make($product);
    }

    public function update(ProductUpdateRequest $request, Product $product): ProductDetailResource
    {
        $product->update($request->validated());

        return ProductDetailResource::make($product);
    }

    public function destroy(Product $product): \Illuminate\Http\Response
    {
        $product->delete();

        return response()->noContent();
    }
}
