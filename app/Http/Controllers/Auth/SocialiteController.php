<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token ?? null,
                'google_refresh_token' => $googleUser->refreshToken ?? null,
                'auth_provider' => 'google', 
            ]);
        } else {
            $user = User::create([
                'nama_user' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token ?? null,
                'google_refresh_token' => $googleUser->refreshToken ?? null,
                'password' => null, 
                'role' => 'customer',
                'auth_provider' => 'google',
            ]);
        }

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->to('/admin');
        }
        return redirect()->route('homepage');
    }
}
