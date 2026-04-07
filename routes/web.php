<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightSearchController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

/* |-------------------------------------------------------------------------- | PUBLIC ROUTES (Landing Page - Before Login) |-------------------------------------------------------------------------- */
Route::get('/', [FlightSearchController::class , 'index'])->name('landing');
Route::get('/search', [FlightSearchController::class , 'search'])->name('flights.search');
Route::get('/flights', [FlightSearchController::class , 'index'])->name('flights.public');
Route::get('/flight/{id}', [FlightSearchController::class , 'show'])->name('flight.detail');
Route::get('/api/airports/autocomplete', [FlightSearchController::class, 'airportAutocomplete'])->name('api.airports.autocomplete');


Route::get('/deals', fn() => view('pages.deals'))->name('deals');
Route::get('/support', fn() => view('pages.support'))->name('support');

/* |-------------------------------------------------------------------------- | AUTH ROUTES |-------------------------------------------------------------------------- */

Route::post('/login', [LoginController::class , 'login'])->name('login.submit');
Route::post('/register', [RegisterController::class , 'register'])->name('register'); // <-- Tambah ini
Route::post('/signup', [RegisterController::class , 'register'])->name('signup.submit');

Route::post('/logout', [LoginController::class , 'logout'])->name('logout');

/* |-------------------------------------------------------------------------- | GOOGLE SSO |-------------------------------------------------------------------------- */
Route::get('/auth/google', [GoogleController::class , 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class , 'callback'])->name('google.callback');

/* |-------------------------------------------------------------------------- | DASHBOARD / HOME (AFTER LOGIN) |-------------------------------------------------------------------------- */
Route::get('/home', [HomeController::class , 'index'])->name('home');
Route::get('/dashboard', [HomeController::class , 'index'])->name('dashboard');

/* |-------------------------------------------------------------------------- | USER PROFILE |-------------------------------------------------------------------------- */
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

/* |-------------------------------------------------------------------------- | FORGOT PASSWORD |-------------------------------------------------------------------------- */
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.forgot');
Route::post('/forgot-password/send', [ForgotPasswordController::class, 'sendResetCode'])->name('password.send-code');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.reset.process');

/* |-------------------------------------------------------------------------- | BOOKING & PAYMENT |-------------------------------------------------------------------------- */
// Flight seat selection
Route::get('/flight/{flightInstanceId}/seats', [FlightController::class , 'seats'])->name('flight.seats');
Route::post('/flight/{id}/book', [FlightController::class , 'storeBooking'])->name('flight.book');

