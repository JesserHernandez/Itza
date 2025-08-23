<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['quantity', 'price_at_time', 'order_id', 'product_id'];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function orderReturnItems()
    {
        return $this->hasMany(OrderReturnItem::class, 'id', 'order_detail_id');
    }
}