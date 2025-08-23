<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerificationUser extends Model
{
    use HasFactory;
    
    protected $perPage = 20;
    protected $fillable = ['status', 'submitted_documents', 'comments', 'vendor_id', 'reviewed_by'];

    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }
}