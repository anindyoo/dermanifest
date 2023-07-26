<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function getProvinces() {
        $responseProvince = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->get('https://api.rajaongkir.com/starter/province');        
        
        $provinces = $responseProvince['rajaongkir']['results'];

        return $provinces;
    }
 
    public function getCities() {
        $responseCity = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->get('https://api.rajaongkir.com/starter/city');        
        $cities = $responseCity['rajaongkir']['results'];

        return $cities;
    }

    public function citiesByProvinceId($province_id) {
        $responseCity = Http::withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->get('https://api.rajaongkir.com/starter/city?province=' . $province_id);  
        
        $citiesByProvinceId = $responseCity['rajaongkir']['results'];
        
        return $citiesByProvinceId;
    }
}