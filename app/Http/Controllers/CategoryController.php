<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CategoryCollection
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        return new CategoryCollection($categories);
    }

    /**
     * @param \App\Http\Requests\CategoryStoreRequest $request
     * @return \App\Http\Resources\CategoryResource
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \App\Http\Resources\CategoryResource
     */
    public function show(Request $request, Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * @param \App\Http\Requests\CategoryUpdateRequest $request
     * @param \App\Models\Category $category
     * @return \App\Http\Resources\CategoryResource
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
