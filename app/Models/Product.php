<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['code', 'name', 'technique', 'cultural_origin', 'dimensions', 'color', 'shape', 'history', 'status', 'physical_location', 'creator', 'creation_date', 'price', 'is_active'];
    
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
    public function materialProducts()
    {
        return $this->belongsToMany(ProductMaterial::class, 'material_product')->withPivot('is_main')->withTimestamps();
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id', 'product_id');
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'id', 'product_id');
    }
    public function productPriceHistories()
    {
        return $this->hasMany(ProductPriceHistory::class, 'id', 'product_id');
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
}