@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row gap-6">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-white shadow-md rounded p-4 h-fit">
        <h2 class="text-xl font-bold mb-6 border-b pb-2">Admin Menu</h2>
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded bg-blue-50 text-blue-700 font-semibold">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Manage Users</a>
            <a href="{{ route('admin.vehicles.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Manage Vehicles</a>
            <a href="{{ route('admin.routes.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Manage Routes</a>
            <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Monitor Bookings</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1">
        <div class="bg-white p-6 rounded shadow-md">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">Overview</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                <div class="bg-blue-500 text-white p-4 rounded shadow">
                    <h3 class="font-bold opacity-80 uppercase text-xs">Total Users</h3>
                    <p class="text-3xl font-bold">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-green-500 text-white p-4 rounded shadow">
                    <h3 class="font-bold opacity-80 uppercase text-xs">Total Vehicles</h3>
                    <p class="text-3xl font-bold">{{ $stats['vehicles'] }}</p>
                </div>
                <div class="bg-purple-500 text-white p-4 rounded shadow">
                    <h3 class="font-bold opacity-80 uppercase text-xs">Total Routes</h3>
                    <p class="text-3xl font-bold">{{ $stats['routes'] }}</p>
                </div>
                <div class="bg-orange-500 text-white p-4 rounded shadow">
                    <h3 class="font-bold opacity-80 uppercase text-xs">Total Bookings</h3>
                    <p class="text-3xl font-bold">{{ $stats['bookings'] }}</p>
                </div>
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">System Activity</h2>
                <p class="text-gray-600">Use the sidebar to manage different modules of the Smart Transport System.</p>
            </div>
        </div>
    </div>
</div>
@endsection
