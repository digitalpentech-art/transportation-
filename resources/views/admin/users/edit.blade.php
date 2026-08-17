@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6">Edit User</h2>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Full Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Email Address</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Role</label>
            <select name="role" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
                <option value="passenger" {{ $user->role == 'passenger' ? 'selected' : '' }}>Passenger</option>
                <option value="driver" {{ $user->role == 'driver' ? 'selected' : '' }}>Driver</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700">New Password (leave blank to keep unchanged)</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
        </div>
        <div class="flex justify-between">
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">Update User</button>
        </div>
    </form>
</div>
@endsection
