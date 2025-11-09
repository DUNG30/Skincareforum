<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Trang danh sách category
    public function index()
    {
        // Lấy tất cả category từ DB
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Trang chi tiết 1 category
    public function show(Category $category)
    {
        // Hiển thị các threads theo category
        $threads = $category->threads()->latest()->get();
        return view('categories.show', compact('category','threads'));
    }
}
