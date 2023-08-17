<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderPayment;
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
        $orderPaymentData = (new OrderPayment)->getOrderPaymentByOrderId($id);    

        return view('admin.orders.show', [
            'title' => 'Order Detail',
            'order_data' => $orderData,
            'order_products' => $orderProductsData,
            'order_address' => $orderAddressData,
            'order_payment' => $orderPaymentData,
        ]);
    }

    public function edit($id) {
        $orderData = Order::find($id);
        $orderPaymentData = (new OrderPayment)->getOrderPaymentByOrderId($id);    
        
        return view('admin.orders.edit', [
            'title' => 'Confirm Order Payment',
            'order_data' => $orderData,
            'order_payment' => $orderPaymentData,
        ]);
    }

    public function completedOrders() {
        $completedOrdersData = Order::where('status', 'completed')->get();
        $subtotalQuantity = $this->sumSubtotalQuantity($completedOrdersData);

        return view('admin.orders.completed', [
            'title' => 'Completed Orders',
            'completed_orders' => $completedOrdersData,
            'subtotal' => $subtotalQuantity['subtotal'],
            'quantity' => $subtotalQuantity['quantity'],
        ]);
    }

    public function update(Request $request) {
        $validatedData = $request->validate([
            'status' => 'required|max:20',
            'delivery_code' => 'required|max:30',
        ]);

        Order::where('id', $request['order_id'])->update([
            'status' => $validatedData['status'],
            'delivery_code' => $validatedData['delivery_code']
        ]);

        return redirect('/admin/orders/' . $request['order_id'] .'/edit')->with('success', 'Order has been confirmed.');
    }

    public function destroy(Order $order) {
        $orderProducts = OrderProduct::where('order_id', $order->id)->get();
        $this->readdStock($orderProducts);
        Order::destroy($order->id);

        return redirect('/admin/orders')->with('success', '<strong> Order #' . $order->product_id . '</strong> has been canceled.');
    }

    public function sumSubtotalQuantity($completed_orders) {
        $subtotal = 0;
        $quantity = 0;
        foreach ($completed_orders as $order) {
            $subtotal += $order->subtotal;
            $quantity += $order->quantity_total;
        }

        return ['subtotal' => $subtotal, 'quantity' => $quantity];
    }
}
