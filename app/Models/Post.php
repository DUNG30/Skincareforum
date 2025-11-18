<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Các cột có thể gán hàng loạt
    protected $fillable = [
        'user_id', 
        'title', 
        'content', 
        'category', 
        'media'
    ];

    // Cast media thành array tự động
    protected $casts = [
        'media' => 'array',
    ];

    // Quan hệ: Post thuộc về User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ: Post có nhiều Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Quan hệ: Post có nhiều Bookmark
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Quan hệ: Post có nhiều Reaction
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // Booted để tự động cập nhật reaction_count khi tạo hoặc xóa
    protected static function booted()
    {
        static::created(function ($post) { 
            $post->updateReactionsCount(); 
        });

        static::deleted(function ($post) { 
            $post->updateReactionsCount(); 
        });
    }

    // Cập nhật reaction_count
    public function updateReactionsCount()
    {
        $this->reactions_count = $this->reactions()->count();
        $this->saveQuietly();
    }

    // Getter cho media: đảm bảo luôn trả về array
    public function getMediaAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) : ($value ?? []);
    }

    // Nếu bạn dùng images riêng cho thread (nếu có)
    public function images()
    {
        return $this->hasMany(ThreadImage::class, 'thread_id');
    }
}
