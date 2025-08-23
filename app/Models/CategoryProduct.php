<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryProduct extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['product_id', 'category_id'];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}