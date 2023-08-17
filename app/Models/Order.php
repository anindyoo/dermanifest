<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getOrdersByCustomerId($customer_id) {
        return $this::where('customer_id', $customer_id)->get();
    }
}
