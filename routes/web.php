<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;


// Public routes (accessible without authentication)
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/registersave', [UserController::class, 'saveRegister'])->name('register.save');

Route::get('/', [UserController::class, 'login'])->name('login');
Route::post('/authenticate-login', [UserController::class, 'authenticateLogin'])->name('check.login');

// Protected routes (only accessible when logged in)
Route::middleware(['authcheck'])->group(function () {
    // Product routes
    Route::get('/index', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/select-seats', [BookingController::class, 'selectSeats'])->name('booking.select_seats');
    Route::post('/confirm-booking', [BookingController::class, 'confirmBooking'])->name('booking.confirm');
    Route::get('/booking-success', [BookingController::class, 'success'])->name('booking.success');
    Route::post('/getLocation', [BookingController::class, 'getLocation'])->name('getLocation');

    Route::get('/profile', [UserController::class, 'userProfile'])->name('profile');

    // Logout route
    Route::get('/logout', [UserController::class, 'logout'])->name('exit');

});



// Route::get('/', [ProductController::class, 'index'])->name('product.index');
