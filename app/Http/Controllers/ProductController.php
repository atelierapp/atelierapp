<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\Product as ProductResource;
use App\Models\Media;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $products = Product::paginate();

        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request): ProductResource
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
                $path = Storage::disk('s3')->put('media', $attach['file']);
                $product->medias()->save(
                    new Media(['url' => $path])
                );
            }
        }

        return new ProductResource($product);
    }

    public function show(Product $product): ProductResource
    {
        $product->load('categories', 'style', 'materials');

        return new ProductResource($product);
    }

    public function update(ProductUpdateRequest $request, Product $product): ProductResource
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    public function destroy(Product $product): \Illuminate\Http\Response
    {
        $product->delete();

        return response()->noContent();
    }
}
