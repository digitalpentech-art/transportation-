@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gray-900 overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('images/hero-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover opacity-70">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-transparent opacity-50"></div>
    </div>
    
    <div class="relative container mx-auto px-6 py-6 md:py-8 flex flex-col items-start">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-4">
            Smart Transport for a <br><span class="text-blue-400">Smarter Borno</span>
        </h1>
        <p class="text-xl text-gray-300 mb-4 max-w-2xl">
            Experience the future of urban mobility. Reliable, scheduled, and safe transport at your fingertips. Join thousands of passengers commuting smarter every day.
        </p>
        
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
            @auth
                <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition duration-300 text-center">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition duration-300 text-center">
                    Get Started Today
                </a>
                <a href="{{ route('login') }}" class="px-8 py-4 bg-white hover:bg-gray-100 text-blue-900 font-bold rounded-lg shadow-lg transition duration-300 text-center">
                    Sign In
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Stats Bar -->
<div class="bg-blue-800 py-10">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div>
            <p class="text-4xl font-bold text-white mb-2">50+</p>
            <p class="text-blue-200 uppercase tracking-widest text-sm font-semibold">Active Routes</p>
        </div>
        <div>
            <p class="text-4xl font-bold text-white mb-2">1,200+</p>
            <p class="text-blue-200 uppercase tracking-widest text-sm font-semibold">Daily Commuters</p>
        </div>
        <div>
            <p class="text-4xl font-bold text-white mb-2">100%</p>
            <p class="text-blue-200 uppercase tracking-widest text-sm font-semibold">Verified Drivers</p>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Choose Smart Transport?</h2>
            <div class="h-1 w-20 bg-blue-600 mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Feature 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-calendar-check text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Seamless Booking</h3>
                <p class="text-gray-600 leading-relaxed">
                    Book your seat in seconds. Our intuitive interface lets you schedule rides days in advance with instant confirmation.
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-bell text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Real-time Updates</h3>
                <p class="text-gray-600 leading-relaxed">
                    Stay informed with live notifications. Get instant alerts about your booking status and vehicle location.
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                    <i class="fas fa-shield-alt text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Safe & Reliable</h3>
                <p class="text-gray-600 leading-relaxed">
                    All drivers are thoroughly vetted and vehicles inspected. Your safety is our top priority on every single route.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- How It Works -->
<div class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-gray-600">Three simple steps to start your journey</p>
        </div>
        
        <div class="flex flex-col md:flex-row items-center justify-between space-y-12 md:space-y-0 md:space-x-8">
            <div class="flex-1 text-center px-4">
                <div class="relative inline-block mb-6">
                    <div class="w-20 h-20 bg-blue-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto shadow-xl">1</div>
                </div>
                <h4 class="text-xl font-bold mb-2">Create Account</h4>
                <p class="text-gray-600">Register as a passenger in less than a minute.</p>
            </div>
            
            <div class="hidden md:block w-16 h-0.5 bg-gray-200"></div>
            
            <div class="flex-1 text-center px-4">
                <div class="relative inline-block mb-6">
                    <div class="w-20 h-20 bg-blue-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto shadow-xl">2</div>
                </div>
                <h4 class="text-xl font-bold mb-2">Select Route</h4>
                <p class="text-gray-600">Browse available routes and choose your destination.</p>
            </div>
            
            <div class="hidden md:block w-16 h-0.5 bg-gray-200"></div>
            
            <div class="flex-1 text-center px-4">
                <div class="relative inline-block mb-6">
                    <div class="w-20 h-20 bg-blue-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto shadow-xl">3</div>
                </div>
                <h4 class="text-xl font-bold mb-2">Book & Relax</h4>
                <p class="text-gray-600">Secure your seat and wait for your scheduled ride.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="py-20 bg-blue-600">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-5xl font-bold text-white mb-8">Ready to transform your commute?</h2>
        <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
            Join the Smart Transport community today and experience a more reliable way to travel across Borno.
        </p>
        @guest
            <a href="{{ route('register') }}" class="px-10 py-4 bg-white text-blue-600 font-bold rounded-lg shadow-2xl hover:bg-gray-100 transition duration-300 text-xl inline-block">
                Create Free Account
            </a>
        @else
            <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="px-10 py-4 bg-white text-blue-600 font-bold rounded-lg shadow-2xl hover:bg-gray-100 transition duration-300 text-xl inline-block">
                Go to My Dashboard
            </a>
        @endguest
    </div>
</div>
@endsection
