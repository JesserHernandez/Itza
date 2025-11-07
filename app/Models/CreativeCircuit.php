<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreativeCircuit extends Model
{
    protected $perPage = 20;
    protected $fillable = ['name', 'description', 'photo_path', 'creative_city_id'];

    public function creativeCities()
    {
        return $this->belongsTo(CreativeCity::class, 'creative_city_id', 'id');
    }
    public function transportServices()
    {
        return $this->hasMany(TransportService::class, 'id', 'creative_circuit_id');
    }
    public function teams()
    {
        return $this->hasMany(Team::class, 'id', 'creative_circuit_id');
    }
}