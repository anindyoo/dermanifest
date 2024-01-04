<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Login.');
        
        return view('login.index', [
            "title" => "Login"
        ]);
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            LogActivity::storeLogActivity('Melakukan Login ke akun Customer.', $url = '/auth/google/callback');
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Login with email:'. $credentials['email'] .' is successful!');
        } elseif (Auth::guard('admin')->attempt($credentials)) {
            LogActivity::storeLogActivity('Melakukan Login ke akun Admin.', 'admin', $url = '/auth/google/callback');
            $request->session()->regenerate();
            return redirect('admin')->with('success', 'Login with email:'. $credentials['email'] .' is successful!');
        }

        return back()->with('loginError', 'Login failed.');
    }

    public function logout(Request $request) {
        LogActivity::storeLogActivity('Melakukan Logout.', $url = '/auth/google/callback');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
     
        return back()->with('success', 'Successfully logged out.');
    }
}
