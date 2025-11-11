<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportService extends Model
{
    protected $perPage = 20;
    protected $fillable = ['type', 'name', 'description', 'company_name', 'schedule', 'email', 'price_range', 'phone_number', 'is_active', 'photo_path', 'creative_circuit_id'];

    public function creativeCircuit()
    {
        return $this->belongsTo(\App\Models\CreativeCircuit::class, 'creative_circuit_id', 'id');
    }
}