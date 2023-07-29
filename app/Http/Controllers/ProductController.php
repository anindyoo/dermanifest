<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Picture;
use App\Models\Product;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProductController extends Controller
{
    public function index() {
        $productsData = Product::all();

        foreach ($productsData as $key => $product) {
            $productsData[$key]['category_name'] = (new Category)->getCategoryById($product->category_id)->name_category;
        }

        return view('admin.products.index', [
            'title' => 'Products',
            'categories_data' => '$categoriesData',
            'products_data' => $productsData,
        ]);
    }

    public function create() {
        $categoriesData = Category::all();

        return view('admin.products.create', [
            'title' => 'Add Category',
            'categories_data' => $categoriesData,
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name_product' => 'required|max:255',
            'category_id' => 'required',
            'slug' => 'required|max:255',
            'price' => 'required',
            'discount_price' => '',
            'stock' => 'required',
            'description' => 'required',
            'instruction' => 'required',
            'ingredients' => 'required',
            'gross_weight' => 'required',
            'net_weight' => 'required',
            'pictures.0' => 'required|image',
            'pictures.*' => 'image',
        ]);        

        $mainPicExtension = $request->pictures[0]->getClientOriginalExtension();
        $mainPicNewName =  $request->slug . '-0.' . $mainPicExtension;
        $mainPicture = $request->pictures[0]->storeAs('products', $mainPicNewName);
        $validatedData['main_picture'] = $mainPicture;

        $createProduct = Product::create($validatedData);
        $lastInsertedProductId = $createProduct->id;

        if ($request->file('pictures')) {
            foreach ($request->file('pictures') as $key => $pic) {
                $extension = $pic->getClientOriginalExtension();
                $newPicName =  $request->slug . '-' . $key . '.' . $extension;
                $pic->storeAs('products', $newPicName);

                Picture::create([
                    'product_id' => $lastInsertedProductId,
                    'name_picture' => $newPicName,
                ]);
            }
        }

        return redirect('/admin/products')->with('success', 'Product: <strong>' . $request->name_product . '</strong> has been added.');
    }
    
}
