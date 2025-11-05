<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThreadImage extends Model
{
    protected $fillable = ['thread_id', 'path', 'alt'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
