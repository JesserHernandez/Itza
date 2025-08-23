<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['name', 'description'];
    
    public function postTags()
    {
        return $this->hasMany(PostTag::class, 'id', 'tag_id');
    }
    public function productTags()
    {
        return $this->hasMany(ProductTag::class, 'id', 'tag_id');
    }
}