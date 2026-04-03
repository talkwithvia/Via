<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as FacadesLog;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail(Auth::id());
            $before = $user->toArray();
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            // Handle profile picture
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('uploads/profiles'); // e.g., public/uploads/profiles

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $filename);

                $user->image = 'uploads/profiles/' . $filename;
            }

            $user->save();
            activity('User Management')
                ->causedBy(Auth::user())
                ->withProperties([
                    'user_id' => $user->id,
                    'before' => $before,
                    'after' => $user->toArray(),
                    'ip' => request()->ip(),
                ])
                ->log('Updated User');

            DB::commit();
            return back()->with('success', 'Profile updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            FacadesLog::error('Profile update failed for user ID ' . Auth::id() . ': ' . $th->getMessage(), [
                'stack' => $th->getTraceAsString(),
            ]);
            return back()->with('error', 'An error occurred while updating your profile. Please try again.')->withInput();
        }
    }
}
