<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    public function store(Request $request)
    {
      
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'slug' => 'nullable|unique:categories',
            'image' => 'nullable',
            'status' => 'required|boolean',
        ]);

          $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $request->slug,
            'image' => $request->image,
            'status' => $request->status,
        ]);
         return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'slug' => 'nullable|unique:categories,slug,' . $id,
            'image' => 'nullable',
            'status' => 'required|boolean',
        ]);

        $category->update($request->all());

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
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
