<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FlightInstance;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $confirmedBookings = Booking::where('booking_status', 'confirmed')->count();
        $cancelledBookings = Booking::where('booking_status', 'cancelled')->count();
        $totalRevenue = Booking::where('booking_status', 'confirmed')
            ->where('payment_status', 'paid')
            ->sum('total_price_usd');
        $flightsToday = FlightInstance::whereDate('flight_date', today())->count();
        
        // Convert to IDR for display
        $exchangeRate = config('app.usd_to_idr', 15000);
        $totalRevenueIdr = $totalRevenue * $exchangeRate;

        return view('admin.dashboard', compact(
            'totalBookings',
            'confirmedBookings',
            'cancelledBookings',
            'totalRevenueIdr',
            'flightsToday'
        ));
    }
}
