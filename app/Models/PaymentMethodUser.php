<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethodUser extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['method_name', 'provider', 'type', 'currency_supported', 'card_numberLast4', 'expiration_month', 'expiration_year', 'is_main', 'is_active', 'priority', 'photo_path', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'id', 'payment_method_user_id');
    }
}