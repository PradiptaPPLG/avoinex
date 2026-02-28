<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Airport;
use App\Models\FlightInstance;
use App\Models\BookingSeat;
use App\Models\Booking;

class HomeController extends Controller
{
    public function index()
    {
        // Cek jika user belum login
        if (!session('client_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Ambil data client dari session
        $clientId = session('client_id');
        $clientName = session('client_name');
        $clientEmail = session('client_email');

        // Ambil data dari database
        $client = Client::find($clientId);

        // Ambil semua bandara untuk dropdown search
        $airports = Airport::orderBy('city')->get();

        // Ambil available flights (sama seperti FlightSearchController)
        $flights = FlightInstance::with([
                'schedule.originAirport',
                'schedule.destinationAirport',
                'aircraftInstance.aircraft',
                'flightStatus'
            ])
            ->where('flight_date', '>=', now()->toDateString())
            ->where('flight_status_id', 1)
            ->orderBy('flight_date')
            ->orderBy('created_at')
            ->take(10)
            ->get();

        // Calculate available seats untuk setiap flight
        foreach ($flights as $flight) {
            $totalSeats = $flight->aircraftInstance->aircraft->total_seats ?? 180;

            $bookedSeats = BookingSeat::whereHas('booking', function($query) use ($flight) {
                $query->where('flight_instance_id', $flight->flight_instance_id)
                      ->whereIn('booking_status', ['confirmed', 'pending']);
            })->count();

            $flight->available_seats = $totalSeats - $bookedSeats;
            $flight->is_full = $flight->available_seats <= 0;

            // Extract airline info
            $flightNumber = $flight->schedule->flight_number ?? 'GA-201';
            $airlineCode = explode('-', $flightNumber)[0] ?? 'GA';
            $flight->airline_code = $airlineCode;
        }

        return view('home', compact('client', 'airports', 'clientName', 'clientEmail', 'flights'));
    }

    public function dashboard()
    {
        return $this->index();
    }
}