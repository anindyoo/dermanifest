<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\LogActivity;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index() {
        LogActivity::storeLogActivity('Membuka halaman Admin Messages.', 'admin');
        $messagesData = Message::all();
        return view('admin.messages.index', [
            'title' => 'Admin Messages',
            'messages_data' => $messagesData,
        ]);
    }

    public function show($id) {
        LogActivity::storeLogActivity('Membuka halaman Admin Message Detail: Id #' . $id . '.', 'admin');
        $messageData = Message::find($id);
        return view('admin.messages.show', [
            'title' => 'Message Detail',
            'message_data' => $messageData,
        ]);
    }
    
    public function update(Request $request) {
        Message::find($request->id)->update(['is_read' => $request->is_read]);
        LogActivity::storeLogActivity('Memperbarui status Message: Id #' . $request->id . '.', 'admin');
        if ($request->is_read == 1) {
            return back()->with('success', 'Message has been marked as Read.');
        } 
        return back()->with('success', 'Message has been marked as Unread.');
    }

    public function destroy(Message $message) {
        Message::destroy($message->id);
        LogActivity::storeLogActivity('Menghapus Message: Id #' . $message->id . '.', 'admin');

        return back()->with('success', '<strong> Message #' . $message->id . '</strong> has been deleted.');
    }
}
