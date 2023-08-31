<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getOrderAddressByOrderId($order_id) {
        return $this::where('order_id', $order_id)->first();
    }
}
