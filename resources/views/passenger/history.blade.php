@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Your Booking History</h1>
        <a href="{{ route('passenger.book') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>New Booking
        </a>
    </div>

    @if($bookings->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
            <p class="text-gray-500 mb-4">You haven't made any bookings yet.</p>
            <a href="{{ route('passenger.book') }}" class="text-blue-600 font-semibold hover:underline">Book your first ride now &rarr;</a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 font-semibold text-gray-600">Route</th>
                        <th class="p-4 font-semibold text-gray-600">Departure</th>
                        <th class="p-4 font-semibold text-gray-600">Status</th>
                        <th class="p-4 font-semibold text-gray-600">Booked On</th>
                    </tr>
                </thead>
                <tbody id="booking-history" class="divide-y divide-gray-100">
                    @foreach($bookings as $booking)
                    <tr id="booking-{{ $booking->id }}">
                        <td class="p-4 font-medium text-gray-800">{{ $booking->route->origin }} &rarr; {{ $booking->route->destination }}</td>
                        <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($booking->route->departure_time)->format('M d, h:i A') }}</td>
                        <td class="p-4">
                            <span class="status-span px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                @if($booking->status == 'Pending') bg-yellow-50 text-yellow-700 
                                @elseif($booking->status == 'Confirmed') bg-green-50 text-green-700 
                                @elseif($booking->status == 'Completed') bg-blue-50 text-blue-700 
                                @else bg-red-50 text-red-700 @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-400">{{ \Carbon\Carbon::parse($booking->booking_time)->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    setInterval(() => {
        fetch('{{ route('passenger.history') }}')
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const newDoc = parser.parseFromString(html, 'text/html');
                const newBody = newDoc.querySelector('#booking-history').innerHTML;
                document.querySelector('#booking-history').innerHTML = newBody;
            });
    }, 10000);
</script>
@endsection
