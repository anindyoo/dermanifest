<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create() {
        if (!session()->has('cart')) {
            return redirect('/cart')->with('danger', 'Cart is still empty.');
        }
        $cart = (new CartController)->getCart();
        $cartItems = $cart['cart_items'];
        $productsData = $cart['products_data'];
        $addressesData = (new Address)->getAddressesByCustomerId(Auth::user()->id);
        $provinces = (new ProfileController)->getProvincesOptions();
        $date = Carbon::now();

        return view('order.create', [
            'title' => 'Order Checkout',
            'cart_items' => $cartItems,
            'products_data' => $productsData,
            'date' => $date,
            'provinces' => $provinces,
            'addresses_data' => $addressesData,
        ]);
    }

    public function getAddressById(Request $request) {
        $address = Address::whereIn('customer_id', [Auth::user()->id])->findOrFail($request->option);
        return $address;
    }
}
