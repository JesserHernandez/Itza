<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponUser extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['coupon_id', 'user_id'];
    
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}