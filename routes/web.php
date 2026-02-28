<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightSearchController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Landing Page - Before Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [FlightSearchController::class, 'index'])->name('landing');
Route::get('/search', [FlightSearchController::class, 'search'])->name('flights.search');
Route::get('/flights', [FlightSearchController::class, 'index'])->name('flights.public');
Route::get('/flight/{id}', [FlightSearchController::class, 'show'])->name('flight.detail');

Route::get('/deals', fn () => view('pages.deals'))->name('deals');
Route::get('/support', fn () => view('pages.support'))->name('support');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/signup', [RegisterController::class, 'register'])->name('signup.submit');
Route::post('/register', [RegisterController::class, 'register'])->name('register'); // <-- Tambah ini

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| GOOGLE SSO
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| DASHBOARD / HOME (AFTER LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| BOOKING & PAYMENT
|--------------------------------------------------------------------------
*/
// Flight seat selection
Route::get('/flight/{flightInstanceId}/seats', [FlightController::class, 'seats'])->name('flight.seats');
Route::post('/flight/{id}/book', [FlightController::class, 'storeBooking'])->name('flight.book');

// Booking form and process
Route::get('/booking/form', [BookingController::class, 'create'])->name('booking.form');
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{id}/confirmation', [BookingController::class, 'confirmation'])->name('booking.confirmation');

// Payment
Route::get('/payment/{booking}', [PaymentController::class, 'create'])->name('payment.page');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');

/*
|--------------------------------------------------------------------------
| TESTING
|--------------------------------------------------------------------------
*/
Route::get('/test-login', function () {
    session([
        'client_id' => 1,
        'client_name' => 'Test User',
        'client_email' => 'test@example.com',
        'client_logged_in' => true,
    ]);

    return redirect()->route('home'); // redirect ke home setelah login
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(fn () => view('errors.404'));



