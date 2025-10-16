<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['code', 'sub_total', 'shipping_cost', 'total', 'shipping_number', 'estimated_time', 'warranty', 'order_date', 'order_status', 'user_id', 'addresses_user_id', 'coupon_Id'];
    
    public function addresseUser()
    {
        return $this->belongsTo(AddresseUser::class, 'addresses_user_id', 'id');
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_Id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id', 'order_id');
    }
    public function orderReturns()
    {
        return $this->hasMany(OrderReturn::class, 'id', 'order_id');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'order_id');
    }
}