@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6">Edit Route</h2>
    <form action="{{ route('admin.routes.update', $route) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Origin</label>
            <input type="text" name="origin" value="{{ $route->origin }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Destination</label>
            <input type="text" name="destination" value="{{ $route->destination }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700">Departure Time</label>
            <input type="datetime-local" name="departure_time" value="{{ \Carbon\Carbon::parse($route->departure_time)->format('Y-m-d\TH:i') }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Assign Vehicles (Optional)</label>
            <div class="grid grid-cols-2 gap-4">
                @foreach($vehicles as $vehicle)
                    <div class="flex items-center">
                        <input type="checkbox" name="vehicle_ids[]" value="{{ $vehicle->id }}" id="vehicle_{{ $vehicle->id }}" class="mr-2"
                            {{ $vehicle->route_id == $route->id ? 'checked' : '' }}>
                        <label for="vehicle_{{ $vehicle->id }}" class="text-sm text-gray-600">
                            {{ $vehicle->vehicle_type }} (Driver: {{ $vehicle->driver->name ?? 'None' }})
                        </label>
                    </div>
                @endforeach
            </div>
            @if($vehicles->isEmpty())
                <p class="text-sm text-gray-500 italic">No available vehicles to assign.</p>
            @endif
        </div>
        <div class="flex justify-between">
            <a href="{{ route('admin.routes.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">Update Route</button>
        </div>
    </form>
</div>
@endsection
