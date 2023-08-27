<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerManagementController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderInvoiceController;
use App\Http\Controllers\OrderPaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\TopProductController;
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
Route::resource('/', HomeController::class);

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
Route::get('/profile/address/create', [ProfileController::class, 'createAddress'])->middleware(['auth', 'verified']);
Route::post('/profile/address/create', [ProfileController::class, 'storeAddress'])->middleware(['auth', 'verified']);
Route::post('/citiesByProvinceId/{province_id}', [RajaOngkirController::class, 'citiesByProvinceId'])->middleware(['auth', 'verified']);;
Route::get('/profile/address/update/{address_id}', [ProfileController::class, 'updateAddress'])->middleware(['auth', 'verified']);
Route::put('/profile/address/update/{address_id}', [ProfileController::class, 'updateAddressValidate'])->middleware(['auth', 'verified']);
Route::delete('/profile/address/destroy/{address_id}', [ProfileController::class, 'deleteAddress'])->middleware(['auth', 'verified']);

// Product List
Route::resource('/products', ProductListController::class);

// Cart
Route::resource('/cart', CartController::class);
Route::post('/cart/destroyAll', [CartController::class, 'destroyAll']);

// Order Checkout
Route::resource('/order', OrderController::class)->middleware(['auth', 'verified']);
Route::post('/get_delivery_cost', [RajaOngkirController::class, 'getDeliveryCost'])->middleware(['auth', 'verified']);;
Route::post('/get_address', [OrderController::class, 'getAddressById'])->middleware(['auth', 'verified']);;

// Order Payment
Route::resource('/order/payment', OrderPaymentController::class)->middleware(['auth', 'verified']);

// Order Invoice
Route::resource('/order/invoice', OrderInvoiceController::class)->middleware(['auth', 'verified']);

// About Us
Route::resource('/about_us', AboutUsController::class);

// Contact & FAQ
Route::resource('/contact', ContactController::class);

// Admin
Route::get('/admin', [AdminHomeController::class, 'index'])->middleware(['auth:admin']);

// Admin Categories
Route::resource('/admin/categories', CategoryController::class)->middleware(['auth:admin']);

// Admin Products
Route::resource('/admin/products', ProductController::class)->middleware(['auth:admin']);

// Admin Product Pictures
Route::resource('/admin/pictures', PictureController::class)->middleware(['auth:admin']);

// Admin Top Products Management
Route::resource('/admin/top_products', TopProductController::class)->middleware(['auth:admin']);

// Admin Orders Management
Route::resource('/admin/orders', AdminOrderController::class)->middleware(['auth:admin']);

// Admin Completed Orders
Route::get('/admin/completed_orders', [AdminOrderController::class, 'completedOrders'])->middleware(['auth:admin']);

// Admin Customers Management
Route::resource('/admin/customers', CustomerManagementController::class)->middleware(['auth:admin']);
Route::get('/admin/customers/log_activity/{customer_id}', [CustomerManagementController::class, 'showCustomerLog'])->middleware(['auth:admin']);

// Admins Management
Route::resource('/admin/admins_management', AdminManagementController::class)->middleware(['auth:admin']);
Route::get('/admin/admins_management/log_activity/{admin_id}', [AdminManagementController::class, 'showAdminLog'])->middleware(['auth:admin']);

// FAQs Management
Route::resource('/admin/faqs', FAQController::class)->middleware(['auth:admin']);

// Admin Messages
Route::resource('/admin/messages', AdminMessageController::class)->middleware(['auth:admin']);

// Log Activities
Route::resource('/admin/log_activities', LogActivityController::class)->middleware(['auth:admin']);