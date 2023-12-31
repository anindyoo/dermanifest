<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Product;
use App\Models\Category;
use App\Models\LogActivity;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Product List.');
        $productsData = Product::all();
        $categoriesData = Category::all();

        return view('products.index', [
            'title' => 'Product List',
            'categories_data' => $categoriesData,
            'products_data' => $productsData,
        ]);
    }

    public function show($slug) {
        LogActivity::storeLogActivity('Membuka halaman Product Detail.');
        $productData = (new Product)->getProductBySlug($slug);
        $categoryData = (new Category)->getCategoryById($productData->category_id)->name_category;
        $picturesData = (new Picture)->getPicturesByProductId($productData->id);

        return view('products.show', [
            'title' => $productData->name_product,
            'product_data' => $productData,
            'category_name' => $categoryData,
            'pictures_data' => $picturesData,
        ]);
    }
}
