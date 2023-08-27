<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\LogActivity;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index() {
        $orders = Order::all();        
        $paidOrders = Order::where('status', 'paid')->get();
        $customers = Customer::all();
        $deliveringOrCompletedOrders = Order::where('status', 'delivering')->orWhere('status', 'completed')->get();
        $gross_sales = (new AdminOrderController)->sumSubtotalQuantity($deliveringOrCompletedOrders)['subtotal'];
        LogActivity::storeLogActivity('Membuka halaman Admin Home.', 'admin');

        return view('admin.home', [
            'title' => 'Home',
            'orders_total' => count($orders),
            'paid_orders_total' => count($paidOrders),
            'customers_total' => count($customers),
            'gross_sales' => $gross_sales,
        ]);
    }
}
