<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\LogActivity;
use App\Models\Product;
use App\Models\TopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Home.');

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
