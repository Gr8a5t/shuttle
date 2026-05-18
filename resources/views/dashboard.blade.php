@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 md:pt-36 pb-12">
    <!-- Hero Section: Where to? -->
    <div class="relative overflow-hidden bg-slate-900 rounded-[2rem] md:rounded-[3rem] p-8 md:p-16 mb-10 shadow-2xl">
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-3xl md:text-5xl font-black text-white mb-4 leading-tight">Where are you <span class="text-[#fe855e]">heading?</span></h1>
            <p class="text-slate-400 text-lg mb-8">Choose an active shuttle below, drop your pickup pin, and book your seat in seconds.</p>
            
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative group">
                    <select name="route_id" onchange="this.form.submit()" class="w-full h-14 pl-6 pr-12 rounded-2xl bg-white/10 border border-white/20 text-white font-bold appearance-none focus:bg-white focus:text-slate-900 focus:outline-none transition-all cursor-pointer">
                        <option value="" class="text-slate-900">All Campus Routes</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}" {{ request('route_id') == $route->id ? 'selected' : '' }} class="text-slate-900">{{ $route->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-white/50 group-focus-within:text-slate-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @if(request('route_id'))
                    <a href="{{ route('dashboard') }}" class="h-14 px-10 btn-red bg-slate-800 hover:bg-slate-700 text-lg flex items-center justify-center">Reset Filter</a>
                @endif
            </form>
        </div>
        
        <!-- Decorative background elements -->
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-10 pointer-events-none hidden md:block">
            <svg class="w-full h-full" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#e63946" d="M44.7,-76.4C58.1,-69.2,70.3,-58.5,77.4,-45.4C84.5,-32.3,86.5,-16.1,84.4,-0.4C82.3,15.2,76,30.3,67.7,44.7C59.4,59.1,49.1,72.7,35.6,78.8C22,84.8,5.2,83.2,-10.8,79.4C-26.8,75.6,-42.1,69.5,-54.6,59.6C-67.1,49.7,-76.8,36,-80.7,21C-84.5,6,-82.5,-10.3,-76.8,-25.1C-71.1,-39.9,-61.7,-53.2,-49,-61.1C-36.3,-69,-20.3,-71.5,-3.5,-65.4C13.2,-59.4,31.3,-83.6,44.7,-76.4Z" transform="translate(100 100)" />
            </svg>
        </div>
    </div>

    <!-- Active Service Panel Swapper Container -->
    <div class="relative min-h-[550px]">
        
        <!-- Panel 1: Shuttles Grid (Default View) -->
        <div id="shuttles-panel" class="transition-all duration-500 ease-in-out">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Active Shuttles</h3>
                <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold ring-1 ring-emerald-100">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    LIVE
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($schedules as $schedule)
                    <div id="shuttle-card-{{ $schedule->id }}" class="shuttle-card glass p-6 rounded-[2rem] border-2 border-slate-100 hover:border-slate-300 shadow-sm hover:shadow-xl transition-all duration-500 group relative">
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
                            <button type="button" 
                                onclick="selectShuttleForBooking({{ $schedule->id }}, {{ json_encode($schedule->route) }})"
                                class="w-full py-4 bg-slate-900 hover:bg-[#fe855e] hover:text-slate-900 text-white font-black rounded-2xl transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-[#fe855e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Choose Pickup & Book
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
                        <div class="mb-4 text-slate-300 flex justify-center">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-bold">No active shuttles at the moment.</p>
                        @if(request('route_id'))
                            <p class="text-xs text-slate-300 mt-1 mb-6">Need a ride on this route? Request one now!</p>
                            <form action="{{ route('request-trip') }}" method="POST" class="inline-block">
                                @csrf
                                <input type="hidden" name="route_id" value="{{ request('route_id') }}">
                                <button type="submit" class="btn-red py-3 px-8 text-sm">Request Shuttle Service</button>
                            </form>
                        @else
                            <p class="text-xs text-slate-300">Select a specific campus route above to request service.</p>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Panel 2: Interactive Full-Screen Map (Shown when booking) -->
        <div id="map-panel" class="hidden transition-all duration-500 ease-in-out">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <button type="button" onclick="resetPickupSelection()" class="text-sm text-primary-600 font-bold flex items-center gap-1.5 hover:underline mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                        Back to Shuttles List
                    </button>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight">
                        Choose Pickup for <span id="map-route-title" class="text-[#fe855e]">Campus Route</span>
                    </h3>
                </div>
                <div class="p-3 bg-[#fe855e]/10 border border-[#fe855e]/20 rounded-2xl flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#fe855e] rounded-full animate-ping"></span>
                    <span class="text-xs font-black text-slate-700 uppercase tracking-wider">Search or Tap on Map</span>
                </div>
            </div>
            
            <div class="rounded-[2.5rem] overflow-hidden border-8 border-white shadow-2xl relative bg-slate-100">
                <div id="map" class="h-[500px] md:h-[550px] z-10"></div>
                
                <!-- Map Overlay Instructions/Form inside Map Frame -->
                <div id="map-instructions" class="absolute bottom-6 left-6 right-6 md:left-auto md:w-[380px] bg-slate-900/95 backdrop-blur-md p-6 rounded-[2rem] border border-white/10 z-[1000] shadow-2xl transition-all duration-500">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] font-black text-[#fe855e] uppercase tracking-widest flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 bg-[#fe855e] rounded-full animate-pulse"></span>
                            Live Coordinates
                        </span>
                        <button type="button" onclick="resetPickupSelection()" class="text-slate-400 hover:text-white text-xs font-bold transition-colors">Cancel</button>
                    </div>
                    <h4 id="instruction-title" class="font-extrabold text-white text-base mb-1">Set Pickup Point</h4>
                    <p id="instruction-text" class="text-xs text-slate-300 mb-4 font-medium leading-relaxed">Type your building/address below or drop a pin on the map.</p>
                    
                    <!-- Real-Time Autocomplete Search Box -->
                    <div class="relative mb-4">
                        <div class="flex items-center bg-white/10 border border-white/20 rounded-2xl px-4 py-3 group focus-within:border-[#fe855e] focus-within:bg-white focus-within:text-slate-900 transition-all duration-300">
                            <svg class="w-5 h-5 text-slate-400 mr-2 group-focus-within:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" id="address-search" placeholder="Type campus building or address..." class="w-full bg-transparent border-none outline-none text-white text-xs font-bold focus:text-slate-900 placeholder-slate-400 focus:placeholder-slate-500">
                        </div>
                        <!-- Suggestions Dropdown -->
                        <div id="search-suggestions" class="absolute left-0 right-0 mt-2 bg-slate-800 border border-white/10 rounded-2xl shadow-2xl max-h-48 overflow-y-auto z-[2000] hidden divide-y divide-white/5">
                            <!-- Suggested items populated by JS -->
                        </div>
                    </div>

                    <form id="pickup-form" action="{{ route('reserve') }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="schedule_id" id="pickup-schedule-id">
                        <input type="hidden" name="pickup_lat" id="pickup-lat">
                        <input type="hidden" name="pickup_lng" id="pickup-lng">
                        <input type="hidden" name="pickup_name" id="pickup-name" value="Dropped Pin">
                        
                        <div class="p-3 bg-white/5 rounded-2xl mb-4 border border-white/10 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Selected Spot</span>
                            <span id="coordinates-display" class="text-[10px] font-mono text-[#fe855e] font-bold truncate max-w-[180px]"></span>
                        </div>
                        
                        <button type="submit" class="w-full py-4 bg-[#fe855e] hover:bg-[#ff9775] text-slate-900 font-black rounded-2xl transition-all shadow-lg text-xs uppercase tracking-widest">
                            Confirm & Book Shuttle
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>

@push('scripts')
<script>
    let map;
    let markers = [];
    let routeLine;
    let selectedShuttleId = null;
    let pickupMarker = null;
    let searchDebounceTimer;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Map
        map = L.map('map', { zoomControl: false }).setView([-1.2863, 36.8172], 13);
        L.control.zoom({ position: 'topright' }).addTo(map);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        // Load all static routes
        const routes = @json($routes);
        routes.forEach(route => {
            if (route.origin_lat) {
                // Add clean circular indicators for campuses
                L.circleMarker([route.origin_lat, route.origin_lng], {
                    radius: 8,
                    color: '#fe855e',
                    fillColor: '#fe855e',
                    fillOpacity: 1,
                    weight: 2
                }).addTo(map).bindPopup(`<b>Origin:</b> ${route.origin}`);

                L.circleMarker([route.dest_lat, route.dest_lng], {
                    radius: 8,
                    color: '#1e2330',
                    fillColor: '#1e2330',
                    fillOpacity: 1,
                    weight: 2
                }).addTo(map).bindPopup(`<b>Destination:</b> ${route.destination}`);
            }
        });

        // Set map click listener for reverse-geocoded pin dropping
        map.on('click', function(e) {
            if (selectedShuttleId === null) return;

            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            // Fetch address from OpenStreetMap reverse geocoding api
            const reverseUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;
            
            fetch(reverseUrl, {
                headers: {
                    'Accept-Language': 'en'
                }
            })
            .then(res => res.json())
            .then(data => {
                const addressName = data.display_name ? data.display_name.split(',')[0] : 'Dropped Pin';
                setPickupLocation(lat, lng, addressName);
                document.getElementById('address-search').value = data.display_name || '';
            })
            .catch(() => {
                setPickupLocation(lat, lng, 'Dropped Pin');
            });
        });

        // Search Input listener with autocomplete suggestions
        document.getElementById('address-search').addEventListener('input', function(e) {
            const query = e.target.value.trim();
            const suggestionsBox = document.getElementById('search-suggestions');

            if (query.length < 3) {
                suggestionsBox.innerHTML = '';
                suggestionsBox.classList.add('hidden');
                return;
            }

            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                // Query Nominatim search API bounded roughly around the campus coordinates area
                const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`;
                
                fetch(url, {
                    headers: {
                        'Accept-Language': 'en'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    suggestionsBox.innerHTML = '';
                    if (data.length === 0) {
                        suggestionsBox.innerHTML = `<div class="p-3 text-xs text-slate-400">No matching locations found</div>`;
                        suggestionsBox.classList.remove('hidden');
                        return;
                    }

                    data.forEach(item => {
                        const row = document.createElement('div');
                        row.className = 'p-3 text-xs text-slate-200 hover:bg-white/10 cursor-pointer font-bold transition-colors truncate';
                        row.innerText = item.display_name;
                        row.onclick = () => {
                            const lat = parseFloat(item.lat);
                            const lon = parseFloat(item.lon);
                            const displayName = item.display_name.split(',')[0];

                            // Update pin, zoom, and hidden values
                            setPickupLocation(lat, lon, displayName);

                            // Set address text and close suggestions dropdown
                            document.getElementById('address-search').value = item.display_name;
                            suggestionsBox.classList.add('hidden');
                        };
                        suggestionsBox.appendChild(row);
                    });
                    suggestionsBox.classList.remove('hidden');
                })
                .catch(err => {
                    console.error("Geocoding fetch error:", err);
                });
            }, 300);
        });

        // Close suggestions dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#address-search') && !e.target.closest('#search-suggestions')) {
                document.getElementById('search-suggestions').classList.add('hidden');
            }
        });
    });

    function setPickupLocation(lat, lng, name) {
        if (selectedShuttleId === null) return;

        // Remove existing pickup marker
        if (pickupMarker) {
            map.removeLayer(pickupMarker);
        }

        // Custom Leaflet pulsing icon
        const orangeIcon = L.divIcon({
            className: 'custom-pickup-pin',
            html: `<div class="w-8 h-8 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center relative">
                <div class="absolute w-4 h-4 bg-[#fe855e] rounded-full border-2 border-white shadow-xl z-20"></div>
                <div class="absolute w-8 h-8 bg-[#fe855e]/30 rounded-full animate-ping z-10"></div>
            </div>`,
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        // Pin marker and pan zoom in
        pickupMarker = L.marker([lat, lng], { icon: orangeIcon }).addTo(map);
        map.setView([lat, lng], 16, { animate: true });

        // Update form hidden inputs
        document.getElementById('pickup-lat').value = lat;
        document.getElementById('pickup-lng').value = lng;
        document.getElementById('pickup-name').value = name || 'Dropped Pin';
        document.getElementById('coordinates-display').innerText = name || `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
        
        // Show booking submission action
        document.getElementById('pickup-form').classList.remove('hidden');
        document.getElementById('instruction-title').innerText = "Pickup Location Set!";
        document.getElementById('instruction-text').innerText = `Your shuttle driver will pick you up at "${name || 'your dropped pin'}".`;
    }

    function selectShuttleForBooking(scheduleId, route) {
        selectedShuttleId = scheduleId;

        // Reset any existing marker
        if (pickupMarker) {
            map.removeLayer(pickupMarker);
            pickupMarker = null;
        }

        // Clear Search Box
        document.getElementById('address-search').value = '';

        // Prepopulate form schedule ID
        document.getElementById('pickup-schedule-id').value = scheduleId;
        document.getElementById('map-route-title').innerText = route.name;

        // Transition panels smoothly!
        document.getElementById('shuttles-panel').classList.add('hidden');
        const mapPanel = document.getElementById('map-panel');
        mapPanel.classList.remove('hidden');

        // Force Leaflet to re-calculate map frame display size!
        map.invalidateSize();

        // Show Map Instructions Overlay
        document.getElementById('pickup-form').classList.add('hidden');
        document.getElementById('instruction-title').innerText = "Set Pickup Point";
        document.getElementById('instruction-text').innerText = `Type your building/address below or drop a pin on the map along "${route.name}".`;

        // Fit map bounds to show the entire route route nicely
        if (route.origin_lat && route.dest_lat) {
            const bounds = L.latLngBounds(
                [route.origin_lat, route.origin_lng],
                [route.dest_lat, route.dest_lng]
            );
            map.fitBounds(bounds, { padding: [50, 50] });

            // Draw premium dashed connecting line
            if (routeLine) {
                map.removeLayer(routeLine);
            }
            routeLine = L.polyline([
                [route.origin_lat, route.origin_lng],
                [route.dest_lat, route.dest_lng]
            ], {
                color: '#fe855e',
                dashArray: '8, 8',
                weight: 3,
                opacity: 0.8
            }).addTo(map);
        }
    }

    function resetPickupSelection() {
        selectedShuttleId = null;
        if (pickupMarker) {
            map.removeLayer(pickupMarker);
            pickupMarker = null;
        }
        if (routeLine) {
            map.removeLayer(routeLine);
            routeLine = null;
        }

        // Transition panels back!
        document.getElementById('map-panel').classList.add('hidden');
        document.getElementById('shuttles-panel').classList.remove('hidden');
    }
</script>
<style>
    .shuttle-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .custom-pickup-pin {
        background: transparent;
        border: none;
    }
</style>
@endpush
@endsection
