<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'bus_id', 'route_id', 'driver_id', 'departure_time', 'arrival_time', 'status', 'source'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function availableSeats()
    {
        $booked = $this->reservations()->where('status', 'confirmed')->count();
        return max(0, $this->bus->capacity - $booked);
    }

    public function isFull()
    {
        return $this->availableSeats() <= 0;
    }
}
