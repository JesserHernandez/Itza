<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['title', 'content', 'summary', 'post_date', 'post_status', 'author_Id', 'team_id'];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_Id', 'id');
    }
    public function reports()
    {
        return $this->morphMany(Report::class, 'reported');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withPivot('is_main')->withTimestamps();
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')->withPivot('is_main')->withTimestamps();
    }
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
}