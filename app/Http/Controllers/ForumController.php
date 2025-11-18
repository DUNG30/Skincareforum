<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    // Trang danh sách bài viết
    public function index(Request $request)
{
    $query = Post::query();

    // Tìm kiếm theo từ khóa
    if ($search = $request->input('search')) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
    }

    // Tìm theo category
    if ($category = $request->input('category')) {
        $query->where('category', $category);
    }

    // Tìm theo khoảng thời gian
    if ($from = $request->input('from')) {
        $query->whereDate('created_at', '>=', $from);
    }
    if ($to = $request->input('to')) {
        $query->whereDate('created_at', '<=', $to);
    }

    $posts = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('forum.index', compact('posts'));
}

    // Form tạo bài viết
    public function create()
    {
        return view('forum.create');
    }

    // Lưu bài viết
    public function store(Request $request)
{
    $post = new Post();
    $post->user_id = auth()->id();
    $post->title = $request->title;
    $post->content = $request->content;
    $post->category = $request->category;
    $post->media = $request->media; // đảm bảo đã là array hoặc JSON
    $post->save();

    // Redirect sang trang show
    return redirect()->route('forum.show', $post->id)
                     ->with('success', 'Bài viết đã được đăng thành công!');
}


    // Xử lý upload media
    protected function handleMedia($mediaFiles)
    {
        $mediaPaths = [];

        if ($mediaFiles && is_array($mediaFiles)) {
            foreach ($mediaFiles as $file) {
                if ($file) {
                    $path = $file->store('posts', 'public');
                    $mediaPaths[] = $path;
                }
            }
        }

        return $mediaPaths;
    }

    // Hiển thị bài viết
   public function show($id)
{
    $post = Post::with(['user', 'comments.user', 'reactions', 'images'])->find($id);

    if (!$post) {
        return redirect()->route('forum.index')->with('error', 'Bài viết không tồn tại');
    }

    return view('forum.show', compact('post'));
}

    // Form chỉnh sửa bài viết
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('forum.edit', compact('post'));
    }

    // Cập nhật bài viết
    public function update(Request $request, Post $post)
{
    if ($post->user_id !== Auth::id()) abort(403);

    $request->validate([
        'title'   => 'required|string|max:255',
        'content' => 'required|string',
        'media.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,webm|max:10240',
    ]);

    $mediaPaths = $post->media ?? [];

    if ($request->hasFile('media')) {
        foreach ($request->file('media') as $file) {
            $mediaPaths[] = $file->store('posts', 'public');
        }
    }

    $post->update([
        'title'   => $request->title,
        'content' => $request->content,
        'media'   => $mediaPaths,
    ]);

    return redirect()->route('forum.show', $post)->with('success', 'Cập nhật thành công');
}

    // Xóa bài viết
    public function destroy(Post $post)
{
    // Kiểm tra quyền
    if ($post->user_id !== auth()->id()) {
        abort(403);
    }

    // Xóa media nếu có
    if (!empty($post->media)) {
        $mediaFiles = is_string($post->media) ? json_decode($post->media, true) : $post->media;

        if (is_array($mediaFiles)) {
            foreach ($mediaFiles as $file) {
                Storage::disk('public')->delete($file);
            }
        }
    }

    // Xóa bài
    $post->delete();

    // Chuyển về trang chính với thông báo
    return redirect()->route('forum.store')->with('success', 'Xóa bài viết thành công');
}

    // Tìm kiếm
    public function search(Request $request)
    {
        $query = $request->input('q');

        $posts = Post::where('title', 'LIKE', "%$query%")
            ->orWhere('content', 'LIKE', "%$query%")
            ->paginate(10);

        return view('forum.index', compact('posts', 'query'));
    }

    // Gợi ý hashtag
    public function hashtagSuggestions(Request $request)
    {
        $term = $request->input('query');

        $hashtags = Post::where('content', 'LIKE', "%#$term%")
            ->pluck('content')
            ->flatMap(function ($content) {
                preg_match_all('/#(\w+)/', $content, $matches);
                return $matches[1];
            })
            ->unique()
            ->take(10)
            ->values();

        return response()->json($hashtags);
    }
      public function comment(Request $request, Post $post)
    {
        // Validate dữ liệu
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Tạo comment mới
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->content = $request->comment;
        $comment->save();

        return back()->with('success', 'Bình luận đã được đăng!');
    }
}

