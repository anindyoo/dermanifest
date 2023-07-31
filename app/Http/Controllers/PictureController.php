<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Product;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    public function show($product_id) {
        $productData = (new Product)->getProductById($product_id);
        $productPicsturesData = Picture::all();

        return view('admin.products.pictures', [
            'title' => 'Product Pictures Management',
            'product_data' => $productData,
            'product_pictures_data' => $productPicsturesData,
        ]);
    }
}
