<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class RajaOngkirController extends Controller
{
    public function getProvinces() {
        try {
            $responseProvince = Http::withHeaders([
                'key' => env('RAJAONGKIR_KEY')
            ])->get('https://api.rajaongkir.com/starter/province');        
            
            $provinces = $responseProvince['rajaongkir']['results'];
            
            return $provinces;
        } catch (Throwable $th) {
            return redirect('/');
        }
    }
 
    public function getCities() {
        try {
            $responseCity = Http::withHeaders([
                'key' => env('RAJAONGKIR_KEY')
            ])->get('https://api.rajaongkir.com/starter/city');        
            $cities = $responseCity['rajaongkir']['results'];
    
            return $cities;
        } catch (Throwable $th) {
            return redirect('/');
        }
    }

    public function citiesByProvinceId($province_id) {
        try {
            $responseCity = Http::withHeaders([
                'key' => env('RAJAONGKIR_KEY')
            ])->get('https://api.rajaongkir.com/starter/city?province=' . $province_id);  
            
            $citiesByProvinceId = $responseCity['rajaongkir']['results'];
            
            return $citiesByProvinceId;
        } catch (Throwable $th) {
            return redirect('/');
        }
    }

    public function getDeliveryCost(Request $request) {    
        $reponseCostJNE = $this->getDeliveryCostByCourier($request, 'jne');
        $reponseCostTIKI = $this->getDeliveryCostByCourier($request, 'tiki');
        $reponseCostPOS = $this->getDeliveryCostByCourier($request, 'pos');

        $reponseCost = [
            'jne' => $reponseCostJNE['rajaongkir']['results'][0]['costs'],
            'tiki' => $reponseCostTIKI['rajaongkir']['results'][0]['costs'],
            'pos' => $reponseCostPOS['rajaongkir']['results'][0]['costs'],
        ];

        return $reponseCost;
    }

    public function getDeliveryCostByCourier($request, $courier) {
        try {
                $cost = Http::withHeaders([
                'key' => env('RAJAONGKIR_KEY')
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin' => 155, // Jakarta Utara
                'destination' => $request->option['destination'],
                'weight' => $request->option['weight'],
                'courier' => $courier,
            ]);

            return $cost;
        } catch (Throwable $th) {
            return redirect('/');
        }
    }
}