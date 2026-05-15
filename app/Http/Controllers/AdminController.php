<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_buses' => Bus::count(),
            'total_routes' => Route::count(),
            'active_schedules' => Schedule::where('status', 'active')->count(),
            'total_reservations' => \App\Models\Reservation::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function buses()
    {
        $buses = Bus::all();
        return view('admin.buses', compact('buses'));
    }

    public function storeBus(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|unique:buses',
            'capacity' => 'required|integer|min:1',
        ]);

        Bus::create($request->all());
        return back()->with('success', 'Bus added successfully.');
    }

    public function routes()
    {
        $routes = Route::all();
        return view('admin.routes', compact('routes'));
    }

    public function storeRoute(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'origin' => 'required',
            'destination' => 'required',
        ]);

        Route::create($request->all());
        return back()->with('success', 'Route added successfully.');
    }

    public function schedules()
    {
        $schedules = Schedule::with(['bus', 'route', 'driver'])->get();
        $buses = Bus::all();
        $routes = Route::all();
        $drivers = \App\Models\User::where('role', 'driver')->get();
        return view('admin.schedules', compact('schedules', 'buses', 'routes', 'drivers'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'driver_id' => 'nullable|exists:users,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
        ]);

        Schedule::create($request->all());
        return back()->with('success', 'Schedule created successfully.');
    }
}
