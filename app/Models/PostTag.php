<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostTag extends Model
{
    use HasFactory;

    protected $perPage = 20;
    protected $fillable = ['post_id', 'tag_id'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}