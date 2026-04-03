<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        try {
            $providedUser = Socialite::driver($provider)->user();

            // Check if the user exists by provider_id
            $user = User::where('provider', $provider)
                ->where('provider_id', $providedUser->id)
                ->first();

            if (!$user) {
                // User doesn't exist, check by email
                $user = User::where('email', $providedUser->email)->first();
                if ($user) {
                    // Update existing user with provider details
                    $user->update([
                        'provider'       => $provider,
                        'provider_id'    => $providedUser->id,
                        'provider_token' => $providedUser->token,
                    ]);
                } else {
                    // Create a new user
                    $user = User::create([
                        'name' => $providedUser->name,
                        'email' => $providedUser->email,
                        'provider' => $provider,
                        'provider_id' => $providedUser->id,
                        'provider_token' => $providedUser->token,
                    ]);
                }
            }
            // Log in the user
            Auth::login($user);
            return redirect()->intended(route('home'));
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('warning', 'An error occurred, please try using email and password');
        }
    }
}
