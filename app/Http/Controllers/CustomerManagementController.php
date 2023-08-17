<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerManagementController extends Controller
{
    public function index() {
        $customersData = Customer::all();
        foreach ($customersData as $customer) {
            $customer['transactions_total'] = count((new Order)->getOrderByCustomerId($customer->id));
        }
        
        return view('admin.customers.index', [
            'title' => 'Customers Management',
            'customers_data' => $customersData,
        ]);
    }
}
