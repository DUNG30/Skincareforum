<?php

use app\Http\Controllers\ProfileController;
use app\Http\Controllers\ThreadController;
use app\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReactionController;

Route::post('/threads/reaction', [ReactionController::class, 'toggle'])
    ->middleware('auth')
    ->name('threads.reaction');

Route::resource('categories', CategoryController::class)->middleware('auth');
Route::get('/', function() {
    return redirect()->route('threads.index');
});

// Chỉ cho phép user đã login mới truy cập threads & posts
Route::middleware('auth')->group(function () {
    Route::resource('threads', ThreadController::class);
    Route::resource('posts', PostController::class)->only(['store']);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';