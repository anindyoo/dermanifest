<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return view('admin.categories.index', [
            "title" => "Categories"
        ]);
    }

    public function create() {
        return view('admin.categories.create', [
            "title" => "Add Category"
        ]);
    }
}
