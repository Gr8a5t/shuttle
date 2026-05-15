@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-primary-600 font-medium flex items-center gap-1 mb-2 hover:underline">
            ← Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Manage Schedules</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Schedule Form -->
        <div class="glass p-6 rounded-2xl h-fit">
            <h3 class="font-bold text-lg mb-4">Schedule a Ride</h3>
            <form action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Bus</label>
                    <select name="bus_id" required class="w-full px-4 py-2 rounded-xl border border-slate-200">
                        @foreach($buses as $bus)
                            <option value="{{ $bus->id }}">{{ $bus->license_plate }} ({{ $bus->capacity }} seats)</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Route</label>
                    <select name="route_id" required class="w-full px-4 py-2 rounded-xl border border-slate-200">
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}">{{ $route->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Driver (Optional)</label>
                    <select name="driver_id" class="w-full px-4 py-2 rounded-xl border border-slate-200">
                        <option value="">Open Listing (Marketplace)</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Departure Time</label>
                    <input type="datetime-local" name="departure_time" required class="w-full px-4 py-2 rounded-xl border border-slate-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Arrival Time (Est)</label>
                    <input type="datetime-local" name="arrival_time" required class="w-full px-4 py-2 rounded-xl border border-slate-200">
                </div>
                <button type="submit" class="w-full btn-red py-2">Create Schedule</button>
            </form>
        </div>

        <!-- Schedule List -->
        <div class="lg:col-span-2 glass rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-sm font-bold text-slate-600">Bus/Route</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-600">Driver</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-600">Departure</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-600">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($schedules as $schedule)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $schedule->route->name }}</div>
                                <div class="text-xs text-slate-500">{{ $schedule->bus->license_plate }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($schedule->driver)
                                    <div class="text-sm font-medium text-slate-900">{{ $schedule->driver->name }}</div>
                                @else
                                    <span class="text-xs text-amber-600 font-bold uppercase tracking-tight">Needs Driver</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-900">{{ $schedule->departure_time->format('M d, H:i') }}</div>
                                <div class="text-xs text-slate-500">to {{ $schedule->arrival_time->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-bold rounded-full {{ $schedule->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ strtoupper($schedule->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">No schedules created yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
