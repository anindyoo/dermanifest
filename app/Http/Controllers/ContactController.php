<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Message;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Contact & FAQ.');
        $faqsData = Faq::all();

        return view('contact.index', [
            'title' => 'Contact & FAQ',
            'faqs_data' => $faqsData,
        ]);
    }

    public function store(Request $request) {
        if (Auth::check()) {
            $validatedData = $request->validate([
                'email' => 'required|email:dns|max:255',
                'phone' => 'required|numeric|digits_between:8,13',
                'subject' => 'required|max:255',
                'message' => 'required',
            ]);
            $validatedData['customer_id'] = Auth::user()->id;
            Message::create($validatedData);
            LogActivity::storeLogActivity('Mengirimkan pesan melalui halaman Contact Us.');
            return back()->with('success', 'Message has successfully been sent! Thank you.');
        }

        return back()->with('danger', 'Please login first in order to submit a message.');
    }
}
