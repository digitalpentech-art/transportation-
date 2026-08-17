@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow-md">
    <h1 class="text-3xl font-bold mb-4 text-gray-800">Driver Dashboard</h1>
    
    <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded">
        <h2 class="text-xl font-bold text-blue-800 mb-2">My Vehicle Info</h2>
        @if($vehicle)
            <p><strong>Type:</strong> {{ $vehicle->vehicle_type }}</p>
            <p><strong>Assigned Route:</strong> 
                @if($vehicle->route)
                    {{ $vehicle->route->origin }} to {{ $vehicle->route->destination }} ({{ $vehicle->route->departure_time }})
                @else
                    <span class="text-red-500">No route assigned. Contact Admin.</span>
                @endif
            </p>
        @else
            <p class="text-red-500">No vehicle assigned yet.</p>
        @endif
    </div>

    @if($vehicle && $vehicle->route)
        <h2 class="text-2xl font-bold mb-4">Assigned Passenger Bookings</h2>
        @if($bookings->isEmpty())
            <p class="text-gray-500">No bookings for your route yet.</p>
        @else
            <table class="w-full text-left border-collapse mt-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border">Passenger</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td class="p-3 border">{{ $booking->user->name }}</td>
                        <td class="p-3 border">
                            <span class="px-2 py-1 rounded text-xs font-bold 
                                @if($booking->status == 'Pending') bg-yellow-100 text-yellow-800 
                                @elseif($booking->status == 'Confirmed') bg-green-100 text-green-800 
                                @elseif($booking->status == 'Completed') bg-blue-100 text-blue-800 
                                @else bg-red-100 text-red-800 @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="p-3 border">
                            <form action="{{ route('driver.bookings.update-status', $booking) }}" method="POST" class="flex space-x-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-sm border rounded px-2 py-1">
                                    <option value="Confirmed" {{ $booking->status == 'Confirmed' ? 'selected' : '' }}>Confirm</option>
                                    <option value="Completed" {{ $booking->status == 'Completed' ? 'selected' : '' }}>Complete</option>
                                    <option value="Cancelled" {{ $booking->status == 'Cancelled' ? 'selected' : '' }}>Cancel</option>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Update</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</div>
@endsection
