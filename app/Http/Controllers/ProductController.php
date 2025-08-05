<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

        public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function store(ProductRequest $request)
    {
       $product = Product::create($request->validated());

       return response()->json([
            'message' => 'Products created successfully',
            'product' => $product
        ], 201);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);

        $product->update($request->validated());
        
         return response()->json([
        'message' => 'Products updated successfully',
        'product' => $product
    ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
