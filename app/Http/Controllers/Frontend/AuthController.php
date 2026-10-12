<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view("frontend.auth.login");
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $google_user = Socialite::driver('google')->user();

        $old_user = User::where("email", $google_user->email)->first();

        if ($old_user) {
            Auth::login($old_user);
            return redirect()->route('home');
        }

        $user = User::create([
            'name' => $google_user->name,
            'email' => $google_user->email,
            'password'=>rand(100000000, 999999999),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
