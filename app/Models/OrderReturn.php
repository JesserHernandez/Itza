<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReturn extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['title', 'content', 'refund_status', 'revision_date', 'application_date', 'is_reviewed', 'order_id', 'user_id'];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function orderReturnItems()
    {
        return $this->hasMany(OrderReturnItem::class, 'id', 'order_return_id');
    }
}