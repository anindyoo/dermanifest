<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect(); 
    }

    public function googleCallbackHandler() {
        $userGoogle = Socialite::driver('google')->user();

        $findAdmin = Admin::where('email', $userGoogle->getEmail())->first();
        $findUser = Customer::where('email', $userGoogle->getEmail())->first();
        $current_time = Carbon::now();

        if ($findUser) {
            if ($findUser['email_verified_at'] == '') {
                Customer::where('email', $userGoogle->getEmail())->update(['email_verified_at' => $current_time]);
            }
            Auth::guard('web')->login($findUser);
            return redirect()->intended('/')->with('success', 'Login successful. Welcome to Dermanifest, ' . $userGoogle->getName() . '!' );
        } elseif ($findAdmin) {
            Auth::guard('admin')->login($findAdmin);
            return redirect()->intended('/admin')->with('success', 'Login with email:'. $findAdmin['email'] .' is successful!');            
        } else {
            $random_password = Hash::make(Str::random(10));
            $newUser = Customer::create([
                'name_customer' => $userGoogle->getName(),
                'email' => $userGoogle->getEmail(),
                'google_id' => $userGoogle->getId(),
                'password' => $random_password,
                'phone' => "",
                'google_avi' => $userGoogle->getAvatar(),
                "email_verified_at" => $current_time,
            ]);

            Auth::login($newUser);
            return redirect()->intended('/');
        }
    }
}
