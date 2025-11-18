<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadImage extends Model
{
    use HasFactory;

    protected $fillable = ['thread_id', 'image_path'];
}
