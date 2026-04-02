<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     */
    public function redirect($provider)
    {
        // We only support google and apple for now
        if (!in_array($provider, ['google', 'apple'])) {
            return redirect()->route('login')->withErrors(['error' => 'Unsupported authentication provider.']);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     */
    public function callback($provider)
    {
        try {
            if ($provider === 'apple') {
                $socialUser = Socialite::driver($provider)->stateless()->user();
            } else {
                $socialUser = Socialite::driver($provider)->user();
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Unable to authenticate using ' . ucfirst($provider) . '. Please try again.']);
        }

        // Check if a user with this email already exists
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // If they exist but don't have this provider yet, update them (links the accounts)
            if (!$user->provider) {
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'provider_token' => $socialUser->token,
                ]);
            }
        } else {
            // Create a new user
            $user = User::create([
                'name' => $socialUser->getName() ?: 'User',
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'provider_token' => $socialUser->token,
                'status' => 'Active',
            ]);
        }

        Auth::login($user, true);

        // Redirect to homepage as requested by user
        return redirect()->intended('/');
    }
}
