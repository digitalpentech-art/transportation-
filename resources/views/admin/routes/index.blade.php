@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center mb-2">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900">Manage Routes</h1>
        </div>
        <a href="{{ route('admin.routes.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Add Route
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 font-semibold text-gray-600">Origin</th>
                    <th class="p-4 font-semibold text-gray-600">Destination</th>
                    <th class="p-4 font-semibold text-gray-600">Departure</th>
                    <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($routes as $route)
                <tr>
                    <td class="p-4 font-medium text-gray-800">{{ $route->origin }}</td>
                    <td class="p-4 text-gray-600">{{ $route->destination }}</td>
                    <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($route->departure_time)->format('M d, h:i A') }}</td>
                    <td class="p-4 text-right">
                        <a href="{{ route('admin.routes.edit', $route) }}" class="text-blue-600 hover:text-blue-800 font-medium mr-4">Edit</a>
                        <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Delete this route?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-100">
            {{ $routes->links() }}
        </div>
    </div>
</div>
@endsection
