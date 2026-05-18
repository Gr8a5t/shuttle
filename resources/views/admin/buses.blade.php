@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 md:pt-36 pb-12">
    <div class="mb-8">
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-primary-600 font-medium flex items-center gap-1 mb-2 hover:underline">
            ← Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Manage Buses</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Bus Form -->
        <div class="glass p-6 rounded-2xl h-fit">
            <h3 class="font-bold text-lg mb-4">Add New Bus</h3>
            <form action="{{ route('admin.buses.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">License Plate</label>
                    <input type="text" name="license_plate" required class="w-full px-4 py-2 rounded-xl border border-slate-200" placeholder="SH-123">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Seating Capacity</label>
                    <input type="number" name="capacity" required class="w-full px-4 py-2 rounded-xl border border-slate-200" placeholder="40">
                </div>
                <button type="submit" class="w-full btn-red py-2">Add Bus</button>
            </form>
        </div>

        <!-- Bus List -->
        <div class="lg:col-span-2 glass rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[500px] sm:min-w-0">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-sm font-bold text-slate-600">License Plate</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-600">Capacity</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-600">Added Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($buses as $bus)
                    <tr>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $bus->license_plate }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $bus->capacity }} seats</td>
                        <td class="px-6 py-4 text-slate-500 text-sm">{{ $bus->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-slate-400">No buses added yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
@endsection
