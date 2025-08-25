<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPriceHistory extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['old_price', 'product_id', 'changing_user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'changing_user_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}