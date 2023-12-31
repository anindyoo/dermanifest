<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TopProduct;
use App\Models\LogActivity;

use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class TopProductController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Top Products Management.', 'admin');
        $topProductsData = TopProduct::all();
        $productsData = Product::all();

        return view('admin.top_products.index', [
            'title' => 'Top Products Management',
            'top_products_data' => $topProductsData,
            'products_data' => $productsData,
        ]);
    }

    public function store(Request $request) {
        $topProductsData = TopProduct::all();
        for ($i = 0; $i < 5; $i -=- 1) {
            if ($topProductsData->isEmpty()) {
                if ($request['product_id'][$i] != null) {
                    TopProduct::create([
                        'product_id' => $request['product_id'][$i],
                        'position' => $request['position'][$i],
                    ]);
                } else {
                    TopProduct::create([
                        'product_id' => null,
                        'position' => $request['position'][$i],
                    ]);
                }
            } else {
                if ($request['product_id'][$i] != null) {
                    TopProduct::where('position', $i)->update(['product_id' => $request['product_id'][$i]]);            
                } else {
                    TopProduct::where('position', $i)->update(['product_id' => null]);            
                }
                
            }
        }
        LogActivity::storeLogActivity('Menetapkan Top Products.', 'admin');

        return redirect('admin/top_products')->with('success', 'Top Products have been saved.');
    }
}
