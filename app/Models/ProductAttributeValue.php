<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    protected $perPage = 20;
    protected $fillable = ['value_text', 'value_number', 'value_boolean', 'value_date', 'product_id', 'category_attribute_id'];

    public function categoryAttribute()
    {
        return $this->belongsTo(CategoryAttribute::class, 'category_attribute_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function getValueCategoryAttribute()
    {
        return $this->value_text
            ?? $this->value_number
            ?? $this->value_boolean
            ?? $this->value_date;
    }
}