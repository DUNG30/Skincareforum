<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')->latest()->take(50)->get()->reverse(); // lấy 50 tin nhắn gần nhất
        return view('chat.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
}
