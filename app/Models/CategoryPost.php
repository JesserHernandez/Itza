<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryPost extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['post_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}