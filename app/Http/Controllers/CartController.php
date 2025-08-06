<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cart) {
            $cart->quantity += $request->quantity ?? 1;
            $cart->save();
        } else {
            $cart = Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1
            ]);
        }

        return response()->json([
            'message' => 'Product added to cart',
            'cart' => $cart
        ]);
    }


    public function index(Request $request)
    {
        $cart = Cart::with('product')->where('user_id', $request->user()->id)->get();
        return response()->json($cart);
    }

    public function destroy($id, Request $request)
    {
        $cart = Cart::where('id', $id)->where('user_id', $request->user()->id)->first();
        $cart->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }
}
