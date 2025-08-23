<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movement extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['movement', 'type_movement', 'quantity', 'date', 'observation', 'inventory_id', 'user_id'];
    
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}