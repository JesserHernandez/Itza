<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['title', 'rating', 'comment', 'review_date', 'photo_path', 'like_count', 'dis_like_count', 'is_verified_purchase', 'reviewed_type', 'reviewed_id', 'user_id'];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function responseReviews()
    {
        return $this->hasMany(ResponseReview::class, 'id', 'review_id');
    }
    public function reviewed()
    {
        return $this->morphTo();
    }
    public function reported()
    {
        return $this->morphMany(Report::class, 'reported');
    }
    public function liked()
    {
        return $this->morphMany(LikeUser::class, 'liked');
    }
}