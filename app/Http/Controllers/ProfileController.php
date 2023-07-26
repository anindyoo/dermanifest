<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index() {
        $provincesFinal = $this->getProvincesOptions();
        $customerAddresses = Address::whereIn('id_customer', [Auth::user()->id])->get();
        
        return view('profile.index', [
            'title' => 'Profile',
            'provinces' => $provincesFinal,
            'addresses' => $customerAddresses,
        ]);
    }

    public function updateAddress($address_id) {
        $addressById = Address::where('id', $address_id)->first();

        $provincesFinal = $this->getProvincesOptions();
        $provinces = (new RajaOngkirController)->getProvinces();

        $selectedProvince = '';
        foreach ($provinces as $prov) {
            if ($prov['province'] == $addressById->province) {
                $selectedProvince = '<option id="' . $prov['province_id'] . '" value="' . $prov['province'] . '" province_id="' . $prov['province_id'] . '" selected>' . $prov['province'] . '</option>';
            }
        }

        return view('profile.updateAddress', [
            'title' => 'Edit Address',
            'provinces' => $provincesFinal,
            'address_id' => $address_id,
            'address_data' => $addressById,
            'selected_province' => $selectedProvince,
        ]);
    }

    public function updateProfile(Request $request) {
        $id_customer = Auth::user()->id;
        $validatedData = $request->validate([
            'name_customer' => 'required|max:255',
            'phone' => 'required|numeric|digits_between:8,13|unique:customers',
        ]);
        Customer::where('id', $id_customer)->update($validatedData);
        return redirect('profile')->with('success', 'Profile data has been updated.');
    }

    public function updatePassword(Request $request) {
        $id_customer = Auth::user()->id;
        
        $validator = Validator::make($request->all(), [
            'password' => 'required|between:6,255|confirmed',
        ]);
        
        if ($validator->fails()) {
            return redirect('profile')->with('fail', 'Failed to update password. Passwords confirmation doesn\'t match');
        }
        
        $validated = $validator->validated();
        $validated['password'] = Hash::make($validated['password']);
        
        Customer::where('id', $id_customer)->update($validated);
        
        return redirect('profile')->with('success', 'Password has been updated.');
    }

    public function addAddress(Request $request) {
        $validatedData = $request->validate([
            'name_address' => 'required|max:255',
            'address' => 'required',
            'province' => 'required|max:255',
            'city' => 'required|max:255',
            'postal_code' => 'required|numeric'
        ]);
        $validatedData['id_customer'] = Auth::user()->id;

        $totalAddress = count(Address::where('id_customer', Auth::user()->id)->get());
        if (($totalAddress) >= 3) {
            return redirect('/profile')->with('fail', 'Failed to add address. You have reached the maximum amount of addresses.');
        }
    
        Address::create($validatedData);    
        return redirect('/profile')->with('success', 'Address has been successfully added.');
    }

    public function updateAddressValidate($address_id, Request $request) {
        $validatedData = $request->validate([
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
        $provinces = (new RajaOngkirController)->getProvinces();

        $optionProvince = array_map(function ($prov) {
            return '<option id="' . $prov['province_id'] . '" value="' . $prov['province'] . '" province_id="' . $prov['province_id'] . '">' . $prov['province'] . '</option>';
        }, $provinces);

        return implode("\n", $optionProvince);
    }
}
