<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index() {
        $faqsData = Faq::all();

        return view('admin.faqs.index', [
            'title' => 'Admin FAQs',
            'faqs_data' => $faqsData,
        ]);
    }

    public function create() {
        return view('admin.faqs.create', [
            'title' => 'Add FAQ',
        ]);
    }

    public function edit($id) {
        $faqData = Faq::find($id);

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
        Faq::create($validatedData);

        return redirect('admin/faqs')->with('success', 'New FAQ has successfully been added.');
    }

    public function update(Request $request, Faq $faq) {
        $validatedData = $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);        
        Faq::where('id', $faq->id)->update($validatedData);

        return redirect('admin/faqs')->with('success', 'Faq has successfully been updated.');
    }
}
