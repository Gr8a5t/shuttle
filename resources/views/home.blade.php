@extends('layouts.app')

@section('content')
<div class="relative min-h-screen flex flex-col justify-center overflow-hidden pt-32 pb-20" style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <!-- Changed gap and items alignment to allow the image to scale better -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 lg:gap-4">
            
            <!-- Left Content: increased width to 60% so text doesn't wrap -->
            <div id="hero-left" class="w-full md:w-[60%] lg:w-[65%] relative z-20">
                <!-- Loosened the line height slightly so it isn't clustered -->
                <h1 class="text-[3.5rem] sm:text-[4rem] md:text-[4.5rem] lg:text-[5rem] xl:text-[6rem] font-extrabold text-[#1e2330] mb-6 tracking-tight relative z-10 leading-[1.15]">
                    Campus 
                    <span class="relative inline-block whitespace-nowrap">
                        Transit
                    </span> <br/>
                    But In A <br/>
                    <span class="relative inline-block whitespace-nowrap">
                        Good Way!
                        <!-- The orange underline -->
                        <svg id="hero-underline" class="absolute w-[110%] h-4 sm:h-5 -bottom-1 sm:-bottom-2 left-[-5%] text-[#fe855e] z-[-1]" viewBox="0 0 200 15" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                            <path d="M2 10.5C54 0.8 108 0.2 161 7.1C173.8 8.6 186.1 11.4 198.5 12.4" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
                        </svg>
                    </span>
                </h1>
                
                <p class="text-lg sm:text-xl md:text-2xl text-slate-500 mb-8 max-w-lg leading-relaxed font-medium mt-6">
                    Now you can enjoy commuting anywhere and anytime and of course it's safe with us.
                </p>
                
                <div class="flex items-center gap-6 mt-8 mb-18 pb-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-[#252a36] hover:bg-black text-white font-semibold px-10 py-4 rounded-full text-lg transition-all shadow-xl hover:shadow-2xl">
                        Get Started
                    </a>
                </div>
            </div>

            <!-- Right Content (Car/Shuttle Image): reduced width container, pushed image to be huge -->
            <div id="hero-right" class="w-full md:w-[40%] lg:w-[35%] flex justify-center lg:justify-end relative z-10 mt-16 md:mt-0">
                <img src="{{ asset('images/car.png') }}" alt="Shuttle Car" class="w-[200%] max-w-none md:w-[250%] lg:w-[350%] object-contain drop-shadow-2xl transition-transform duration-700 ease-out hover:scale-110 -ml-20 md:-ml-48 lg:-ml-80 scale-110 lg:scale-125 transform-gpu" />
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        // Text animates in from the left
        gsap.from("#hero-left", {
            x: -100,
            opacity: 0,
            duration: 1.2,
            ease: "power3.out",
            delay: 0.1
        });
        
        // Shuttle animates in from the right
        gsap.from("#hero-right", {
            x: 100,
            opacity: 0,
            duration: 1.2,
            ease: "power3.out",
            delay: 0.4
        });
        
        // Orange underline drawing animation
        gsap.from("#hero-underline", {
            scaleX: 0,
            transformOrigin: "left center",
            duration: 0.8,
            ease: "power2.out",
            delay: 1.0 // Wait for text to settle
        });
    });
</script>
@endpush