// Booking form and process
Route::get('/my-bookings', [BookingController::class , 'index'])->name('booking.index');
Route::post('/my-bookings/{booking}/cancel', [BookingController::class , 'cancel'])->name('booking.cancel');
Route::post('/my-bookings/{booking}/refund', [BookingController::class , 'requestRefund'])->name('booking.refund.request');
Route::get('/booking/{id}/ticket', [BookingController::class, 'downloadTicket'])->name('booking.ticket');
Route::post('/booking/guest-cancel/{booking}', [BookingController::class , 'cancelGuest'])->name('booking.guest.cancel');
Route::get('/booking/auth', [BookingController::class , 'authGate'])->name('booking.auth');
Route::post('/booking/guest', [BookingController::class , 'guestContinue'])->name('booking.guest');
Route::get('/booking/find', [BookingController::class , 'findForm'])->name('booking.find.form');
Route::post('/booking/find', [BookingController::class , 'findBooking'])->name('booking.find');
Route::get('/booking/form', [BookingController::class , 'create'])->name('booking.form');
Route::post('/booking/store', [BookingController::class , 'store'])->name('booking.store');
Route::get('/booking/{id}/confirmation', [BookingController::class , 'confirmation'])->name('booking.confirmation');
Route::get('/booking/{id}/ticket', [BookingController::class , 'downloadTicket'])->name('booking.ticket');

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
use App\Http\Controllers\Admin\AdminForgotPasswordController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AircraftController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\FlightController as AdminFlightController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\FeaturedDestinationController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\ManufacturerController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\AirlineController;
use App\Http\Controllers\Admin\HelpController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\MealController;

Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class , 'showLogin'])->name('admin.home');
    Route::get('/login', [AuthController::class , 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class , 'login'])->name('admin.login.submit');

    Route::get('/forgot-password', [AdminForgotPasswordController::class, 'showForm'])->name('admin.password.forgot');
    Route::post('/forgot-password/send', [AdminForgotPasswordController::class, 'sendResetCode'])->name('admin.password.send-code');
    Route::get('/reset-password', [AdminForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset.form');
    Route::post('/reset-password', [AdminForgotPasswordController::class, 'reset'])->name('admin.password.reset.process');

    Route::middleware(['admin.auth'])->group(function () {
            Route::get('/dashboard', [AuthController::class , 'dashboard'])->name('admin.dashboard');
            Route::get('/help', [HelpController::class, 'index'])->name('admin.help');
            Route::post('/logout', [AuthController::class , 'logout'])->name('admin.logout');

            // Site Settings
            Route::get('/settings', [SiteSettingController::class, 'index'])->name('admin.settings.index');
            Route::put('/settings', [SiteSettingController::class, 'update'])->name('admin.settings.update');

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
                    Route::get('/refunds', [AdminBookingController::class , 'refunds'])->name('refunds');
                    Route::post('/refunds/{booking}/process', [AdminBookingController::class , 'processRefund'])->name('refund.process');
                    Route::get('/{id}', [AdminBookingController::class , 'show'])->name('show');
                }
                );

                Route::prefix('flash-sales')->name('admin.flash_sales.')->group(function () {
                    Route::get('/', [FlashSaleController::class , 'index'])->name('index');
                    Route::get('/create', [FlashSaleController::class , 'create'])->name('create');
                    Route::post('/', [FlashSaleController::class , 'store'])->name('store');
                    Route::get('/{id}/edit', [FlashSaleController::class , 'edit'])->name('edit');
                    Route::put('/{id}', [FlashSaleController::class , 'update'])->name('update');
                    Route::delete('/{id}', [FlashSaleController::class , 'destroy'])->name('destroy');
                }
                );

                Route::prefix('meals')->name('admin.meals.')->group(function () {
                    Route::get('/', [MealController::class, 'index'])->name('index');
                    Route::get('/create', [MealController::class, 'create'])->name('create');
                    Route::post('/', [MealController::class, 'store'])->name('store');
                    Route::get('/{meal}/edit', [MealController::class, 'edit'])->name('edit');
                    Route::put('/{meal}', [MealController::class, 'update'])->name('update');
                    Route::delete('/{meal}', [MealController::class, 'destroy'])->name('destroy');
                });

                Route::prefix('featured-destinations')->name('admin.featured_destinations.')->group(function () {
                    Route::get('/', [FeaturedDestinationController::class , 'index'])->name('index');
                    Route::get('/create', [FeaturedDestinationController::class , 'create'])->name('create');
                    Route::post('/', [FeaturedDestinationController::class , 'store'])->name('store');
                    Route::get('/{featuredDestination}/edit', [FeaturedDestinationController::class , 'edit'])->name('edit');
                    Route::put('/{featuredDestination}', [FeaturedDestinationController::class , 'update'])->name('update');
                    Route::delete('/{featuredDestination}', [FeaturedDestinationController::class , 'destroy'])->name('destroy');
                }
                );

                // Master Data
                Route::prefix('airports')->name('admin.airports.')->group(function () {
                    Route::get('/', [AirportController::class , 'index'])->name('index');
                    Route::get('/create', [AirportController::class , 'create'])->name('create');
                    Route::post('/', [AirportController::class , 'store'])->name('store');
                    Route::get('/{id}/edit', [AirportController::class , 'edit'])->name('edit');
                    Route::put('/{id}', [AirportController::class , 'update'])->name('update');
                    Route::delete('/{id}', [AirportController::class , 'destroy'])->name('destroy');
                }
                );

                Route::prefix('manufacturers')->name('admin.manufacturers.')->group(function () {
                    Route::get('/', [ManufacturerController::class , 'index'])->name('index');
                    Route::get('/create', [ManufacturerController::class , 'create'])->name('create');
                    Route::post('/', [ManufacturerController::class , 'store'])->name('store');
                    Route::get('/{id}/edit', [ManufacturerController::class , 'edit'])->name('edit');
                    Route::put('/{id}', [ManufacturerController::class , 'update'])->name('update');
                    Route::delete('/{id}', [ManufacturerController::class , 'destroy'])->name('destroy');
                }
                );

                Route::prefix('countries')->name('admin.countries.')->group(function () {
                    Route::get('/', [CountryController::class , 'index'])->name('index');
                    Route::get('/create', [CountryController::class , 'create'])->name('create');
                    Route::post('/', [CountryController::class , 'store'])->name('store');
                    Route::get('/{id}/edit', [CountryController::class , 'edit'])->name('edit');
                    Route::put('/{id}', [CountryController::class , 'update'])->name('update');
                    Route::delete('/{id}', [CountryController::class , 'destroy'])->name('destroy');
                }
                );

                Route::prefix('airlines')->name('admin.airlines.')->group(function () {
                    Route::get('/', [AirlineController::class , 'index'])->name('index');
                    Route::get('/create', [AirlineController::class , 'create'])->name('create');
                    Route::post('/', [AirlineController::class , 'store'])->name('store');
                    Route::get('/{id}/edit', [AirlineController::class , 'edit'])->name('edit');
                    Route::put('/{id}', [AirlineController::class , 'update'])->name('update');
                    Route::delete('/{id}', [AirlineController::class , 'destroy'])->name('destroy');
                }
                );
            }
            );
        });

/* |-------------------------------------------------------------------------- | FALLBACK |-------------------------------------------------------------------------- */
Route::fallback(fn() => view('errors.404'));
