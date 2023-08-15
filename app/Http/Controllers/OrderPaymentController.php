<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

class OrderPaymentController extends Controller
{
    public function show($id) {
        $orderData = Order::find($id);
        if ($orderData != null) {
            if ($orderData->customer_id == Auth::user()->id) {
                $snapToken = $orderData->snap_token;
                return view('order_payment.show', [
                    'title' => 'Order #' . $id . ' Payment',
                    'order_data' => $orderData,
                    'snap_token' => $snapToken,
                ]);
            }
            return back();    
        }
    }

    public function paymentCallback(Request $request) {
        $serveyKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serveyKey);
        
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' OR $request->transaction_status == 'settlement') {
                $order = Order::find($request->order_id);
                $order->update(['status' => 'paid']);
                
                OrderPayment::create([
                    'order_id' => $request->order_id,
                    'payment_type' => $request->payment_type,
                    'gross_amount' => (int)$request->gross_amount,
                    'transaction_time' => $request->transaction_time,
                    'settlement_time' => $request->settlement_time,
                ]);
            }
        }
    }
}
