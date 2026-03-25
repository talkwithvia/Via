<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'users'         => User::latest()->get(),
            'products'      => Product::latest()->get(),
            'subscriptions' => Subscription::orderBy('id')->get(),
        ]);
    }

    // ── Store a New User ───────────────────────────────────────────────

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'plan'     => 'required|in:Basic,Core,Circle',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'plan'     => $request->plan,
            'status'   => 'Active',
        ]);

        return redirect()->route('admin.index', ['tab' => 'users'])
                         ->with('success', 'User added successfully.');
    }

    // ── Update an Existing User ────────────────────────────────────────

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'plan'  => 'required|in:Basic,Core,Circle',
            'status'=> 'required|in:Active,Inactive',
        ];

        // Only validate password if the user typed something in it
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Password::min(8)];
        }

        $request->validate($rules);

        $user->name   = $request->name;
        $user->email  = $request->email;
        $user->plan   = $request->plan;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.index', ['tab' => 'users'])
                         ->with('success', 'User updated successfully.');
    }

    // ── Store a New Product ────────────────────────────────────────────

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'price'       => 'required|string|max:20',
            'category'    => 'required|string|max:50',
            'stock'       => 'required|integer|min:0',
        ]);

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
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
            'description' => 'nullable|string|max:255',
            'price'       => 'required|string|max:20',
            'category'    => 'required|string|max:50',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:Active,Inactive',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.index', ['tab' => 'products'])
                         ->with('success', 'Product updated successfully.');
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
