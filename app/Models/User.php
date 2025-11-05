<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'avatar', 
        'bio', 
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🧱 Quan hệ với Threads (bài viết)
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    // 💬 Quan hệ với Comments (bình luận)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ❤️ Quan hệ với Likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 🔖 Quan hệ với Bookmarks
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // 🚨 Quan hệ với Reports
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // 🔔 Notifications (Laravel mặc định)
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }
}
