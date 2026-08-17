@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center mb-2">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900">Manage Vehicles</h1>
        </div>
        <a href="{{ route('admin.vehicles.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Add Vehicle
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 font-semibold text-gray-600">Vehicle Type</th>
                    <th class="p-4 font-semibold text-gray-600">Assigned Driver</th>
                    <th class="p-4 font-semibold text-gray-600">Assigned Route</th>
                    <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($vehicles as $vehicle)
                <tr>
                    <td class="p-4 font-medium text-gray-800">{{ $vehicle->vehicle_type }}</td>
                    <td class="p-4 text-gray-600">{{ $vehicle->driver->name ?? 'Unassigned' }}</td>
                    <td class="p-4 text-gray-600">
                        @if($vehicle->route)
                            {{ $vehicle->route->origin }} to {{ $vehicle->route->destination }}
                        @else
                            <span class="text-gray-400 italic">None</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="text-blue-600 hover:text-blue-800 font-medium mr-4">Edit</a>
                        <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Delete this vehicle?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-100">
            {{ $vehicles->links() }}
        </div>
    </div>
</div>
@endsection
