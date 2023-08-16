<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index() {
        $ordersData = Order::all();

        return view('admin.orders.index', [
            'title' => 'Orders Management',
            'orders_data' => $ordersData,
        ]);
    }

    public function show($id) {
        $orderData = Order::find($id);
        $orderProductsData = (new OrderProduct)->getOrderProductsByOrderId($id);
        $orderAddressData = (new OrderAddress)->getOrderAddressByOrderId($id);

        return view('admin.orders.show', [
            'title' => 'Order Detail',
            'order_data' => $orderData,
            'order_products' => $orderProductsData,
            'order_address' => $orderAddressData,
        ]);
    }
}
