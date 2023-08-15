<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getOrderPaymentByOrderId($order_id) {
        return $this::where('order_id', $order_id)->first();
    }
}
