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

    public function store(Request $request) {
        $validatedData = $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);
        Faq::create($validatedData);

        return redirect('admin/faqs')->with('success', 'New FAQ has been added.');
    }
}
