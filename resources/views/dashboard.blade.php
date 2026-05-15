@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
    <!-- Hero Section: Where to? -->
    <div class="relative overflow-hidden bg-slate-900 rounded-[2rem] md:rounded-[3rem] p-8 md:p-16 mb-10 shadow-2xl">
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-3xl md:text-5xl font-black text-white mb-4 leading-tight">Where are you <span class="text-primary-500">heading?</span></h1>
            <p class="text-slate-400 text-lg mb-8">Select your destination and request a shuttle in seconds.</p>
            
            <form action="{{ route('request-trip') }}" method="POST" class="flex flex-col md:flex-row gap-4">
                @csrf
                <div class="flex-1">
                    <select name="route_id" required class="w-full h-14 px-6 rounded-2xl bg-white/10 border border-white/20 text-white font-bold appearance-none focus:bg-white focus:text-slate-900 focus:outline-none transition-all cursor-pointer">
                        <option value="" disabled selected class="text-slate-400">Select Campus Route</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}" class="text-slate-900">{{ $route->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="h-14 px-10 btn-red text-lg shadow-primary-500/40">Request Ride</button>
            </form>
        </div>
        
        <!-- Decorative background elements -->
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-10 pointer-events-none hidden md:block">
            <svg class="w-full h-full" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#e63946" d="M44.7,-76.4C58.1,-69.2,70.3,-58.5,77.4,-45.4C84.5,-32.3,86.5,-16.1,84.4,-0.4C82.3,15.2,76,30.3,67.7,44.7C59.4,59.1,49.1,72.7,35.6,78.8C22,84.8,5.2,83.2,-10.8,79.4C-26.8,75.6,-42.1,69.5,-54.6,59.6C-67.1,49.7,-76.8,36,-80.7,21C-84.5,6,-82.5,-10.3,-76.8,-25.1C-71.1,-39.9,-61.7,-53.2,-49,-61.1C-36.3,-69,-20.3,-71.5,-3.5,-65.4C13.2,-59.4,31.3,-83.6,44.7,-76.4Z" transform="translate(100 100)" />
            </svg>
        </div>
    </div>

    <!-- Active Service / Map -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 order-2 lg:order-1">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Active Shuttles</h3>
                <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold ring-1 ring-emerald-100">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    LIVE
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($schedules as $schedule)
                    <div class="glass p-6 rounded-[2rem] border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500 group">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-primary-100 rounded-2xl flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ $schedule->route->name }}</h4>
                                    <span class="text-[10px] uppercase font-black text-slate-400 tracking-widest">{{ $schedule->bus->license_plate }}</span>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $schedule->status == 'pending_demand' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ str_replace('_', ' ', $schedule->status) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between mb-6 px-2">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Est. Time</span>
                                <span class="text-lg font-black text-slate-700">{{ $schedule->departure_time->format('H:i') }}</span>
                            </div>
                            <div class="flex-1 flex justify-center px-4">
                                <div class="w-full h-[1px] bg-slate-100 relative">
                                    <div class="absolute -top-1 left-0 w-2 h-2 bg-primary-500 rounded-full"></div>
                                    <div class="absolute -top-1 right-0 w-2 h-2 bg-slate-300 rounded-full"></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="text-right">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Space</span>
                                    <span class="block text-lg font-black {{ $schedule->availableSeats() < 5 ? 'text-red-500' : 'text-slate-700' }}">{{ $schedule->availableSeats() }}</span>
                                </div>
                            </div>
                        </div>

                        @if($schedule->driver)
                            <div class="flex items-center gap-3 mb-6 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-[10px] font-bold">
                                    {{ substr($schedule->driver->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-slate-600">Driver: {{ $schedule->driver->name }}</span>
                            </div>
                        @else
                            <div class="mb-6 p-3 border-2 border-dashed border-slate-100 rounded-2xl text-center">
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Searching for Driver...</span>
                            </div>
                        @endif

                        @if($schedule->isFull())
                            <button disabled class="w-full py-4 bg-slate-100 text-slate-400 font-black rounded-2xl cursor-not-allowed">SHUTTLE FULL</button>
                        @else
                            <form action="{{ route('reserve') }}" method="POST">
                                @csrf
                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-primary-600 text-white font-black rounded-2xl transition-all shadow-lg active:scale-95">JOIN THIS RIDE</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 py-20 text-center bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
                        <div class="mb-4 text-slate-300 flex justify-center">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-bold">No active shuttles at the moment.</p>
                        <p class="text-xs text-slate-300">Request one above to get things moving!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-1 order-1 lg:order-2">
            <div class="sticky top-24">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Service Area</h3>
                <div class="rounded-[2.5rem] overflow-hidden border-8 border-white shadow-2xl">
                    <div id="map" class="h-64 md:h-[400px]"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView([-1.2863, 36.8172], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        const routes = @json($routes);
        routes.forEach(route => {
            if (route.origin_lat) {
                L.marker([route.origin_lat, route.origin_lng]).addTo(map).bindPopup(route.origin);
                L.marker([route.dest_lat, route.dest_lng]).addTo(map).bindPopup(route.destination);
            }
        });
    });
</script>
@endpush
@endsection
