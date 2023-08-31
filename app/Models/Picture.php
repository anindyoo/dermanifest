<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getPicturesByProductId($product_id) {
        return $this::where('product_id', $product_id)->get();
    }
}
