<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'name', 'origin', 'destination', 
        'origin_lat', 'origin_lng', 
        'dest_lat', 'dest_lng'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
