@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="text-sm text-primary-600 font-medium flex items-center gap-1 mb-2 hover:underline">
            ← Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-slate-900">My Reservations</h1>
        <p class="text-slate-500">History of your ride bookings</p>
    </div>

    <div class="glass rounded-2xl overflow-hidden shadow-sm border-slate-200">
        <table class="w-full text-left">
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
                        <div class="text-xs text-slate-400 capitalize">{{ $res->schedule->route->origin }} → {{ $res->schedule->route->destination }}</div>
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
@endsection
