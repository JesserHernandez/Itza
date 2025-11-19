<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['amount_paid', 'payment_reference', 'payment_status', 'payment_date', 'user_payment_method_id', 'order_id'];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function paymentMethodUser()
    {
        return $this->belongsTo(UserPaymentMethod::class, 'user_payment_method_id', 'id');
    }
}