<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AdminManagementController extends Controller
{
    public function index() {
        $adminsData = Admin::all();

        return view('admin.admins_management.index', [
            'title' => 'Admins Management',
            'admins_data' => $adminsData,
        ]);
    }

    public function create() {
        return view('admin.admins_management.create', [
            'title' => 'Add Admin',
        ]);
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name_admin' => 'required|max:255',
            'email' => 'required|email:dns|unique:customers|unique:admins',
            'password' => 'required|between:6,255|confirmed',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $admin = Admin::create($validatedData);

        return redirect('/admin/admins_management')->with('success', 'Admin: <strong>' . $request->name_admin . '</strong> has successfully been added.');
    }

    public function destroy(Request $request, Admin $admin) {        
        Admin::destroy($request->id);

        return redirect('/admin/admins_management')->with('success', 'Admin: <strong>' . $admin->name_admin . '</strong> has been deleted.');
    }
}
