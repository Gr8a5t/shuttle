@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Admin Dashboard</h1>
            <p class="text-slate-500">Manage your shuttle fleet and operations</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-4">
            <a href="{{ route('admin.buses') }}" class="btn-red bg-slate-800 hover:bg-slate-900 px-4 py-2 text-sm">Manage Buses</a>
            <a href="{{ route('admin.routes') }}" class="btn-red bg-slate-800 hover:bg-slate-900 px-4 py-2 text-sm">Manage Routes</a>
            <a href="{{ route('admin.schedules') }}" class="btn-red px-4 py-2 text-sm">New Schedule</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="glass p-6 rounded-2xl">
            <p class="text-sm font-medium text-slate-500 mb-1">Total Buses</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_buses'] }}</p>
        </div>
        <div class="glass p-6 rounded-2xl">
            <p class="text-sm font-medium text-slate-500 mb-1">Total Routes</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_routes'] }}</p>
        </div>
        <div class="glass p-6 rounded-2xl border-l-4 border-primary-500">
            <p class="text-sm font-medium text-slate-500 mb-1">Active Schedules</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['active_schedules'] }}</p>
        </div>
        <div class="glass p-6 rounded-2xl">
            <p class="text-sm font-medium text-slate-500 mb-1">Total Reservations</p>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_reservations'] }}</p>
        </div>
    </div>

    <!-- Recent Activity Placeholder -->
    <div class="glass rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-bold text-slate-900">System Overview</h3>
        </div>
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <p class="text-slate-500 mb-6">You're all set! Use the navigation above to manage system components.</p>
        </div>
    </div>
</div>
@endsection
