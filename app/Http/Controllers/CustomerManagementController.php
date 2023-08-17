<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminOrderController;

class CustomerManagementController extends Controller
{
    public function index() {
        $customersData = Customer::all();
        foreach ($customersData as $customer) {
            $customer['transactions_total'] = count((new Order)->getOrdersByCustomerId($customer->id));
        }
        
        return view('admin.customers.index', [
            'title' => 'Customers Management',
            'customers_data' => $customersData,
        ]);
    }

    public function show($id) {
        $customerData = Customer::find($id);
        $customerOrders = (new Order)->getOrdersByCustomerId($id);
        $customerAddresses = (new Address)->getAddressesByCustomerId($id);
        $customerData['transactions_total'] = count($customerOrders);
        $subtotalQuantity = (new AdminOrderController)->sumSubtotalQuantity($customerOrders);        
        $customerUnpaidOrders = $customerPaidOrders = $customerDeliveringOrders = $customerCompletedOrders = [
            'data' => [], 
            'quantity' => 0,
            'subtotal' => 0,
        ];

        foreach ($customerOrders as $order) {
            if ($order->status == 'unpaid') {
                array_push($customerUnpaidOrders['data'], $order);
                $customerUnpaidOrders['quantity'] += $order->quantity_total;
                $customerUnpaidOrders['subtotal'] += $order->subtotal;
            } elseif ($order->status == 'paid') {
                array_push($customerPaidOrders['data'], $order);
                $customerPaidOrders['quantity'] += $order->quantity_total;
                $customerPaidOrders['subtotal'] += $order->subtotal;
            } elseif ($order->status == 'delivering') {
                array_push($customerDeliveringOrders['data'], $order);
                $customerDeliveringOrders['quantity'] += $order->quantity_total;
                $customerDeliveringOrders['subtotal'] += $order->subtotal;
            } else {
                array_push($customerCompletedOrders['data'], $order);
                $customerCompletedOrders['quantity'] += $order->quantity_total;
                $customerCompletedOrders['subtotal'] += $order->subtotal;
            }
        }

        return view('admin.customers.show', [
            'title' => 'Customer Detail',
            'customer_data' => $customerData,
            'customer_orders' => $customerOrders,
            'customer_addresses' => $customerAddresses,
            'subtotal' => $subtotalQuantity['subtotal'],
            'quantity' => $subtotalQuantity['quantity'],
            'unpaid_orders' => $customerUnpaidOrders,
            'paid_orders' => $customerPaidOrders,
            'delivering_orders' => $customerDeliveringOrders,
            'completed_orders' => $customerCompletedOrders,  
        ]);
    }
}
