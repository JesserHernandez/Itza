<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['code', 'name', 'description', 'status', 'physical_location', 'creator', 'creation_date', 'price', 'is_active', 'team_id'];
    
    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class, 'id', 'product_id');
    }
    public function categoryProducts()
    {
        return $this->belongsToMany(Category::class, 'category_product')->withPivot('is_main')->withTimestamps();
    }
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'id', 'product_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id', 'product_id');
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id','id');
    }
    public function productPriceHistories()
    {
        return $this->hasMany(ProductPriceHistory::class, 'product_id','id', );
    }
    public function productTags()
    {
        return $this->belongsToMany(Tag::class)->withPivot('is_main')->withTimestamps();
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'id', 'product_id');
    }
    public function reviewed()
    {
        return $this->morphMany(Review::class, 'reviewed');
    }
    public function reports()
    {
        return $this->morphMany(Report::class, 'reported');
    }
    public function liked()
    {
        return $this->morphMany(LikeUser::class, 'liked');
    }
    public function productAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
    public function categoryAttributes()
    {
        return $this->belongsToMany(CategoryAttribute::class, 'product_attribute_values')
                    ->withPivot(['value_text', 'value_number', 'value_boolean', 'value_date'])
                    ->withTimestamps();
    }
}