<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResponseReview extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['comment', 'review_date', 'photo_path', 'like_count', 'dis_like_count', 'is_verified_purchase', 'parent_response_id', 'review_id', 'user_id'];
    
    public function responseReview()
    {
        return $this->belongsTo(ResponseReview::class, 'parent_response_id', 'id');
    }
    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function responseReviews()
    {
        return $this->hasMany(ResponseReview::class, 'id', 'parent_response_id');
    }
    public function reports()
    {
        return $this->morphMany(Report::class, 'reported');
    }
    public function likes()
    {
        return $this->morphMany(LikeUser::class, 'likeado');
    }
}