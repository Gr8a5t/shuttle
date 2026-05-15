@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <a href="{{ route('driver.dashboard') }}" class="text-sm text-primary-600 font-bold flex items-center gap-1 mb-4 hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Dashboard
        </a>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 leading-tight">Passenger Manifest</h1>
                <p class="text-slate-500 mt-1 font-medium">{{ $schedule->route->name }} • {{ $schedule->departure_time->format('M d, H:i') }}</p>
            </div>
            <div class="glass px-6 py-3 rounded-2xl border-emerald-100 flex items-center gap-3">
               <span class="text-2xl font-black text-emerald-600">{{ $reservations->count() }}</span>
               <span class="text-xs uppercase font-bold text-slate-400 tracking-widest leading-none">Students<br>Booked</span>
            </div>
        </div>
    </div>

    <div class="glass rounded-[2rem] overflow-hidden border-slate-100 shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Student Info</th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Booked At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reservations as $reservation)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">{{ $reservation->user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $reservation->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase rounded-lg">
                                {{ $reservation->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="text-xs font-bold text-slate-500">{{ $reservation->created_at->format('M d') }}</div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $reservation->created_at->diffForHumans() }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-bold">No passengers have booked yet.</p>
                                <p class="text-xs text-slate-300 mt-1">Check back closer to departure time.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-8 p-6 rounded-3xl bg-slate-900 text-white flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/10 rounded-2xl">
                <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="font-bold text-sm">Verify student IDs before boarding</p>
                <p class="text-[10px] text-white/50 uppercase tracking-widest letter">Standard Safety Protocol</p>
            </div>
        </div>
    </div>
</div>
@endsection
