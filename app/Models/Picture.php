<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getPicturesByProductId($procduct_id) {
        return $this::where('product_id', $procduct_id)->get();
    }
}
