<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index() {
        $messagesData = Message::all();
        return view('admin.messages.index', [
            'title' => 'Admin Messages',
            'messages_data' => $messagesData,
        ]);
    }
    
}
