<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\LogActivity;
use App\Models\OrderAddress;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderInvoiceController extends Controller
{
    public function show($id) {
        $orderData = Order::findOrFail($id);
        if ($orderData != null) {
            if ($orderData->customer_id == Auth::user()->id) {
                $orderAddressData = (new OrderAddress)->getOrderAddressByOrderId($id);
                $orderProductsData = (new OrderProduct)->getOrderProductsByOrderId($id);
                $orderPaymentData = (new OrderPayment)->getOrderPaymentByOrderId($id);  
                LogActivity::storeLogActivity('Membuka halaman Order Invoice.');
                return view('order_invoice.show', [
                    'title' => 'Order #' . $id . ' Invoice',
                    'order_data' => $orderData,
                    'order_address' => $orderAddressData,
                    'order_products' => $orderProductsData,
                    'order_payment' => $orderPaymentData,
                ]);
            }
        }
        return back(); 
    }
}
