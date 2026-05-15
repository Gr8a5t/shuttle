<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@shuttle.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => \App\Models\User::ROLE_ADMIN,
        ]);

        $bus = \App\Models\Bus::create([
            'license_plate' => 'SH-001',
            'capacity' => 40,
        ]);

        $route = \App\Models\Route::create([
            'name' => 'Main Campus - Sports Center',
            'origin' => 'Main Campus Gateway',
            'destination' => 'Sports Center Complex',
            'origin_lat' => -1.2833,
            'origin_lng' => 36.8167,
            'dest_lat' => -1.2921,
            'dest_lng' => 36.8219,
        ]);

        \App\Models\Schedule::create([
            'bus_id' => $bus->id,
            'route_id' => $route->id,
            'departure_time' => now()->addHours(2),
            'arrival_time' => now()->addHours(3),
            'status' => 'active',
        ]);
    }
}
