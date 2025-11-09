<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'thread_id',
        'type',
    ];

    // Reaction thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Reaction thuộc về 1 thread
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
