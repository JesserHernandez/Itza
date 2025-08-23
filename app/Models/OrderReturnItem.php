<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReturnItem extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['quantity', 'product_status', 'is_returned_physical', 'order_return_id', 'order_detail_id'];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id', 'id');
    }
    public function orderReturn()
    {
        return $this->belongsTo(OrderReturn::class, 'order_return_id', 'id');
    }
}