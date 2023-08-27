<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Picture;
use App\Models\Product;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    public function show($product_id) {
        $productData = (new Product)->getProductById($product_id);
        $productPicsturesData = (new Picture)->getPicturesByProductId($productData->id);
        LogActivity::storeLogActivity('Membuka halaman Product Pictures Management.', 'admin');

        return view('admin.products.pictures', [
            'title' => 'Product Pictures Management',
            'product_data' => $productData,
            'product_pictures_data' => $productPicsturesData,
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'pictures.*' => 'required|image',
        ]);
        $product = (new Product)->getProductById($request->product_id);
        $productPicturesCount = count((new Picture)->getPicturesByProductId($request->product_id));

        date_default_timezone_set("Asia/Jakarta");
        $date_created = date('d-m-Y_H-i-s');
    
        foreach ($validatedData['pictures'] as $key => $pic) {
            $extension = $pic->getClientOriginalExtension();
            $newPicName =  $product->slug . '_' . $productPicturesCount + $key . '_' . $date_created . '.' . $extension;
            
            $pic->storeAs('products', $newPicName);

            Picture::create([
                'product_id' => $request->product_id,
                'name_picture' => $newPicName,
            ]);
        }
        LogActivity::storeLogActivity('Menambahkan gambar baru pada Product: ' . $product->name_product . '.', 'admin');
        
        return redirect("/admin/pictures/$request->product_id")->with('success', 'New additional product pictures have been added.');
    }
    
    public function destroy(Picture $picture) {
        Storage::delete("products/$picture->name_picture");
        Picture::destroy($picture->id);
        LogActivity::storeLogActivity('Menghapus gambar Product: ' . $picture->id . '.', 'admin');

        return redirect("admin/pictures/$picture->product_id")->with('success', 'Picture: <strong>' . $picture->name_picture . '</strong> has been deleted.');
    }
}
