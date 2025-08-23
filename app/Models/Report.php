<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['title', 'type', 'content', 'status', 'report_date', 'revision_date', 'is_Reviewed', 'reporting_user_id', 'reviewer_user_id', 'reported_type', 'reported_id'];
    
    public function reportingUser()
    {
        return $this->belongsTo(User::class, 'reporting_user_id', 'id');
    }
    public function reviewerUser()
    {
        return $this->belongsTo(User::class, 'reviewer_user_id', 'id');
    }
    public function reported()
    {
        return $this->morphTo();
    }
}