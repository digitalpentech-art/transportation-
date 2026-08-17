@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow-md">
    <h1 class="text-3xl font-bold mb-4">Passenger Dashboard</h1>
    <p class="text-gray-700">Welcome, {{ Auth::user()->name }}. Ready to book your next trip?</p>
    
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Quick Links</h2>
        <div class="flex space-x-4">
            <a href="{{ route('passenger.book') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Book a Ride</a>
            <a href="{{ route('passenger.history') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">My Booking History</a>
        </div>
    </div>
</div>
@endsection
