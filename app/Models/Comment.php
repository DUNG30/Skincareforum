<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Cho phép gán hàng loạt
    protected $fillable = [
        'post_id', 
        'user_id', 
        'content'
    ];

    // Comment thuộc về User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Comment thuộc về Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Comment có thể có nhiều Reaction (morph)
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }
}