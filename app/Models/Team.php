<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;
    
    protected $fillable = ['name','personal_team','name','address','type','description','history','city','municipality','phoneNumber','ruc','experience','is_active','photo_path',''];
    protected $dispatchesEvents = ['created' => TeamCreated::class, 'updated' => TeamUpdated::class, 'deleted' => TeamDeleted::class];
    
    protected function casts(): array
    {
        return ['personal_team' => 'boolean'];
    }
    public function reports()
    {
        return $this->morphMany(Report::class, 'reported');
    }
    public function liked()
    {
        return $this->morphMany(LikeUser::class, 'liked');
    }
}