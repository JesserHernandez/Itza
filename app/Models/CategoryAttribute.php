<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    protected $perPage = 20;
    protected $fillable = ['name', 'label', 'data_type', 'unit', 'category_id'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, 'id', 'category_attribute_id');
    }
}