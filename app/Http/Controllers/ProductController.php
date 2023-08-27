<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Product;
use App\Models\Category;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProductController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Admin Products.', 'admin');
        $productsData = Product::all();
        foreach ($productsData as $key => $product) {
            $productsData[$key]['category_name'] = (new Category)->getCategoryById($product->category_id)->name_category;
        }
        
        return view('admin.products.index', [
            'title' => 'Products',
            'products_data' => $productsData,
        ]);
    }
    
    public function create() {
        LogActivity::storeLogActivity('Membuka halaman Add Product.', 'admin');
        $categoriesData = Category::all();
        
        return view('admin.products.create', [
            'title' => 'Add Category',
            'categories_data' => $categoriesData,
        ]);
    }
    
    public function show($id) {
        $productData = (new Product)->getProductById($id);
        $categoryData = (new Category)->getCategoryById($productData->category_id)->name_category;
        $picturesData = (new Picture)->getPicturesByProductId($productData->id);
        LogActivity::storeLogActivity('Membuka halaman Admin Product Detail: ' . $productData->name_product . '.', 'admin');
        
        return view('admin.products.show', [
            'title' => 'Product Detail',
            'product_data' => $productData,
            'category_name' => $categoryData,
            'pictures_data' => $picturesData,
        ]);
    }

    public function edit($id) {
        $productData = (new Product)->getProductById($id);
        $categoriesData = Category::all();
        LogActivity::storeLogActivity('Membuka halaman Admin Edit Product: ' . $productData->name_product . '.', 'admin');
        
        return view('admin.products.edit', [
            'title' => 'Edit Products',
            'product_data' => $productData,
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
        $request->pictures[0]->storeAs('products', $mainPicNewName);
        $validatedData['main_picture'] = $mainPicNewName;
        
        $createProduct = Product::create($validatedData);
        $lastInsertedProductId = $createProduct->id;

        date_default_timezone_set("Asia/Jakarta");
        $date_created = date('d-m-Y_H-i-s');

        if ($request->file('pictures')) {
            foreach ($request->file('pictures') as $key => $pic) {
                $extension = $pic->getClientOriginalExtension();
                $newPicName =  $request->slug . '_' . $key . '_' . $date_created . '.' . $extension;
                $pic->storeAs('products', $newPicName);

                Picture::create([
                    'product_id' => $lastInsertedProductId,
                    'name_picture' => $newPicName,
                ]);
            }
        }
        LogActivity::storeLogActivity('Menambahkan Product baru: ' . $validatedData['name_product'] . '.', 'admin');
        
        return redirect('/admin/products')->with('success', 'Product: <strong>' . $request->name_product . '</strong> has been added.');
    }
    
    public function update(Request $request, Product $product) {
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
            'main_picture' => 'image',
        ]);  

        if (isset($validatedData['main_picture'])) {
            $oldPicture = $product->main_picture;
            Storage::delete("products/$oldPicture");
            
            $extension = $request->file('main_picture')->getClientOriginalExtension();
            $newPicName =  $request->slug . '-' . '0' . '.' . $extension;
            $request->file('main_picture')->storeAs('products', $newPicName);
            $validatedData['main_picture'] = $newPicName;
            Picture::where('name_picture', $oldPicture)->update(['name_picture' => $newPicName]);
        }
        Product::where('id', $product->id)->update($validatedData);
        LogActivity::storeLogActivity('Memperbarui Product: id' . $product->id . '.', 'admin');

        return redirect('admin/products')->with('Product has been updated.');
    }

    public function destroy(Product $product) {
        $picturesData = (new Picture)->getPicturesByProductId($product->id);
        foreach ($picturesData as $pic) {
            Storage::delete("products/$pic->name_picture");
        }
        Product::destroy($product->id);
        LogActivity::storeLogActivity('Menambahkan Product baru: ' . $product->name_product . '.', 'admin');

        return redirect('admin/products')->with('success', 'Product: <strong>' . $product->name_product . '</strong> has been deleted.');
    }
}
