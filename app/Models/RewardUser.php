<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RewardUser extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['points', 'points_expiration', 'reason', 'user_Id'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_Id', 'id');
    }
}