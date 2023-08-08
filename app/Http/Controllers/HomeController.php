<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\TopProduct;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $topProductsData = TopProduct::all();
        $productsData = [];

        foreach ($topProductsData as $key => $top_product) {
            if ($top_product->product_id != null){
                $productData = (new Product)->getProductById($top_product->product_id);
                $productsData[$key] = $productData;
                $productsData[$key]['category_name'] = (new Category)->getCategoryById($productData->category_id)->name_category;
            } else {
                unset($topProductsData[$key]);
            }
        }

        return view('home', [
            'title' => 'Home',
            'products_data' => $productsData,
        ]);
    }
}
