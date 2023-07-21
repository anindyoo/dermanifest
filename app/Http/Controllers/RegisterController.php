<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
            'email' => 'required|email:dns|unique:customers',
            'password' => 'required|between:6,255|confirmed',
            'phone' => 'required|numeric|digits_between:8,13|unique:customers',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        Customer::create($validatedData);
    }
}
