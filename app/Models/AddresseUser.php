<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddresseUser extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['type', 'address', 'postal_code', 'city', 'municipality', 'is_active', 'is_main', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'id', 'addresses_user_id');
    }
}