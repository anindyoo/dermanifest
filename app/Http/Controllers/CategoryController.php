<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\LogActivity;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Admin Categories.', 'admin');
        $categoriesData = Category::all();
        
        return view('admin.categories.index', [
            'title' => 'Categories',
            'categories_data' => $categoriesData,
        ]);
    }

    public function create() {
        LogActivity::storeLogActivity('Membuka halaman Add Category.', 'admin');
        return view('admin.categories.create', [
            'title' => 'Add Category'
        ]);
    }

    public function edit($id) {
        $categoryData = Category::findOrFail($id);
        LogActivity::storeLogActivity('Membuka halaman Admin Edit Category.', 'admin');

        return view('admin.categories.edit', [
            'title' => 'Edit Category',
            'category_data' => $categoryData,
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name_category' => 'required|max:255',
            'description_category' => 'required',
        ]);
        Category::create($validatedData);
        LogActivity::storeLogActivity('Menambahkan Category: ' . $validatedData['name_category'] . '.', 'admin');

        return redirect('admin/categories')->with('success', 'New Category: <strong>' . $request->name_category . '</strong> has been added.');
    }

    public function update(Request $request, Category $category) {
        $validatedData = $request->validate([
            'name_category' => 'required|max:255',
            'description_category' => 'required',
        ]);        
        Category::where('id', $category->id)->update($validatedData);
        LogActivity::storeLogActivity('Memperbarui Category: ' . $category->name_category . ' -> ' . $validatedData['name_category'] . '.', 'admin');

        return redirect('admin/categories')->with('success', 'Category has been updated.');
    }

    public function destroy(Category $category) {
        Category::destroy($category->id);
        LogActivity::storeLogActivity('Menghapus Category: ' . $category->name_category . '.', 'admin');

        return redirect('admin/categories')->with('success', 'Category: <strong>' . $category->name_category . '</strong> has been deleted.');
    }
}
