<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    protected $perPage = 20;

    protected $fillable = ['photo_path', 'review_type', 'review_id'];

    public function reviewed()
    {
        return $this->morphTo();
    }
}