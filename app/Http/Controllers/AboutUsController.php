<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman About Us.');
        return view('about_us.index', ['title' => 'About Us']);
    }
}
