@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tighter">Driver <span class="text-primary-600">Portal</span></h1>
            <p class="text-slate-500 font-medium mt-1">Real-time demand matching & trip management.</p>
        </div>
        <div class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold border-4 border-white shadow-xl">
            <span class="w-3 h-3 bg-emerald-500 rounded-full animate-ping"></span>
            ACTIVE SESSION
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold flex items-center gap-3 animate-bounce">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Marketplace / Active Demands -->
        <div class="lg:col-span-7">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Demand Marketplace</h2>
                <span class="text-[10px] font-black bg-primary-100 text-primary-600 px-3 py-1 rounded-full uppercase tracking-widest">Live Requests</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($availableSchedules as $schedule)
                    <div class="bg-white p-6 rounded-[2.5rem] border-2 border-slate-50 shadow-sm hover:border-primary-200 transition-all group relative overflow-hidden">
                        <!-- Demand Badge -->
                        @if($schedule->status == 'pending_demand')
                            <div class="absolute -right-12 top-6 rotate-45 bg-amber-400 text-amber-900 px-14 py-1 text-[10px] font-black uppercase tracking-widest shadow-sm">
                                High Demand
                            </div>
                        @endif

                        <div class="mb-6">
                            <h3 class="text-xl font-black text-slate-900 mb-1">{{ $schedule->route->name }}</h3>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Route #{{ $schedule->route_id }}</span>
                                <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                <span class="text-xs font-bold text-primary-600">{{ $schedule->reservations_count ?? $schedule->reservations()->count() }} students waiting</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mb-8 bg-slate-50 p-4 rounded-3xl">
                            <div class="text-center">
                                <span class="block text-[8px] font-black text-slate-400 uppercase">Pickup</span>
                                <span class="text-sm font-black text-slate-700">{{ $schedule->departure_time->format('H:i') }}</span>
                            </div>
                            <div class="flex-1 h-[2px] bg-slate-200 rounded-full"></div>
                            <div class="text-center">
                                <span class="block text-[8px] font-black text-slate-400 uppercase">Dropoff</span>
                                <span class="text-sm font-black text-slate-700">{{ $schedule->arrival_time->format('H:i') }}</span>
                            </div>
                        </div>

                        <form action="{{ route('driver.claim', $schedule) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-primary-600 text-white font-black rounded-2xl transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2">
                                Accept & Start Trip
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold italic">No active demands in your area.</p>
                        <p class="text-xs text-slate-300 mt-1">New requests from students will appear here.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- My Active Schedule -->
        <div class="lg:col-span-5">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Active Duty</h2>
                <span class="text-[10px] font-black bg-slate-900 text-white px-3 py-1 rounded-full uppercase tracking-widest">Assigned</span>
            </div>

            <div class="space-y-4">
                @forelse($mySchedules as $schedule)
                    <div class="glass p-8 rounded-[3rem] border-primary-100 shadow-2xl relative overflow-hidden">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <span class="px-3 py-1 bg-slate-900 text-white text-[10px] font-black rounded-lg uppercase tracking-widest mb-2 inline-block">
                                    {{ str_replace('_', ' ', $schedule->status) }}
                                </span>
                                <h3 class="text-2xl font-black text-slate-900">{{ $schedule->route->name }}</h3>
                                <p class="text-sm font-bold text-slate-400">Bus: {{ $schedule->bus->license_plate }}</p>
                            </div>
                            <div class="bg-emerald-100 p-3 rounded-2xl">
                                <span class="block text-xs font-black text-emerald-800 leading-none">{{ $schedule->reservations()->count() }}</span>
                                <span class="text-[8px] font-black text-emerald-600 uppercase">Pax</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-8">
                            <a href="{{ route('driver.passengers', $schedule) }}" class="flex items-center justify-center gap-2 py-4 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-2xl font-black text-xs transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Passenger List
                            </a>
                            <div class="relative">
                                <form action="{{ route('driver.status', $schedule) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="w-full h-full py-4 px-4 bg-primary-500 text-white rounded-2xl font-black text-xs outline-none cursor-pointer appearance-none">
                                        <option value="active" {{ $schedule->status == 'active' ? 'selected' : '' }}>Set: Ready</option>
                                        <option value="boarding" {{ $schedule->status == 'boarding' ? 'selected' : '' }}>Set: Boarding</option>
                                        <option value="in_transit" {{ $schedule->status == 'in_transit' ? 'selected' : '' }}>Set: In Transit</option>
                                        <option value="completed" {{ $schedule->status == 'completed' ? 'selected' : '' }}>Set: Complete</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-slate-900 rounded-3xl text-white">
                            <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 20.944a11.955 11.955 0 01-8.618-3.04A12.02 12.02 0 013 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-primary-400">Security Check</p>
                                <p class="text-[9px] font-medium text-slate-400">Verify all student QR codes</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold">No active trip assigned.</p>
                        <p class="text-xs text-slate-300">Accept a demand from the marketplace.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
