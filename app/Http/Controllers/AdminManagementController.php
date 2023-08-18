<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminManagementController extends Controller
{
    public function index() {
        $adminsData = Admin::all();

        return view('admin.admins_management.index', [
            'title' => 'Admins Management',
            'admins_data' => $adminsData,
        ]);
    }
}
