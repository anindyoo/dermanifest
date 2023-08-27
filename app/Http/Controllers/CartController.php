<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\LogActivity;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        if (session()->has('cart')) {
            LogActivity::storeLogActivity('Membuka halaman Cart terisi.');
            $cart = $this->getCart();
            $cartItems = $cart['cart_items'];
            $productsData = $cart['products_data'];
        } else {
            LogActivity::storeLogActivity('Membuka halaman Cart kosong.');
            $cartItems = [];
            $productsData = [];
        }
        
        return view('cart.index' , [
            'title' => 'Cart',
            'cart_items' => $cartItems,
            'products_data' => $productsData,
        ]);
    }
    
    public function store(Request $request) {    
        $productData = Product::findOrFail($request->id);
        
        $cart = session()->get('cart', []);

        if (!isset($cart['quantity_total'])) {
            $cart['quantity_total'] = 0;
        }
        
        if (isset($cart['products'][$request->id])) {
            $cart['products'][$request->id]['quantity']++;
            $cart['quantity_total']++;
        } else {
            $cart['products'][$request->id] = [
                'quantity' => 1,
                'product_id' => $productData->id,
            ];  
            $cart['quantity_total']++;
        }
        session()->put('cart', $cart);
        LogActivity::storeLogActivity('Menambahkan produk ke cart.');

        return redirect()->back()->with('success', 'Product: <strong>' . $productData->name_product . '</strong> has been add to cart');
    }

    public function update(Request $request) {
        $cart = session()->get('cart', []);
        $productData = Product::findOrFail($request->id);
        $cartItems = $cart['products'];
        $request->validate([
            'item_quantity' => 'integer|min:1|max:' . $productData->stock,
        ], [
            'item_quantity.max' => 'The quantity for <strong>' . $productData->name_product . '</strong> must not be greater than ' . $productData->stock . '.'
        ]);
        foreach ($cartItems as $key => $item) {
            if ($item['product_id'] == $request->id) {
                $cart['products'][$key]['quantity'] = (int)$request->item_quantity;
            }
        }
        session()->put('cart', $cart);
        LogActivity::storeLogActivity('Memperbarui jumlah produk di cart.');
        
        return redirect('/cart')->with('success', 'The quantity of <strong>' . $productData->name_product . '</strong> has been updated.');
    }

    public function destroy(Request $request) {
        $cart = session()->get('cart', []);
        $productData = Product::findOrFail($request->id);
        $cartItems = $cart['products'];
        foreach ($cartItems as $key => $item) {
            if ($item['product_id'] == $request->id) {
                unset($cart['products'][$key]);
            }
        }
        session()->put('cart', $cart);
        LogActivity::storeLogActivity('Menghapus produk dari cart.');
        
        return redirect('/cart')->with('success', '<strong>' . $productData->name_product . '</strong> has been removed from cart.');
    }

    public function destroyAll() {
        session()->forget('cart');
        LogActivity::storeLogActivity('Mengosongkan isi cart.');
        
        return redirect('/cart')->with('success', 'Cart has been emptied.');
    }

    public function getCart() {
        $cart = session('cart');
        $cartData = session()->get('cart');
        $cartItems = $cartData['products'];
        $productsData = [];

        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);
            if ($product != null) {
                if ($product->stock != 0) {
                    $productsData[$product->id] = $product;
                }
            }
        }

        foreach ($productsData as $product) {
            $product['category_name'] = Category::findOrFail($product->category_id)->name_category;
        }    

        $cart['quantity_total'] = $this->quantityTotal($cart);
        $cart['gross_weight_total'] = $this->grossWeightTotal($cart);
        $cart['subtotal'] = $this->subtotal($cart);
        session()->put('cart', $cart);

        return  [
            'cart_items' => $cartItems,
            'products_data' => $productsData,
        ];
    }

    public function subtotal($cart) {
        $cartItems = $cart['products'];
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $productData = Product::findOrFail($item['product_id']);
            if ($productData->discount_price > 0) {
                $subtotal += $item['quantity'] * $productData->discount_price;
            } else {
                $subtotal += $item['quantity'] * $productData->price;
            }
        }

        return $subtotal;
    }

    public function quantityTotal($cart) {
        $cartItems = $cart['products'];
        $quantityTotal = 0;

        foreach ($cartItems as $item) {
            $quantityTotal += $item['quantity'];
        }

        return $quantityTotal;
    }

    public function grossWeightTotal($cart) {
        $cartItems = $cart['products'];
        $grossWeightTotal = 0;
        foreach ($cartItems as $item) {
            $productData = Product::findOrFail($item['product_id']);
            $grossWeightTotal += $item['quantity'] * $productData['gross_weight'];
        }
        return $grossWeightTotal;
    }
}
