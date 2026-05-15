@extends('layouts.app')

@section('content')
<div class="relative min-h-screen flex flex-col justify-center overflow-hidden pt-32 pb-20" style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full flex justify-center">
        <div id="auth-card" class="max-w-md w-full bg-white/80 backdrop-blur-xl p-8 rounded-[2.5rem] shadow-2xl border border-white/20">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-extrabold text-[#1e2330] tracking-tight">Welcome Back</h2>
                <p class="text-slate-500 mt-2 font-medium">Elevate your campus travel experience</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-bold text-[#1e2330] mb-1.5 px-1">Email Address</label>
                    <input type="email" name="email" id="email" required 
                        class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-[#fe855e] focus:border-[#fe855e] outline-none transition-all bg-white/50"
                        placeholder="you@university.edu">
                    @error('email')
                        <p class="text-red-500 text-xs mt-2 px-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pb-1">
                    <div class="flex justify-between mb-1.5 px-1">
                        <label for="password" class="block text-sm font-bold text-[#1e2330]">Password</label>
                    </div>
                    <input type="password" name="password" id="password" required 
                        class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-[#fe855e] focus:border-[#fe855e] outline-none transition-all bg-white/50"
                        placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-[#1e2330] hover:bg-black text-white font-bold py-3.5 rounded-full text-lg transition-all shadow-xl hover:shadow-2xl">
                    Sign In
                </button>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center text-sm"><span class="px-3 bg-transparent text-slate-400 font-medium">New to Shuttle?</span></div>
            </div>

            <p class="text-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full py-3.5 rounded-full border-2 border-[#1e2330] text-[#1e2330] font-bold hover:bg-slate-50 transition-all">
                    Create Account
                </a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.from("#auth-card", {
            y: 40,
            opacity: 0,
            duration: 1,
            ease: "power4.out"
        });
    });
</script>
@endpush
@endsection
