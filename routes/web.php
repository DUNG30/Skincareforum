<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;

// Admin Auth
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin routes (bắt buộc đăng nhập)
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Categories CRUD
    Route::resource('categories', CategoryController::class);

    // Posts CRUD
    Route::resource('posts', PostController::class);

    // Users (chỉ index)
    Route::get('users', [UserController::class, 'index'])->name('users.index');
});
// test push main