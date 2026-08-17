@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center mb-2">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
        <h1 class="text-3xl font-extrabold text-gray-900">System Bookings</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 font-semibold text-gray-600">Passenger</th>
                    <th class="p-4 font-semibold text-gray-600">Route</th>
                    <th class="p-4 font-semibold text-gray-600">Status</th>
                    <th class="p-4 font-semibold text-gray-600">Booked At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($bookings as $booking)
                <tr>
                    <td class="p-4 font-medium text-gray-800">{{ $booking->user->name }}</td>
                    <td class="p-4 text-gray-600">{{ $booking->route->origin }} &rarr; {{ $booking->route->destination }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                            @if($booking->status == 'Pending') bg-yellow-50 text-yellow-700 
                            @elseif($booking->status == 'Confirmed') bg-green-50 text-green-700 
                            @elseif($booking->status == 'Completed') bg-blue-50 text-blue-700 
                            @else bg-red-50 text-red-700 @endif">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td class="p-4 text-sm text-gray-400">{{ $booking->created_at->format('M d, h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-100">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
