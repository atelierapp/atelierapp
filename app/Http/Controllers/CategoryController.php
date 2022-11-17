<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Storage;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->when(
                request()->has('type'),
                fn ($query) => $query->where('type', request('type'))
            )
            ->paginate(1000);

        return CategoryResource::collection($categories);
    }

    public function store(CategoryStoreRequest $request): CategoryResource
    {
        $params = $this->processRequest($request);
        $category = Category::create($params);
        $category->fresh();

        return CategoryResource::make($category);
    }

    public function show(Category $category): CategoryResource
    {
        return CategoryResource::make($category);
    }

    public function update(CategoryUpdateRequest $request, Category $category): CategoryResource
    {
        $params = $this->processRequest($request);
        Storage::delete($category->image);
        $category->update($params);

        return CategoryResource::make($category);
    }

    private function processRequest($request): array
    {
        $path = $request->file('image')->store('categories');
        $params = collect($request->validated())->except('image')->toArray();
        $params['image'] = $path;

        return $params;
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return $this->responseNoContent();
    }
}
