<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\LogActivity;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Admin FAQs.', 'admin');
        $faqsData = Faq::all();
        
        return view('admin.faqs.index', [
            'title' => 'Admin FAQs',
            'faqs_data' => $faqsData,
        ]);
    }

    public function create() {
        LogActivity::storeLogActivity('Membuka halaman Add FAQ.', 'admin');
        return view('admin.faqs.create', [
            'title' => 'Add FAQ',
        ]);
    }

    public function edit($id) {
        $faqData = Faq::find($id);
        LogActivity::storeLogActivity('Membuka halaman FAQ Detail: Id #' . $id . '.', 'admin');
        
        return view('admin.faqs.edit', [
            'title' => 'Edit Faq',
            'faq_data' => $faqData,
        ]);
    }
    
    public function store(Request $request) {
        $validatedData = $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);
        $createFaq = Faq::create($validatedData);
        LogActivity::storeLogActivity('Menambahkan FAQ: Id #' . $createFaq->id . '.', 'admin');
        
        return redirect('/admin/faqs')->with('success', 'New FAQ has successfully been added.');
    }

    public function update(Request $request, Faq $faq) {
        $validatedData = $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);        
        Faq::where('id', $faq->id)->update($validatedData);
        LogActivity::storeLogActivity('Memperbarui Faq: Id #' . $faq->id . '.', 'admin');
        
        return redirect('/admin/faqs')->with('success', '<strong>FAQ #' . $faq->id . '</strong> has successfully been updated.');
    }
    
    public function destroy(Faq $faq) {
        Faq::destroy($faq->id);
        LogActivity::storeLogActivity('Menghapus Faq: Id #' . $faq->id . '.', 'admin');

        return redirect('/admin/faqs')->with('success', '<strong>FAQ #' . $faq->id . '</strong> has successfully been deleted.');
    }
}
