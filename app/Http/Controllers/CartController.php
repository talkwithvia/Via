<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * CartController
 * Manages the shopping cart stored in the user's session.
 * No database required — cart lives in the session.
 */
class CartController extends Controller
{
    /** Add a product to the session cart or increase its quantity. */
    public function add(Request $request, int $id)
    {
        $product = Product::where('status', 'Active')->findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image_path,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success'    => true,
            'message'    => "{$product->name} added to cart.",
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /** Remove a product from the session cart. */
    public function remove(int $id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return response()->json([
            'success'    => true,
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /** Return the current cart count (for badge updates). */
    public function count()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }
}
