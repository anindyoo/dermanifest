<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function orders() {
        return $this->belongsToMany(Order::class);
    }

    public function getAddressesByCustomerId($id) {
        return $this::where('customer_id', $id)->get();
    }
}
