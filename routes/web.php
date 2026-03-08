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

/* |-------------------------------------------------------------------------- | PUBLIC ROUTES (Landing Page - Before Login) |-------------------------------------------------------------------------- */
Route::get('/', [FlightSearchController::class , 'index'])->name('landing');
Route::get('/search', [FlightSearchController::class , 'search'])->name('flights.search');
Route::get('/flights', [FlightSearchController::class , 'index'])->name('flights.public');
Route::get('/flight/{id}', [FlightSearchController::class , 'show'])->name('flight.detail');

Route::get('/deals', fn() => view('pages.deals'))->name('deals');
Route::get('/support', fn() => view('pages.support'))->name('support');

/* |-------------------------------------------------------------------------- | AUTH ROUTES |-------------------------------------------------------------------------- */

Route::post('/login', [LoginController::class , 'login'])->name('login.submit');
Route::post('/signup', [RegisterController::class , 'register'])->name('signup.submit');
Route::post('/register', [RegisterController::class , 'register'])->name('register'); // <-- Tambah ini

Route::post('/logout', [LoginController::class , 'logout'])->name('logout');

/* |-------------------------------------------------------------------------- | GOOGLE SSO |-------------------------------------------------------------------------- */
Route::get('/auth/google', [GoogleController::class , 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class , 'callback'])->name('google.callback');

/* |-------------------------------------------------------------------------- | DASHBOARD / HOME (AFTER LOGIN) |-------------------------------------------------------------------------- */
Route::get('/home', [HomeController::class , 'index'])->name('home');
Route::get('/dashboard', [HomeController::class , 'index'])->name('dashboard');

/* |-------------------------------------------------------------------------- | BOOKING & PAYMENT |-------------------------------------------------------------------------- */
// Flight seat selection
Route::get('/flight/{flightInstanceId}/seats', [FlightController::class , 'seats'])->name('flight.seats');
Route::post('/flight/{id}/book', [FlightController::class , 'storeBooking'])->name('flight.book');

// Booking form and process
Route::get('/my-bookings', [BookingController::class , 'index'])->name('booking.index');
Route::post('/my-bookings/{booking}/cancel', [BookingController::class , 'cancel'])->name('booking.cancel');
Route::get('/booking/form', [BookingController::class , 'create'])->name('booking.form');
Route::post('/booking/store', [BookingController::class , 'store'])->name('booking.store');
Route::get('/booking/{id}/confirmation', [BookingController::class , 'confirmation'])->name('booking.confirmation');

// Payment
Route::get('/payment/{booking}', [PaymentController::class , 'create'])->name('payment.page');
Route::post('/payment/process', [PaymentController::class , 'process'])->name('payment.process');

/* |-------------------------------------------------------------------------- | TESTING |-------------------------------------------------------------------------- */
Route::get('/test-login', function () {
    session([
        'client_id' => 1,
        'client_name' => 'Test User',
        'client_email' => 'test@example.com',
        'client_logged_in' => true,
    ]);

    return redirect()->route('home'); // redirect ke home setelah login
});

/* |-------------------------------------------------------------------------- | ADMIN ROUTES |-------------------------------------------------------------------------- */
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AircraftController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\FlightController as AdminFlightController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class , 'showLogin'])->name('admin.home');
    Route::get('/login', [AuthController::class , 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class , 'login'])->name('admin.login.submit');

    Route::middleware(['admin.auth'])->group(function () {
            Route::get('/dashboard', [AuthController::class , 'dashboard'])->name('admin.dashboard');
            Route::post('/logout', [AuthController::class , 'logout'])->name('admin.logout');

            Route::prefix('aircraft')->name('admin.aircraft.')->group(function () {
                    Route::get('/', [AircraftController::class , 'index'])->name('index');
                    Route::get('/create', [AircraftController::class , 'create'])->name('create');
                    Route::post('/', [AircraftController::class , 'store'])->name('store');
                    Route::get('/{id}/edit', [AircraftController::class , 'edit'])->name('edit');
                    Route::put('/{id}', [AircraftController::class , 'update'])->name('update');
                    Route::delete('/{id}', [AircraftController::class , 'destroy'])->name('destroy');
                    Route::post('/{id}/restore', [AircraftController::class , 'restore'])->name('restore');
                }
                );

                Route::prefix('schedules')->name('admin.schedules.')->group(function () {
                    Route::get('/', [ScheduleController::class , 'index'])->name('index');
                    Route::get('/create', [ScheduleController::class , 'create'])->name('create');
                    Route::post('/', [ScheduleController::class , 'store'])->name('store');
                    Route::get('/{id}/edit', [ScheduleController::class , 'edit'])->name('edit');
                    Route::put('/{id}', [ScheduleController::class , 'update'])->name('update');
                    Route::delete('/{id}', [ScheduleController::class , 'destroy'])->name('destroy');
                }
                );

                Route::prefix('flights')->name('admin.flights.')->group(function () {
                    Route::get('/', [AdminFlightController::class , 'index'])->name('index');
                    Route::get('/create', [AdminFlightController::class , 'create'])->name('create');
                    Route::post('/', [AdminFlightController::class , 'store'])->name('store');
                    Route::get('/{id}/edit', [AdminFlightController::class , 'edit'])->name('edit');
                    Route::put('/{id}', [AdminFlightController::class , 'update'])->name('update');
                    Route::delete('/{id}', [AdminFlightController::class , 'destroy'])->name('destroy');
                }
                );

                Route::prefix('bookings')->name('admin.bookings.')->group(function () {
                    Route::get('/', [AdminBookingController::class , 'index'])->name('index');
                    Route::get('/{id}', [AdminBookingController::class , 'show'])->name('show');
                }
                );
            }
            );        });

/* |-------------------------------------------------------------------------- | FALLBACK |-------------------------------------------------------------------------- */
Route::fallback(fn() => view('errors.404'));
