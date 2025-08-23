<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['initial_existence', 'current_balance', 'minimum_balance', 'balancing_status', 'is_active', 'product_id', 'team_id'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
    public function movements()
    {
        return $this->hasMany(Movement::class, 'id', 'inventory_id');
    }
}