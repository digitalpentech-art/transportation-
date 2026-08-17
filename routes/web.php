<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (Role-based)
Route::middleware('auth')->group(function () {
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('vehicles', \App\Http\Controllers\Admin\VehicleController::class);
        Route::resource('routes', \App\Http\Controllers\Admin\RouteController::class);
        Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    });

    // Driver Routes
    Route::prefix('driver')->name('driver.')->middleware('role:driver')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DriverController::class, 'index'])->name('dashboard');
        Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\DriverController::class, 'updateStatus'])->name('bookings.update-status');
    });

    // Passenger Routes
    Route::prefix('passenger')->name('passenger.')->middleware('role:passenger')->group(function () {
        Route::get('/dashboard', function () {
            return view('passenger.dashboard');
        })->name('dashboard');
        Route::get('/book', [\App\Http\Controllers\BookingController::class, 'index'])->name('book');
        Route::post('/book', [\App\Http\Controllers\BookingController::class, 'store']);
        Route::get('/history', [\App\Http\Controllers\BookingController::class, 'history'])->name('history');
    });
});
