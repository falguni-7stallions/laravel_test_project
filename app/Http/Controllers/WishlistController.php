<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\product;
use App\Models\wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function addToFavorite(Request $request)
    {
        $productId = $request->product_id;
        $userId = auth()->id();

        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {

            product::where('id', $productId)
                ->update(['is_favourite_product' => false]);

            $wishlistItem->delete();
            return response()->json(['success' => 'product removed']);
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            product::where('id', $productId)
                ->update(['is_favourite_product' => true]);

            return response()->json(['success' => 'product added']);
        }
    }

    public function viewFavorites()
    {
        $favoriteItems = wishlist::where('user_id', auth()->id())->with('product')->get();
        return view('favorite.view', compact('favoriteItems'));
    }
}
