<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shuttle - Premium Reservation System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .map-container { height: 400px; border-radius: var(--radius-xl); overflow: hidden; }
    </style>
</head>
<body class="antialiased bg-[#f8fafc] min-h-screen flex flex-col">
    <nav class="absolute top-0 left-0 w-full z-50 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center font-extrabold tracking-tighter text-2xl md:text-3xl text-[#1e2330] transition-transform hover:scale-105 duration-300">
                        SHUTTLE<span class="text-[#fe855e]">.</span>
                    </a>
                </div>
                
                <!-- Center Nav Links -->
                <div class="hidden md:flex items-center gap-10 text-[15px] font-medium text-slate-600">
                    <a href="#" class="text-slate-900 border-b-2 border-slate-900 pb-1">Home</a>
                    <a href="#" class="hover:text-slate-900 transition-colors">About</a>
                    <a href="#" class="hover:text-slate-900 transition-colors flex items-center gap-1">
                        Pricing 
                        <svg class="w-3.5 h-3.5 text-slate-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <a href="#" class="hover:text-slate-900 transition-colors">Contact</a>
                    <a href="#" class="hover:text-slate-900 transition-colors">Blog</a>
                </div>

                <!-- Right Nav / Auth Forms -->
                <div class="flex items-center gap-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Admin Panel</a>
                        @elseif(auth()->user()->isDriver())
                            <a href="{{ route('driver.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Driver Panel</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Student Dashboard</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-slate-600 hover:text-red-500 transition-colors cursor-pointer">Logout</button>
                        </form>
                        <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center">
                            <span class="text-xs font-bold text-slate-700 capitalize">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-[#2f3542] hover:bg-[#1c222b] text-white font-medium px-8 py-2.5 rounded-full text-[15px] transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="border-2 border-[#1e2330] text-[#1e2330] hover:bg-slate-50 font-medium px-8 py-2.5 rounded-full text-[15px] transition-colors">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-10 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 text-center text-slate-400 text-sm font-medium">
            &copy; 2026 SHUTTLE. All rights reserved.
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @stack('scripts')
</body>
</html>
