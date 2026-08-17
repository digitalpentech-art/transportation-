@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8">Available Routes</h1>

    @if($routes->isEmpty())
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 text-blue-700">
            <p>No available routes at the moment. Please check back later.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($routes as $route)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-wide">
                        {{ $route->origin }} to {{ $route->destination }}
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $route->origin }} &rarr; {{ $route->destination }}</h3>
                <p class="text-gray-600 flex items-center mb-6">
                    <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                    {{ \Carbon\Carbon::parse($route->departure_time)->format('M d, Y - h:i A') }}
                </p>
                <form action="{{ route('passenger.book') }}" method="POST">
                    @csrf
                    <input type="hidden" name="route_id" value="{{ $route->id }}">
                    @php
                        $isBooked = Auth::user()->bookings()->where('route_id', $route->id)->where('status', '!=', 'Cancelled')->exists();
                    @endphp
                    <button type="submit" 
                        class="w-full py-3 rounded-lg font-semibold transition duration-200 {{ $isBooked ? 'bg-gray-300 text-gray-600 cursor-not-allowed' : 'bg-gray-900 text-white hover:bg-gray-800' }}"
                        {{ $isBooked ? 'disabled' : '' }}>
                        {{ $isBooked ? 'Already Booked' : 'Select Ride' }}
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

