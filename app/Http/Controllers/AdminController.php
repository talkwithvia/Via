<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

/**
 * AdminController
 * All data is now read from and written to the MySQL database (phpMyAdmin).
 */
class AdminController extends Controller
{
    // ── Dashboard Index ────────────────────────────────────────────────

    public function index()
    {
        return view('admin.dashboard', [
            'users'         => User::with('subscription')->latest()->get(),
            'products'      => Product::latest()->get(),
            'subscriptions' => Subscription::orderBy('id')->get(),
            'categories'    => Category::orderBy('name')->get(),
        ]);
    }

    // ── Store a New User ───────────────────────────────────────────────

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'subscription_id' => $request->subscription_id,
            'status'          => 'Active',
        ]);

        return redirect()->route('admin.index', ['tab' => 'users'])
                         ->with('success', 'User added successfully.');
    }

    // ── Update an Existing User ────────────────────────────────────────

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'            => 'required|string|max:100',
            'email'           => 'required|email|max:100|unique:users,email,' . $user->id,
            'subscription_id' => 'required|exists:subscriptions,id',
            'status'          => 'required|in:Active,Inactive',
        ];

        // Only validate password if the user typed something in it
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Password::min(8)];
        }

        $request->validate($rules);

        $user->name            = $request->name;
        $user->email           = $request->email;
        $user->subscription_id = $request->subscription_id;
        $user->status          = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.index', ['tab' => 'users'])
                         ->with('success', 'User updated successfully.');
    }

    // ── Delete a User ──────────────────────────────────────────────────

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.index', ['tab' => 'users'])
                         ->with('success', 'User deleted successfully.');
    }

    // ── Store a New Product ────────────────────────────────────────────

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'price'       => 'required|string|max:20',
            'category'    => 'required|string|max:60',
            'stock'       => 'required|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Store in public/storage/products/ — run php artisan storage:link once
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'image_path'  => $imagePath,
            'price'       => $request->price,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'status'      => 'Active',
        ]);

        return redirect()->route('admin.index', ['tab' => 'products'])
                         ->with('success', 'Product added successfully.');
    }

    // ── Update an Existing Product ─────────────────────────────────────

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'price'       => 'required|string|max:20',
            'category'    => 'required|string|max:60',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:Active,Inactive',
        ]);

        $product = Product::findOrFail($id);

        $imagePath = $product->image_path; // keep existing if none uploaded
        if ($request->hasFile('image')) {
            // Delete old image if present
            if ($imagePath) { Storage::disk('public')->delete($imagePath); }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'image_path'  => $imagePath,
            'price'       => $request->price,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.index', ['tab' => 'products'])
                         ->with('success', 'Product updated successfully.');
    }

    // ── Delete a Product ───────────────────────────────────────────────

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        // Delete image file from storage
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();

        return redirect()->route('admin.index', ['tab' => 'products'])
                         ->with('success', 'Product deleted successfully.');
    }

    // ── Category CRUD ──────────────────────────────────────────────────

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:60|unique:categories,name',
            'description' => 'nullable|string|max:160',
        ]);

        Category::create($request->only('name', 'description'));

        return redirect()->route('admin.index', ['tab' => 'categories'])
                         ->with('success', 'Category "' . $request->name . '" added.');
    }

    public function updateCategory(Request $request, $id)
    {
        $cat = Category::findOrFail($id);
        $request->validate([
            'name'        => 'required|string|max:60|unique:categories,name,' . $cat->id,
            'description' => 'nullable|string|max:160',
        ]);
        $cat->update($request->only('name', 'description'));

        return redirect()->route('admin.index', ['tab' => 'categories'])
                         ->with('success', 'Category updated.');
    }

    public function destroyCategory($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('admin.index', ['tab' => 'categories'])
                         ->with('success', 'Category deleted.');
    }

    // ── Update a Subscription Tier ─────────────────────────────────────

    public function updateSubscription(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:60',
            'price'    => 'required|string|max:20',
            'tagline'  => 'required|string|max:120',
            'features' => 'required|string',
        ]);

        $sub = Subscription::findOrFail($id);
        $sub->update([
            'name'     => $request->name,
            'price'    => $request->price,
            'tagline'  => $request->tagline,
            'features' => $request->features,
        ]);

        return redirect()->route('admin.index', ['tab' => 'subscriptions'])
                         ->with('success', 'Subscription tier updated.');
    }
}
