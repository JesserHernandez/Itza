<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreativeCity extends Model
{
    protected $perPage = 20;
    protected $fillable = ['name', 'description', 'specialty', 'region', 'latitude', 'longitude', 'photo_path', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}