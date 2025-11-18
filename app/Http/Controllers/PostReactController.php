<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostReactController extends Controller
{
    public function toggle(Post $post)
    {
        $userId = Auth::id();
        $react = $post->reactions()->where('user_id', $userId)->first();

        if ($react) {
            $react->delete();
            $liked = false;
        } else {
            $post->reactions()->create(['user_id' => $userId]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'total' => $post->reactions()->count()
        ]);
    }
}