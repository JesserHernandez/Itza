<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['name', 'description'];

    public function categoryProducts()
    {
        return $this->hasMany(CategoryProduct::class, 'id', 'category_id');
    }
    public function categoryPosts()
    {
        return $this->hasMany(CategoryPost::class, 'id', 'category_id');
    }
}