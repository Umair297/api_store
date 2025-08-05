<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'sku'         => 'required|string|unique:products,sku',
            'image'       => 'nullable|string',
            'status'      => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'brand'       => 'nullable|string|max:255',
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }


    public function index()
    {
        return Product::with('category')->get();
    }
}
