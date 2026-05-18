@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 md:pt-36 pb-12">
    <div class="mb-8">
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-primary-600 font-medium flex items-center gap-1 mb-2 hover:underline">
            ← Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Manage Routes</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Route Form -->
        <div class="glass p-6 rounded-2xl h-fit">
            <h3 class="font-bold text-lg mb-4">Add New Route</h3>
            <form action="{{ route('admin.routes.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Route Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 rounded-xl border border-slate-200" placeholder="Campus Express">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Origin</label>
                    <input type="text" name="origin" required class="w-full px-4 py-2 rounded-xl border border-slate-200" placeholder="West Gateway">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Destination</label>
                    <input type="text" name="destination" required class="w-full px-4 py-2 rounded-xl border border-slate-200" placeholder="Library Hub">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Origin Lat</label>
                        <input type="number" step="any" name="origin_lat" class="w-full px-3 py-1 text-sm rounded-lg border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Origin Lng</label>
                        <input type="number" step="any" name="origin_lng" class="w-full px-3 py-1 text-sm rounded-lg border border-slate-200">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Dest Lat</label>
                        <input type="number" step="any" name="dest_lat" class="w-full px-3 py-1 text-sm rounded-lg border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Dest Lng</label>
                        <input type="number" step="any" name="dest_lng" class="w-full px-3 py-1 text-sm rounded-lg border border-slate-200">
                    </div>
                </div>
                <button type="submit" class="w-full btn-red py-2">Add Route</button>
            </form>
        </div>

        <!-- Route List -->
        <div class="lg:col-span-2 glass rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[600px] sm:min-w-0">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-sm font-bold text-slate-600">Route Name</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-600">Origin → Dest</th>
                        <th class="px-6 py-4 text-sm font-bold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($routes as $route)
                    <tr>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $route->name }}</td>
                        <td class="px-6 py-4 text-slate-600 text-sm">
                            <span class="font-semibold">{{ $route->origin }}</span> → 
                            <span class="font-semibold">{{ $route->destination }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-primary-600 hover:text-primary-700 text-sm font-bold">View Map</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-slate-400">No routes defined yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
@endsection
