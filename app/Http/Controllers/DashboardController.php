<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê chung
        $threadsCount = Thread::count();
        $postsCount = Post::count();
        $newThreadsThisWeek = Thread::where('created_at', '>=', Carbon::now()->subWeek())->count();
        $newPostsThisWeek = Post::where('created_at', '>=', Carbon::now()->subWeek())->count();

        // Dữ liệu biểu đồ tuần
        $chartDates = [];
        $chartThreads = [];
        $chartPosts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('d/m');
            $chartDates[] = $date;
            $chartThreads[] = Thread::whereDate('created_at', Carbon::now()->subDays($i))->count();
            $chartPosts[] = Post::whereDate('created_at', Carbon::now()->subDays($i))->count();
        }

        // Top 5 chủ đề hot
        $topThreads = Thread::withCount('posts')->orderByDesc('posts_count')->take(5)->get();

        // Top 5 người dùng năng động
        $topUsers = User::withCount('posts')->orderByDesc('posts_count')->take(5)->get();

        return view('dashboard', compact(
            'threadsCount', 'postsCount', 'newThreadsThisWeek', 'newPostsThisWeek',
            'chartDates', 'chartThreads', 'chartPosts',
            'topThreads', 'topUsers'
        ));
    }
}
