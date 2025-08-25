<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['amount_paid', 'payment_reference', 'payment_status', 'payment_date', 'payment_method_user_id', 'order_id'];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function paymentMethodUser()
    {
        return $this->belongsTo(PaymentMethodUser::class, 'payment_method_user_id', 'id');
    }
}