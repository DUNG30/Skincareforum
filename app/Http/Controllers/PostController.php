<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // Lưu bình luận mới
    public function store(Request $request)
    {
        $request->validate([
            'content'   => 'required|string',
            'thread_id' => 'required|exists:threads,id',
        ]);

        // Tạo bình luận
        Post::create([
            'content'   => $request->content,
            'thread_id' => $request->thread_id,
            'user_id'   => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được đăng!');
    }
}
