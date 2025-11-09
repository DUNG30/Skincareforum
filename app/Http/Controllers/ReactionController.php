<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;

class ReactionController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'thread_id' => 'required|exists:threads,id',
            'type' => 'required|string|max:50',
        ]);

        $user = $request->user();
        $threadId = $request->thread_id;
        $type = $request->type;

        // Kiểm tra reaction của user đã có cho thread chưa
        $reaction = Reaction::where('user_id', $user->id)
            ->where('thread_id', $threadId)
            ->first();

        if ($reaction) {
            // Nếu cùng type -> xóa reaction (bỏ like)
            if ($reaction->type === $type) {
                $reaction->delete();
                return response()->json(['status' => 'removed']);
            } else {
                // Nếu khác type -> update type
                $reaction->update(['type' => $type]);
                return response()->json(['status' => 'updated']);
            }
        } else {
            // Chưa có reaction -> tạo mới
            Reaction::create([
                'user_id' => $user->id,
                'thread_id' => $threadId,
                'type' => $type,
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}
