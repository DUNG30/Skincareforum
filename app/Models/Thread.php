<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'title', 'body', 'hashtags'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function images() {
        return $this->hasMany(ThreadImage::class);
    }

    public function posts() {
        return $this->hasMany(Post::class); // Nếu bạn có bảng posts
    }
}