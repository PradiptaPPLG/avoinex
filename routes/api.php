<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/airports', [\App\Http\Controllers\Api\AirportController::class, 'search']);

Route::post('/send-booking-email', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'booking_code' => 'required',
    ]);

    $data = $request->all();
    
    try {
        \Illuminate\Support\Facades\Mail::to($data['email'])->send(new \App\Mail\AppBookingConfirmedMail($data));
        return response()->json(['status' => 'success', 'message' => 'Email sent successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});

Route::post('/chat', [\App\Http\Controllers\ChatController::class, 'send']);
