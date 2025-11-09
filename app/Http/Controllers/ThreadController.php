<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\User;

class ThreadController extends Controller
{
    public function index() {
        $threads = Thread::latest()->with('user', 'images', 'posts')->get();
        return view('threads.index', compact('threads'));
    }
    public function create() {
        return view('threads.create');
    }

 public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'hashtags' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $thread = auth()->user()->threads()->create($request->only('title', 'body', 'hashtags'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('threads', 'public');
                $thread->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('threads.index')->with('success', 'Tạo chủ đề thành công!');
    }
    public function show(Thread $thread) {
       $thread->load('images', 'posts.user');
        // Top bình luận nổi bật (5 bình luận dài nhất)
        $topComments = $thread->posts()
            ->with('user')
            ->orderByRaw('LENGTH(content) DESC')
            ->take(5)
            ->get();

        // Người dùng tích cực nhất
        $topUsers = User::withCount('posts')
            ->orderByDesc('posts_count')
            ->take(5)
            ->get();

        return view('threads.show', compact('thread', 'topComments', 'topUsers'));
    }
}
