@extends('layouts.app')

@section('content')
<div class="relative min-h-screen flex flex-col justify-center overflow-hidden pt-32 pb-24" style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full flex justify-center">
        <div id="auth-card" class="max-w-xl w-full bg-white/80 backdrop-blur-xl p-8 rounded-[2.5rem] shadow-2xl border border-white/20">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-extrabold text-[#1e2330] tracking-tight">Create Account</h2>
                <p class="text-slate-500 mt-2 font-medium">Join our premium shuttle community</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-bold text-[#1e2330] mb-1.5 px-1">Full Name</label>
                        <input type="text" name="name" id="name" required 
                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-[#fe855e] focus:border-[#fe855e] outline-none transition-all bg-white/50"
                            placeholder="John Doe">
                        @error('name')
                            <p class="text-red-500 text-xs mt-2 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-[#1e2330] mb-1.5 px-1">Email Address</label>
                        <input type="email" name="email" id="email" required 
                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-[#fe855e] focus:border-[#fe855e] outline-none transition-all bg-white/50"
                            placeholder="you@university.edu">
                        @error('email')
                            <p class="text-red-500 text-xs mt-2 px-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-bold text-[#1e2330] mb-1.5 px-1">Password</label>
                        <input type="password" name="password" id="password" required 
                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-[#fe855e] focus:border-[#fe855e] outline-none transition-all bg-white/50"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-xs mt-2 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-[#1e2330] mb-1.5 px-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-[#fe855e] focus:border-[#fe855e] outline-none transition-all bg-white/50"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-1">
                    <label class="block text-sm font-bold text-[#1e2330] mb-2 px-1">Join as</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-center p-3 rounded-2xl border-2 border-slate-100 cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-[#fe855e] has-[:checked]:bg-[#fe855e]/5 group">
                            <input type="radio" name="role" value="student" checked class="sr-only">
                            <span class="text-sm font-bold text-slate-600 group-has-[:checked]:text-[#1e2330]">Student</span>
                        </label>
                        <label class="relative flex items-center justify-center p-3 rounded-2xl border-2 border-slate-100 cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-[#fe855e] has-[:checked]:bg-[#fe855e]/5 group">
                            <input type="radio" name="role" value="driver" class="sr-only">
                            <span class="text-sm font-bold text-slate-600 group-has-[:checked]:text-[#1e2330]">Driver</span>
                        </label>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#1e2330] hover:bg-black text-white font-bold py-3.5 rounded-full text-lg transition-all shadow-xl hover:shadow-2xl">
                        Get Started
                    </button>
                </div>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center text-sm"><span class="px-3 bg-transparent text-slate-400 font-medium">Already registered?</span></div>
            </div>

            <p class="text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full py-3.5 rounded-full border-2 border-[#1e2330] text-[#1e2330] font-bold hover:bg-slate-50 transition-all">
                    Sign In
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
