<?php

use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChatController;


Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
});

Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::middleware('auth')->group(function(){
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

Route::get('/', [ForumController::class, 'index'])->name('forum.index');

Route::post('/forum/{post}/react', [ReactionController::class, 'react'])
    ->name('post.react')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/post/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/post/store', [ForumController::class, 'store'])->name('forum.store');

    Route::get('/post/{post}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::put('/post/{post}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/post/{post}', [ForumController::class, 'destroy'])->name('forum.destroy');

    Route::post('/post/{post}/comment', [ForumController::class, 'comment'])->name('forum.comment');

    Route::post('/post/{post}/react', [ReactionController::class, 'toggle'])
        ->name('post.react');
});

Route::get('/post/{post}', [ForumController::class, 'show'])->name('forum.show');

Route::get('/forum/search', [ForumController::class, 'search'])->name('forum.search');
Route::get('/hashtags', [ForumController::class, 'hashtagSuggestions'])->name('hashtags.suggestions');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/reactors/{type}/{id}', function ($type, $id) {

    if ($type === 'post') {
        $reactions = \App\Models\Reaction::with('user')
            ->where('post_id', $id)
            ->latest()
            ->get();
    } else {
        return response()->json(['list' => []]);
    }

    $list = $reactions->map(function ($r) {
        return [
            'user_name' => $r->user->name,
            'type' => 'Thích',
            'created_at' => $r->created_at->diffForHumans(),
        ];
    });

    return response()->json(['list' => $list]);
})->name('reactors.list');

require __DIR__.'/auth.php';
