<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['photo_path', 'is_main', 'product_id'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}