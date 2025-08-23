<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTag extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['product_id', 'tag_id'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}