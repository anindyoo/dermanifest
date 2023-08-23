<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index() {
        $faqsData = Faq::all();

        return view('contact.index', [
            'title' => 'Contact & FAQ',
            'faqs_data' => $faqsData,
        ]);
    }

}
