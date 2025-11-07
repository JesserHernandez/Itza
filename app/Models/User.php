<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, HasProfilePhoto, HasTeams, Notifiable, TwoFactorAuthenticatable;
    protected $guard_name = 'sanctum';
    protected $fillable = ['name', 'surname', 'email', 'password', 'status', 'gender', 'phone_number', 'identification_card', 'experience','is_vendor', 'is_outstanding'];
    protected $hidden = ['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'];
    protected $appends = ['profile_photo_url'];
    
    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }
    public function reports()
    {
        return $this->morphMany(Report::class, 'reported');
    }
    public function liked()
    {
        return $this->morphMany(LikeUser::class, 'liked');
    }
    public function couponUsers()
    {
        return $this->hasMany(CouponUser::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function paymentMethodUsers()
    {
        return $this->hasMany(UserPaymentMethod::class);
    }
}