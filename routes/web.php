<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DriverController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/show-error', function () {
    $path = storage_path('logs/error.txt');
    if (file_exists($path)) {
        return response(file_get_contents($path), 200, ['Content-Type' => 'text/plain']);
    }
    return 'No error file found.';
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Student Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ReservationController::class, 'index'])->name('dashboard');
    Route::post('/reserve', [ReservationController::class, 'reserve'])->name('reserve');
    Route::post('/request-trip', [ReservationController::class, 'requestTrip'])->name('request-trip');
    Route::get('/my-reservations', [ReservationController::class, 'myReservations'])->name('my-reservations');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Bus Management
    Route::get('/buses', [AdminController::class, 'buses'])->name('admin.buses');
    Route::post('/buses', [AdminController::class, 'storeBus'])->name('admin.buses.store');
    
    // Route Management
    Route::get('/routes', [AdminController::class, 'routes'])->name('admin.routes');
    Route::post('/routes', [AdminController::class, 'storeRoute'])->name('admin.routes.store');
    
    // Schedule Management
    Route::get('/schedules', [AdminController::class, 'schedules'])->name('admin.schedules');
    Route::post('/schedules', [AdminController::class, 'storeSchedule'])->name('admin.schedules.store');
});

// Driver Routes
Route::middleware(['auth', 'driver'])->prefix('driver')->group(function () {
    Route::get('/', [DriverController::class, 'index'])->name('driver.dashboard');
    Route::post('/claim/{schedule}', [DriverController::class, 'claim'])->name('driver.claim');
    Route::get('/schedule/{schedule}/passengers', [DriverController::class, 'passengers'])->name('driver.passengers');
    Route::post('/schedule/{schedule}/status', [DriverController::class, 'updateStatus'])->name('driver.status');
});
