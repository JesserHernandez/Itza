<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostImage extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['photo_path', 'is_main', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}