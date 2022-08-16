<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            // dd($user);
            $finduser = User::where('email', $user->email)->first();
            if ($finduser) {
                $finduser->facebook_id = $user->id;
                $finduser->facebook_name = $user->name;
                $finduser->save();

                Auth::login($finduser, true);
                return redirect(RouteServiceProvider::HOME);
            } else {
                $newUser = User::create([
                    'facebook_id' => $user->id,
                    'facebook_name' => $user->name,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make($user->id)
                ]);

                Auth::login($newUser);
                return redirect(RouteServiceProvider::HOME);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/login');
        }
    }
}
