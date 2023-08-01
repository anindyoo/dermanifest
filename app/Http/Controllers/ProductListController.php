<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function index() {
        $productsData = Product::all();
        $categoriesData = Category::all();

        return view('products.index', [
            'title' => 'Product List',
            'categories_data' => $categoriesData,
            'products_data' => $productsData,
        ]);
    }
}
