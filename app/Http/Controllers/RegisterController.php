<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Symfony\Component\Console\Input\Input;

class RegisterController extends Controller
{
    public function index() {
        return view('register.index', [
            "title" => "Register"
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name_customer' => 'required|max:255',
            'email' => 'required|email:dns|unique:customers|unique:admins',
            'password' => 'required|between:6,255|confirmed',
            'phone' => 'required|numeric|digits_between:8,13|unique:customers',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $customer = Customer::create($validatedData);

        event(new Registered($customer));

        Auth::login($customer);

        return redirect('email/verify');
    }
}
