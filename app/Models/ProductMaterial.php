<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductMaterial extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['name', 'description'];
    
    public function materialProducts()
    {
        return $this->hasMany(MaterialProduct::class, 'id', 'product_material_id');
    }
}