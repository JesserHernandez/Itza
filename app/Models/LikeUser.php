<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LikeUser extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['is_like', 'is_dis_like', 'liked_type', 'liked_id', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function liked()
    {
        return $this->morphTo();
    }
}