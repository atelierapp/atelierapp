<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::paginate($request->get('paginate', 10));

        return new CategoryCollection($categories);
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::query()->create($request->all());

        return new CategoryResource($category);
    }

    public function show(Request $request, Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        return response()->noContent(200);
    }
}
