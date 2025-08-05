<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

   public function show($id)
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    return new CategoryResource($category);
}

  public function store(CategoryRequest $request)
{
    $category = Category::create($request->validated());

    return response()->json([
        'message' => 'Category created successfully',
        'category' => new CategoryResource($category)
    ], 201);
}


 public function update(CategoryRequest $request, $id)
{
    $category = Category::findOrFail($id);
    $category->update($request->validated());

    return response()->json([
        'message' => 'Category updated successfully',
        'category' => new CategoryResource($category)
    ]);
}


    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
