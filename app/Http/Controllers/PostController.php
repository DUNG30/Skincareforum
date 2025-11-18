<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // quan trọng để dùng Http::post

class PostController extends Controller
{
    public function store(Request $request)
    {
        // Dữ liệu bài viết từ user
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'status' => 'pending'
        ];

        // Gửi bài viết tới Project Admin qua API
        $response = Http::post('http://admin-project.test/api/posts', $data);

        if($response->successful()){
            return back()->with('success','Bài viết đã gửi admin!');
        } else {
            return back()->with('error','Gửi bài thất bại!');
        }
    }
}
