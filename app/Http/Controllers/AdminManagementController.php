<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AdminManagementController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Admins Management.', 'admin');
        $adminsData = Admin::all();

        return view('admin.admins_management.index', [
            'title' => 'Admins Management',
            'admins_data' => $adminsData,
        ]);
    }

    public function create() {
        LogActivity::storeLogActivity('Membuka halaman Add Admin.', 'admin');
        return view('admin.admins_management.create', [
            'title' => 'Add Admin',
        ]);
    }

    public function showAdminLog($admin_id) {
        $logData = LogActivity::getLogActivityByAdminId($admin_id);
        $adminData = Admin::find($admin_id);
        LogActivity::storeLogActivity('Membuka halaman Admin Log Activity: ' . $adminData->name_admin . '.', 'admin');

        return view('admin.admins_management.log_activity', [
            'title' => 'Admin Log Activities Detail',
            'admin_data' => $adminData,
            'log_data' => $logData,
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
        LogActivity::storeLogActivity('Membuat akun Admin baru: ' . $validatedData['name_admin'] . ' .', 'admin');

        return redirect('/admin/admins_management')->with('success', 'Admin: <strong>' . $request->name_admin . '</strong> has successfully been added.');
    }

    public function destroy(Request $request, Admin $admin) {        
        Admin::destroy($request->id);
        LogActivity::storeLogActivity('Menghapus akun Admin: ' . $admin->name_admin . '.', 'admin');

        return redirect('/admin/admins_management')->with('success', 'Admin: <strong>' . $admin->name_admin . '</strong> has been deleted.');
    }
}
