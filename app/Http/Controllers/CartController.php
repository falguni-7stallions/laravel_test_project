<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => DB::raw('quantity + 1'),
            ]
        );

        return response()->json(['success' => 'Product added to cart']);
    }
    public function viewCart()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->product->price;
        }
        return view('cart.view', compact('cartItems', 'total'));
    }

    public function destroy($id)
    {
        $cartItem = Cart::findOrFail($id);  // Find the cart item by its ID
        $cartItem->delete();                // Delete the cart item

        return response()->json(['success' => 'Item removed from cart']);  // Send a success message
    }
    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('greeting.page')->with('success', 'Checkout successful! Your cart is now empty.');
    }

}
