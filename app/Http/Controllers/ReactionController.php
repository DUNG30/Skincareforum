<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Reaction;

class ReactionController extends Controller
{
    /**
     * Xử lý reaction cho bài post
     */
    public function react(Post $post, Request $request)
    {
        $request->validate([
            'type' => 'required|string'
        ]);

        $userId = auth()->id();

        // Kiểm tra user đã reaction chưa
        $reaction = Reaction::where('post_id', $post->id)
                            ->where('user_id', $userId)
                            ->first();

        if ($reaction) {
            // Nếu cùng loại → bỏ reaction
            if ($reaction->type === $request->type) {
                $reaction->delete();
                $userReaction = null;
            } else {
                // Nếu khác loại → đổi reaction
                $reaction->type = $request->type;
                $reaction->save();
                $userReaction = $reaction->type;
            }
        } else {
            // Nếu chưa có → thêm mới
            $reaction = Reaction::create([
                'post_id' => $post->id,
                'user_id' => $userId,
                'type'    => $request->type
            ]);
            $userReaction = $reaction->type;
        }

        // Đếm lại
        $counts = Reaction::where('post_id', $post->id)
                          ->selectRaw('type, COUNT(*) as total')
                          ->groupBy('type')
                          ->pluck('total', 'type');

        return response()->json([
            'success' => true,
            'user_reaction' => $userReaction,
            'counts' => $counts
        ]);
    }


    /**
     * Danh sách người đã reaction
     */
    public function listReactors(Post $post)
    {
        $list = Reaction::where('post_id', $post->id)
                        ->with('user:id,name')
                        ->get()
                        ->map(function ($r) {
                            return [
                                'user_name' => $r->user->name ?? 'Người dùng ẩn',
                                'type' => $r->type
                            ];
                        });

        return response()->json([
            'list' => $list
        ]);
    }
}
