@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 md:pt-36 pb-12">
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="text-sm text-primary-600 font-medium flex items-center gap-1 mb-2 hover:underline">
            ← Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-slate-900">My Reservations</h1>
        <p class="text-slate-500">History of your ride bookings</p>
    </div>

    <div class="glass rounded-2xl overflow-hidden shadow-sm border-slate-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[600px] sm:min-w-0">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-sm font-bold text-slate-600 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-600 uppercase tracking-wider">Route</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-600 uppercase tracking-wider">Bus</th>
                    <th class="px-6 py-4 text-sm font-bold text-slate-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($reservations as $res)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $res->schedule->departure_time->format('d M, Y') }}</div>
                        <div class="text-xs text-slate-500">{{ $res->schedule->departure_time->format('H:i') }} onwards</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-slate-900">{{ $res->schedule->route->name }}</div>
                        <div class="text-xs text-slate-400 capitalize mb-1">{{ $res->schedule->route->origin }} → {{ $res->schedule->route->destination }}</div>
                        @if($res->pickup_lat)
                            <span class="inline-flex items-center gap-1 text-[10px] text-[#fe855e] font-black uppercase tracking-wider">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Pickup: {{ $res->pickup_name }} ({{ round($res->pickup_lat, 4) }}, {{ round($res->pickup_lng, 4) }})
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Pickup: Standard Campus Station
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-primary-50 text-primary-700 text-[10px] font-bold rounded uppercase border border-primary-100">
                            {{ $res->schedule->bus->license_plate }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="flex items-center gap-1.5 font-bold {{ $res->status === 'confirmed' ? 'text-emerald-600' : 'text-slate-400' }}">
                            <span class="w-2 h-2 rounded-full {{ $res->status === 'confirmed' ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                            {{ strtoupper($res->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <p class="text-slate-500 mb-4">You haven't made any reservations yet.</p>
                        <a href="{{ route('dashboard') }}" class="btn-red py-2">Book Your First Ride</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
