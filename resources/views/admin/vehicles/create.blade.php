@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6">Add New Vehicle</h2>
    <form action="{{ route('admin.vehicles.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Vehicle Type</label>
            <input type="text" name="vehicle_type" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Capacity</label>
            <input type="number" name="capacity" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Assign Driver</label>
            <select name="driver_id" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700">Assign Route (Optional)</label>
            <select name="route_id" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                <option value="">No Route Assigned</option>
                @foreach($routes as $route)
                    <option value="{{ $route->id }}">
                        {{ $route->origin }} to {{ $route->destination }} ({{ $route->departure_time }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex justify-between">
            <a href="{{ route('admin.vehicles.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">Add Vehicle</button>
        </div>
    </form>
</div>
@endsection
