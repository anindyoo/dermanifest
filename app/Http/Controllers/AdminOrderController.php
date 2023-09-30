<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\LogActivity;
use App\Models\OrderAddress;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Admin Orders Management.', 'admin');
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
        LogActivity::storeLogActivity('Membuka halaman Admin Order Detail: Id #' . $id . '.', 'admin');

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
        LogActivity::storeLogActivity('Membuka halaman Admin Edit Order: Id #' . $id . '.', 'admin');
        
        return view('admin.orders.edit', [
            'title' => $orderData->status == 'paid' ? 'Confirm Order Payment' : 'Edit Order',
            'order_data' => $orderData,
            'order_payment' => $orderPaymentData,
        ]);
    }

    public function completedOrders() {
        $completedOrdersData = Order::where('status', 'completed')->get();
        $subtotalQuantity = $this->sumSubtotalQuantity($completedOrdersData);
        LogActivity::storeLogActivity('Membuka halaman Admin Completed Orders.', 'admin');

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
            'delivery_code' => $validatedData['delivery_code'],
        ]);
        LogActivity::storeLogActivity('Memperbarui Order: Id #' . $request['order_id'] . '.', 'admin');

        return redirect('/admin/orders/' . $request['order_id'] .'/edit')->with('success', 'Order has been confirmed.');
    }

    public function destroy(Order $order) {
        $orderProducts = OrderProduct::where('order_id', $order->id)->get();        
        (new OrderController)->readdStock($orderProducts);
        Order::destroy($order->id);
        LogActivity::storeLogActivity('Membatalkan Order: Id #' . $order->id . '.', 'admin');

        return redirect('/admin/orders')->with('success', '<strong> Order #' . $order->id . '</strong> has been canceled.');
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
