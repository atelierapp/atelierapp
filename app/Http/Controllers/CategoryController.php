<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Storage;

class CategoryController extends Controller
{

    public function index(): CategoryCollection
    {
        $categories = Category::all();

        return new CategoryCollection($categories);
    }

    public function store(CategoryStoreRequest $request): CategoryResource
    {
        $params = $this->processRequest($request);
        $category = Category::create($params);

        return new CategoryResource($category);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function update(CategoryUpdateRequest $request, Category $category): CategoryResource
    {
        $params = $this->processRequest($request);
        Storage::delete($category->image);
        $category->update($params);

        return new CategoryResource($category);
    }

    private function processRequest($request): array
    {
        $path = $request->file('image')->store('categories');
        $params = collect($request->validated())->except('image')->toArray();
        $params['image'] = $path;

        return $params;
    }

    public function destroy(Category $category): \Illuminate\Http\Response
    {
        $category->delete();

        return response()->noContent();
    }

}
