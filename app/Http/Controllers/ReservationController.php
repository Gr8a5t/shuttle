<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        // For students, show trips that are active (admin created) OR pending (other students requested)
        $query = Schedule::with(['bus', 'route', 'driver'])
            ->whereIn('status', ['active', 'pending_demand', 'boarding', 'in_transit']);

        if ($request->has('route_id') && $request->route_id) {
            $query->where('route_id', $request->route_id);
        }

        $schedules = $query->orderBy('departure_time', 'asc')->get();
        $routes = \App\Models\Route::all();
        
        return view('dashboard', compact('schedules', 'routes'));
    }

    public function requestTrip(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
        ]);

        // Check if there's already a pending trip for this route
        $schedule = Schedule::where('route_id', $request->route_id)
            ->where('status', 'pending_demand')
            ->first();

        if (!$schedule) {
            // Create a new "Demand" trip
            // Note: In a real system, we might not assign a bus yet, but for this demo, we'll pick the first available bus
            $bus = \App\Models\Bus::first();
            
            $schedule = Schedule::create([
                'route_id' => $request->route_id,
                'bus_id' => $bus->id,
                'departure_time' => now()->addMinutes(15), // Default to 15 mins from now
                'arrival_time' => now()->addMinutes(45),
                'status' => 'pending_demand',
                'source' => 'demand'
            ]);
        }

        // Auto-reserve a seat for this user
        $request->merge(['schedule_id' => $schedule->id]);
        return $this->reserve($request);
    }

    public function reserve(Request $request)
    {
        if (!auth()->user()->isStudent()) {
            return back()->with('error', 'Only students can book shuttle seats.');
        }

        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        if ($schedule->isFull()) {
            return back()->with('error', 'Sorry, this shuttle is fully booked.');
        }

        // Check if user already has a reservation for this schedule
        $exists = Reservation::where('user_id', Auth::id())
            ->where('schedule_id', $schedule->id)
            ->where('status', 'confirmed')
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have a reservation for this trip.');
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'schedule_id' => $schedule->id,
            'status' => 'confirmed',
        ]);

        return back()->with('success', 'Seat reserved successfully! See you on board.');
    }

    public function myReservations()
    {
        $reservations = Reservation::with(['schedule.route', 'schedule.bus'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('my_reservations', compact('reservations'));
    }
}
