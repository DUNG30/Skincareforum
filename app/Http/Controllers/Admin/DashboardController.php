<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $categoriesCount = Category::count();
        $postsCount = Post::count();

        return view('admin.dashboard', compact('usersCount', 'categoriesCount', 'postsCount'));
    }
}
