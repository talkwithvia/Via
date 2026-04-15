<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * StoreController
 * Handles the public-facing store page — browsing products by category.
 */
class StoreController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');

        // Fetch only active products; filter by category if requested
        $query = Product::where('status', 'Active')->orderBy('name');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $products   = $query->get();
        $categories = Product::where('status', 'Active')
                             ->distinct()
                             ->pluck('category')
                             ->sort()
                             ->values();

        return view('via.store', compact('products', 'categories', 'category'));
    }
    public function show($id)
    {
        $product = Product::where('status', 'Active')->findOrFail($id);

        // Fetch related products (same category, excluding the current one)
        $relatedProducts = Product::where('status', 'Active')
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('via.product', compact('product', 'relatedProducts'));
    }
}
