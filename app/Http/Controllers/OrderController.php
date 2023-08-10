<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
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

    public function show($id) {
        $orderData = Order::findOrFail($id);
        $orderProductsData = (new OrderProduct)->getOrderProductsByOrderId($id);
        $orderAddressData = (new OrderAddress)->getOrderAddressByOrderId($id);

        if ($orderData->customer_id == Auth::user()->id) {
            return view('order.show', [
                'title' => 'Order Detail',
                'order_data' => $orderData,
                'order_products_data' => $orderProductsData,
                'order_address_data' => $orderAddressData,
            ]);
        }

        return view('cart.index', ['title' => 'Cart']);
    }

    public function store(Request $request) {
        $new_address_id = 0;
        if ($request->address_id == null) {
            $validatedNewAddress = $request->validate([
                'customer_id' => 'required',
                'province_api_id' => 'required',
                'city_api_id' => 'required',
                'name_address' => 'required|max:255',
                'address' => 'required',
                'province' => 'required|max:255',
                'city' => 'required|max:255',
                'postal_code' => 'required|numeric',
            ]);
            $insertNewAddress = Address::create($validatedNewAddress);
            $new_address_id = $insertNewAddress->id;
        } else {
            $new_address_id = $request->address_id;
        }        
        $validatedOrder = $request->validate([
            'customer_id' => 'required',
            'recipient' => 'required|max:255',
            'email' => 'required|email:dns|unique:customers',
            'phone' => 'required|numeric|digits_between:8,13',
            'delivery_courier' => 'required|max:255',
            'delivery_service' => 'required|max:255',
            'delivery_cost' => 'required|integer',
            'subtotal' => 'required|integer',
            'grand_total' => 'required|integer',
            'quantity_total' => 'required|integer',
            'gross_weight_total' => 'required|integer|max:30000',
            'note' => '',
        ]);
        $validatedOrder['address_id'] = $new_address_id;
        $validatedOrder['status'] = 'unpaid';
        $insertOrder = Order::create($validatedOrder);
        $orderId = $insertOrder->id;

        $validatedProducts = $request->validate([
            'product_id.*' => 'required',
            'product_slug.*' => 'required|max:255',
            'product_name.*' => 'required|max:255',
            'category_name.*' => 'required|max:255',
            'main_picture.*' => 'required|max:255',
            'price.*' => 'required|integer',
            'discount_price.*' => '',
            'quantity.*' => 'required|integer',
            'price_total.*' => 'required|integer',
        ]);
        $productsData = [];
        for ($i = 0; $i < count($validatedProducts['product_id']); $i -=- 1) {
            $singleProductData = [];
            foreach ($validatedProducts as $key => $product) {
                if ($key != 'order_id') {
                    $singleProductData[$key] = $product[$i];
                }
            }
            $singleProductData['order_id'] = $orderId; 
            array_push($productsData, $singleProductData);
        }    
        foreach($productsData as $product) {
            $insertOrderProduct = OrderProduct::create($product);
        }

        $validatedAddress = $request->validate([
            'name_address' => 'required|max:255',
            'address' => 'required',
            'province' => 'required|max:255',
            'city' => 'required|max:255',
            'postal_code' => 'required|numeric',
        ]);
        $validatedAddress['address_id'] = $new_address_id;
        $validatedAddress['order_id'] = $orderId;
        $insertOrderAddress = OrderAddress::create($validatedAddress);

        session()->forget('cart');
        return redirect('/cart');
    }

    public function destroy(Order $order) {
        Order::destroy($order->id);

        return redirect('/profile')->with('success', '<strong> Order#' . $order->name_productid . '</strong> has been canceled.');
    }

    public function getAddressById(Request $request) {
        $address = Address::whereIn('customer_id', [Auth::user()->id])->findOrFail($request->option);
        return $address;
    }
}
