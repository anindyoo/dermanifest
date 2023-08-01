<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\ProductListController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Home
Route::get('/', function () {
    return view('home', [
        "title" => "Home"
    ]);
});

// Register
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email', ["title" => "Verify Email"]);
})->middleware('auth')->name('verification.notice');

// Verification Redirect
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend Verification Email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware(['guest', 'guest:admin']);
Route::post('/login', [LoginController::class, 'authenticate']);

// Google OAuth 2.0
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'googleCallbackHandler'])->name('google.callback');

// Logout
Route::post('/logout', [LoginController::class, 'logout']);

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->middleware(['auth', 'verified']);
Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->middleware(['auth', 'verified']);
Route::put('/password/update', [ProfileController::class, 'updatePassword'])->middleware(['auth', 'verified']);

// Addresses
Route::post('/address', [ProfileController::class, 'addAddress'])->middleware(['auth', 'verified']);
Route::post('/citiesByProvinceId/{province_id}', [RajaOngkirController::class, 'citiesByProvinceId'])->middleware(['auth', 'verified']);;
Route::get('/profile/address/update/{address_id}', [ProfileController::class, 'updateAddress'])->middleware(['auth', 'verified']);
Route::put('/profile/address/update/{address_id}', [ProfileController::class, 'updateAddressValidate'])->middleware(['auth', 'verified']);
Route::delete('/profile/address/destroy/{address_id}', [ProfileController::class, 'deleteAddress'])->middleware(['auth', 'verified']);

// Product List
Route::resource('/products', ProductListController::class);

// Admin
Route::get('/admin', function () {
    return view('admin.home', [
        "title" => "Home"
    ]);
})->middleware(['auth:admin']);

// Admin Categories
Route::resource('/admin/categories', CategoryController::class)->middleware(['auth:admin']);

// Admin Products
Route::resource('/admin/products', ProductController::class)->middleware(['auth:admin']);

// Admin Product Pictures
Route::resource('/admin/pictures', PictureController::class)->middleware(['auth:admin']);