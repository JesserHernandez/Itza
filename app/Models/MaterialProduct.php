<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialProduct extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['is_main', 'product_id', 'product_material_id'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function productMaterial()
    {
        return $this->belongsTo(ProductMaterial::class, 'product_material_id', 'id');
    }
}