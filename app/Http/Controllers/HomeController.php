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
        // Ambil semua bandara untuk dropdown search
        $airports = Airport::orderBy('city')->get();

        // Ambil available flights from FlightInstance
        // NOTE: Removed strict filtering temporarily for debugging purposes
        $flights = FlightInstance::with([
            'schedule.originAirport',
            'schedule.destinationAirport',
            'aircraftInstance.aircraft'
        ])
            ->where('flight_date', '>=', now()->toDateString())
            ->where('is_active', true)
            ->orderBy('flight_date')
            ->orderBy('created_at')
            ->take(10)
            ->get();

        // Calculate available seats untuk setiap flight
        foreach ($flights as $flight) {
            $totalSeats = $flight->aircraftInstance->aircraft->total_seats ?? 180;

            $bookedSeats = BookingSeat::whereHas('booking', function ($query) use ($flight) {
                $query->where('flight_instance_id', $flight->flight_instance_id)
                    ->whereIn('booking_status', ['confirmed', 'pending']);
            })->count();

            $flight->available_seats = $totalSeats - $bookedSeats;
            $flight->is_full = $flight->available_seats <= 0;

            // Extract airline info
            $flightNumber = $flight->schedule->flight_number ?? 'GA-201';
            $airlineCode = explode('-', $flightNumber)[0] ?? 'GA';
            $flight->airline_code = $airlineCode;
            // simple mapping for airline name used on home page cards
            $flight->airline_name = $this->getAirlineName($airlineCode);
        }

        // If client is logged in, load client data
        if (session('client_id')) {
            $clientId = session('client_id');
            $clientName = session('client_name');
            $clientEmail = session('client_email');
            $client = Client::find($clientId);

            return view('home', compact('client', 'airports', 'clientName', 'clientEmail', 'flights'));
        }

        return view('home', compact('airports', 'flights'));
    }

    public function dashboard()
    {
        return $this->index();
    }

    private function getAirlineName($code)
    {
        $airlines = [
            'GA' => 'Garuda Indonesia',
            'QZ' => 'AirAsia',
            'SQ' => 'Singapore Airlines',
            'MH' => 'Malaysia Airlines',
            'CX' => 'Cathay Pacific',
            'JL' => 'Japan Airlines',
            'KE' => 'Korean Air'
        ];
        return $airlines[$code] ?? 'Airlines';
    }
}