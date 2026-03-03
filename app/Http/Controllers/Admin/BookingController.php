<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['client', 'flightInstance.schedule']);

        if ($request->has('status') && $request->status != '') {
            $query->where('booking_status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with([
            'client',
            'flightInstance.schedule.originAirport',
            'flightInstance.schedule.destinationAirport',
            'bookingSeats'
        ])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }
}
