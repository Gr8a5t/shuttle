<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['license_plate', 'capacity'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
