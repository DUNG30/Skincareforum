<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $categoriesCount = Category::count();
        $postsCount = Post::count();
        $usersCount = User::count();

        return view('admin.dashboard', compact('categoriesCount', 'postsCount', 'usersCount'));
    }
}
