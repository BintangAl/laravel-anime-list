<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            // dd($user);
            $finduser = User::where('email', $user->email)->first();
            if ($finduser) {
                Auth::login($finduser, true);
                return redirect(RouteServiceProvider::HOME);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make($user->id)
                ]);

                Auth::login($newUser);
                return redirect(RouteServiceProvider::HOME);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
