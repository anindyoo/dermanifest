<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
use Hamcrest\Number\OrderingComparison;
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
        $orderData = Order::find($id);
        if ($orderData != null) {
            if ($orderData->customer_id == Auth::user()->id) {
                $orderProductsData = (new OrderProduct)->getOrderProductsByOrderId($id);
                $orderAddressData = (new OrderAddress)->getOrderAddressByOrderId($id);
                return view('order.show', [
                    'title' => 'Order Detail',
                    'order_data' => $orderData,
                    'order_products_data' => $orderProductsData,
                    'order_address_data' => $orderAddressData,
                ]);
            }
        }
        return back();
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
            'email' => 'required|email:dns',
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
            $newStock = Product::find($product['product_id'])->stock - $product['quantity'];
            Product::where('id', $product['product_id'])->update(['stock' => $newStock]);
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

        $snapToken = $this->getSnap($orderId);
        Order::where('id', $orderId)->update(['snap_token' => $snapToken]);
        session()->forget('cart');
        return redirect('/order/' . $orderId);
    }

    public function destroy(Order $order) {
        $orderProducts = OrderProduct::where('order_id', $order->id)->get();
        $this->readdStock($orderProducts);
        Order::destroy($order->id);

        return redirect('/profile')->with('success', '<strong> Order #' . $order->product_id . '</strong> has been canceled.');
    }

    public function getAddressById(Request $request) {
        $address = Address::whereIn('customer_id', [Auth::user()->id])->findOrFail($request->option);
        return $address;
    }

    public function readdStock($orderProducts) {
        foreach ($orderProducts as $product) {
            $productData = Product::find($product['product_id']);
            $stock = $productData->stock;
            $quantity = $product['quantity'];
            $refillStock = $stock + $quantity;
            
            Product::where('id', $product['product_id'])->update(['stock' => $refillStock]);
        }
    }

    public function getSnap($order_id) {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        $orderData = Order::find($order_id);
        $orderProducts = (new OrderProduct)->getOrderProductsByOrderId($order_id);
        $orderAddress = (new OrderAddress)->getOrderAddressByOrderId($order_id);

        $productsRequest = [];
        for ($i = 0; $i < count($orderProducts); $i -=- 1) {
            $singleProductData = [];
            $singleProductData['id'] = $orderProducts[$i]['product_id'];
            $singleProductData['quantity'] = $orderProducts[$i]['quantity'];            
            $singleProductData['name'] = $orderProducts[$i]['product_name'];            
            if ($orderProducts[$i]['discount_price'] > 0) {
                $singleProductData['price'] = $orderProducts[$i]['discount_price'];
            } else {
                $singleProductData['price'] = $orderProducts[$i]['price'];
            }
            array_push($productsRequest, $singleProductData);
        } 
        
        array_push($productsRequest, [
            'id' => $orderData->delivery_courier . '-' . $orderData->delivery_service,
            'quantity' => '1',
            'name' => 'Delivery Cost',
            'price' => $orderData->delivery_cost,
        ]);

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderData->id,
                'gross_amount' => $orderData->grand_total,
            ),
            'customer_details' => array(
                'first_name' => $orderData->recipient,
                'last_name' => '',
                'email' => $orderData->email,
                'phone' => $orderData->phone,
                'billing_address' => array(
                    'first_name' => $orderData->recipient,
                    'last_name' => '',
                    'email' => $orderData->email,
                    'phone' => $orderData->phone,
                    'address' => $orderAddress->address,
                    'city' => $orderAddress->city,
                    'postal_code' => $orderAddress->postal_code,
                    'country_code' => 'IDN'
                ),
            ),
            'item_details' => $productsRequest,
            'shipping_address' => array(
                'first_name' => $orderData->recipient,
                'last_name' => '',
                'email' => $orderData->email,
                'phone' => $orderData->phone,
                'address' => $orderAddress->address,
                'city' => $orderAddress->city,
                'postal_code' => $orderAddress->postal_code,
                'country_code' => 'IDN'
              )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return $snapToken;
    }
}
