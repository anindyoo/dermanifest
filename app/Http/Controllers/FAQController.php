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
}
