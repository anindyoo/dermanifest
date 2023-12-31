<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getProductById($id) {
        return $this->find($id);
    }

    public function getProductBySlug($slug) {
        return $this::where('slug', $slug)->firstOrFail();
    }
}
