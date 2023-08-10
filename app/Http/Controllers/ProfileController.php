<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProfileController extends Controller
{
    public function index() {
        $customerAddresses = (new Address)->getAddressesByCustomerId(Auth::user()->id);
        $customerOrders = Order::whereIn('customer_id', [Auth::user()->id])->get();
        
        return view('profile.index', [
            'title' => 'Profile',
            'addresses' => $customerAddresses,
            'orders' => $customerOrders,
        ]);
    }

    public function createAddress() {
        $provincesFinal = $this->getProvincesOptions();
        return view('profile.createAddress', [
            'title' => 'Add Address',
            'provinces' => $provincesFinal,
        ]);
    }

    public function updateAddress($address_id) {
        $addressById = Address::where('id', $address_id)->first();

        $provincesFinal = $this->getProvincesOptions();

        return view('profile.updateAddress', [
            'title' => 'Edit Address',
            'provinces' => $provincesFinal,
            'address_id' => $address_id,
            'address_data' => $addressById,
        ]);
    }

    public function updateProfile(Request $request) {
        $customer_id = Auth::user()->id;
        $validatedData = $request->validate([
            'name_customer' => 'required|max:255',
            'phone' => 'required|numeric|digits_between:8,13|unique:customers',
        ]);
        Customer::where('id', $customer_id)->update($validatedData);
        return redirect('profile')->with('success', 'Profile data has been updated.');
    }

    public function updatePassword(Request $request) {
        $customer_id = Auth::user()->id;
        
        $validator = Validator::make($request->all(), [
            'password' => 'required|between:6,255|confirmed',
        ]);
        
        if ($validator->fails()) {
            return redirect('profile')->with('fail', 'Failed to update password. Passwords confirmation doesn\'t match');
        }
        
        $validated = $validator->validated();
        $validated['password'] = Hash::make($validated['password']);
        
        Customer::where('id', $customer_id)->update($validated);
        
        return redirect('profile')->with('success', 'Password has been updated.');
    }

    public function storeAddress(Request $request) {
        $validatedData = $request->validate([
            'province_api_id' => 'required|numeric',
            'city_api_id' => 'required|numeric',
            'name_address' => 'required|max:255',
            'address' => 'required',
            'province' => 'required|max:255',
            'city' => 'required|max:255',
            'postal_code' => 'required|numeric'
        ]);
        $validatedData['customer_id'] = Auth::user()->id;
    
        Address::create($validatedData);    
        return redirect('/profile')->with('success', 'Address has been successfully added.');
    }

    public function updateAddressValidate($address_id, Request $request) {
        $validatedData = $request->validate([
            'province_api_id' => 'required|numeric',
            'city_api_id' => 'required|numeric',
            'name_address' => 'required|max:255',
            'address' => 'required',
            'province' => 'required|max:255',
            'city' => 'required|max:255',
            'postal_code' => 'required|numeric' 
        ]);
        Address::where('id', $address_id)->update($validatedData);
        return redirect('profile')->with('success', 'Address has been updated.');
    }

    public function deleteAddress($address_id) {
        Address::destroy($address_id);
        return redirect('profile')->with('success', 'Address has been deleted.');
    }
    
    public function getProvincesOptions() {
        try {
            $provinces = (new RajaOngkirController)->getProvinces();
    
            $optionProvince = array_map(function ($prov) {
                return '<option id="' . $prov['province_id'] . '" value="' . $prov['province'] . '" province_id="' . $prov['province_id'] . '">' . $prov['province'] . '</option>';
            }, $provinces);
    
            return implode("\n", $optionProvince);
        } catch (Throwable $th) {
            return '<option>API LIMIT: Please report us via dermanifest@gmail.com for resolving this case.</option>';
        }
    }
}
