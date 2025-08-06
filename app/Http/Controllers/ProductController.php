<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
public function index()
{
    return response()->json(Product::with('variants')->get());
}

public function show($id)
{
    $product = Product::with('variants')->find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json($product);
}

  public function store(ProductRequest $request)
{
    $product = Product::create($request->only([
        'name', 'slug', 'description', 'price', 'image', 'status', 'category_id'
    ]));

    if ($request->has('variants')) {
        foreach ($request->variants as $variant) {
            $product->variants()->create([
                'size' => $variant['size'],
                'price' => $variant['price'],
                'stock' => $variant['stock'] ?? 0,
            ]);
        }
    }

    return response()->json([
        'message' => 'Product created with variants',
        'product' => $product->load('variants'),
    ], 201);
}


  public function update(ProductRequest $request, $id)
{
    $product = Product::find($id);
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    $product->update($request->only([
        'name', 'slug', 'description', 'price', 'image', 'status', 'category_id'
    ]));

    if ($request->has('variants')) {
        $product->variants()->delete();

        foreach ($request->variants as $variant) {
            $product->variants()->create([
                'size' => $variant['size'],
                'price' => $variant['price'],
                'stock' => $variant['stock'] ?? 0,
            ]);
        }
    }

    return response()->json([
        'message' => 'Product updated with variants',
        'product' => $product->load('variants'),
    ]);
}

public function addVariants(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    if ($request->has('variants')) {
        foreach ($request->variants as $variant) {
            $product->variants()->create([
                'size' => $variant['size'],
                'price' => $variant['price'],
                'stock' => $variant['stock'] ?? 0,
            ]);
        }
    }

    return response()->json([
        'message' => 'Variants added successfully',
        'product' => $product->load('variants')
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
