<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['code', 'type_coupon', 'description', 'usage_limit', 'times_claimed', 'expiration_date', 'is_active', 'team_id', 'redeeming_user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'redeeming_user_id', 'id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
    public function couponUsers()
    {
        return $this->hasMany(CouponUser::class, 'id', 'coupon_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'id', 'coupon_Id');
    }
}