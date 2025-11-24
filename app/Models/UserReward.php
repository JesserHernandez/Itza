<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserReward extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['points', 'points_expiration', 'reason', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}