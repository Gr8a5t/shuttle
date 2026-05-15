<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index()
    {
        $driverId = Auth::id();

        // Already assigned trips
        $mySchedules = Schedule::with(['bus', 'route'])
            ->where('driver_id', $driverId)
            ->whereIn('status', ['active', 'boarding', 'in_transit'])
            ->orderBy('departure_time', 'asc')
            ->get();

        // Active Demands & marketplace trips
        $availableSchedules = Schedule::with(['bus', 'route'])
            ->whereNull('driver_id')
            ->whereIn('status', ['active', 'pending_demand'])
            ->where('departure_time', '>', now()->subMinutes(60)) // Show recently created demands
            ->orderBy('departure_time', 'asc')
            ->get();

        return view('driver.dashboard', compact('mySchedules', 'availableSchedules'));
    }

    public function claim(Schedule $schedule)
    {
        if ($schedule->driver_id) {
            return back()->with('error', 'This trip has already been claimed.');
        }

        // Check for overlapping shifts (Bonus logic)
        $overlap = Schedule::where('driver_id', Auth::id())
            ->where(function($query) use ($schedule) {
                $query->whereBetween('departure_time', [$schedule->departure_time, $schedule->arrival_time])
                      ->orWhereBetween('arrival_time', [$schedule->departure_time, $schedule->arrival_time]);
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'You have another trip scheduled at this time.');
        }

        $schedule->update([
            'driver_id' => Auth::id(),
        ]);

        return back()->with('success', 'Trip claimed successfully! Prepare for departure.');
    }

    public function passengers(Schedule $schedule)
    {
        if ($schedule->driver_id !== Auth::id()) {
            abort(403);
        }

        $reservations = $schedule->reservations()->with('user')->get();

        return view('driver.passengers', compact('schedule', 'reservations'));
    }

    public function updateStatus(Request $request, Schedule $schedule)
    {
        if ($schedule->driver_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:active,boarding,in_transit,completed,cancelled',
        ]);

        $schedule->update(['status' => $request->status]);

        return back()->with('success', 'Trip status updated to ' . strtoupper($request->status));
    }
}
