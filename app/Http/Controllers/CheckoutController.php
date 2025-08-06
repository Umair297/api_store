<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();

        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'country' => 'required|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;

            foreach ($cartItems as $item) {
                if (!$item->product) {
                    continue;
                }
                $totalAmount += $item->product->price * $item->quantity;
            }

            // Create the order
            $order = Order::create([
                'user_id'      => $user->id,
                'name'         => $validated['name'],
                'email'        => $validated['email'],
                'address'      => $validated['address'],
                'city'         => $validated['city'],
                'country'      => $validated['country'],
                'total_amount' => $totalAmount,
                'status'       => 'pending',
            ]);
            Mail::to($order->email)->send(new OrderPlacedMail($order));
            // Clear the user's cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return response()->json([
                'message'  => 'Order placed successfully',
                'order_id' => $order->id,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error'   => 'Checkout failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
