<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class, 'id', 'cart_id');
    }
}