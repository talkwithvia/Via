<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * WishlistController
 * Manages the wishlist stored in the user's session.
 * Toggles items on/off — add if not present, remove if already there.
 */
class WishlistController extends Controller
{
    /** Toggle a product in/out of the session wishlist. */
    public function toggle(int $id)
    {
        $product   = Product::where('status', 'Active')->findOrFail($id);
        $wishlist  = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            // Already in wishlist — remove it
            unset($wishlist[$id]);
            $inWishlist = false;
            $message    = "{$product->name} removed from wishlist.";
        } else {
            // Not in wishlist — add it
            $wishlist[$id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'image' => $product->image_path,
            ];
            $inWishlist = true;
            $message    = "{$product->name} added to wishlist.";
        }

        session()->put('wishlist', $wishlist);

        return response()->json([
            'success'        => true,
            'message'        => $message,
            'in_wishlist'    => $inWishlist,
            'wishlist_count' => count($wishlist),
        ]);
    }
}
