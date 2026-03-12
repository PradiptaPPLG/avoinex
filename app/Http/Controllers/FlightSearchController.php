<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;
use App\Models\Schedule;
use App\Models\FlightInstance;
use App\Models\Booking;
use App\Models\BookingSeat;
use Carbon\Carbon;

class FlightSearchController extends Controller
{
    public function index()
    {
        $airports = Airport::all();

        // Get available flights
        $flights = FlightInstance::with([
            'schedule.originAirport',
            'schedule.destinationAirport',
            'aircraftInstance.aircraft'
        ])
            ->where('flight_date', '>=', now()->toDateString())
            ->where('is_active', true)
            ->orderBy('flight_date')
            ->orderBy('created_at')
            ->take(10) // Changed from paginate to take for home page
            ->get();

        // Calculate available seats
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
        }

        return view('home', compact('airports', 'flights'));
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

    public function search(Request $request)
    {
        $request->validate([
            'from' => 'required|string|min:3',
            'to' => 'required|string|min:3',
            'depart' => 'required|date|after_or_equal:today',
            'return' => 'nullable|date|after_or_equal:depart',
            'adults' => 'required|integer|min:1',
            'children' => 'integer|min:0',
            'infants' => 'integer|min:0'
        ]);

        // Parse search parameters
        $from = $request->input('from');
        $to = $request->input('to');
        $departDate = $request->input('depart');
        $returnDate = $request->input('return');
        $passengers = $request->input('adults', 1) + $request->input('children', 0);

        // Find airports by city or IATA code
        $originAirports = Airport::where('city', 'like', "%$from%")
            ->orWhere('iata_code', 'like', "%$from%")
            ->get();

        $destinationAirports = Airport::where('city', 'like', "%$to%")
            ->orWhere('iata_code', 'like', "%$to%")
            ->get();

        if ($originAirports->isEmpty() || $destinationAirports->isEmpty()) {
            return back()->with('error', 'Airport not found. Please check your search.');
        }

        $originIataCodes = $originAirports->pluck('iata_code')->toArray();
        $destinationIataCodes = $destinationAirports->pluck('iata_code')->toArray();

        // Search for flights
        $flights = FlightInstance::with([
            'schedule.originAirport',
            'schedule.destinationAirport',
            'schedule.airline',
            'aircraftInstance.aircraft'
        ])
            ->join('schedules', 'flight_instances.schedule_id', '=', 'schedules.schedule_id')
            ->whereIn('schedules.origin_iata_code', $originIataCodes)
            ->whereIn('schedules.destination_iata_code', $destinationIataCodes)
            ->where('flight_instances.flight_date', $departDate)
            ->where('flight_instances.is_active', true)
            ->orderBy('schedules.departure_time_gmt')
            ->select('flight_instances.*')
            ->get();

        // Calculate available seats and filter full flights
        $availableFlights = [];
        foreach ($flights as $flight) {
            $totalSeats = $flight->aircraftInstance->aircraft->total_seats ?? 180;

            $bookedSeats = BookingSeat::whereHas('booking', function ($query) use ($flight) {
                $query->where('flight_instance_id', $flight->flight_instance_id)
                    ->whereIn('booking_status', ['confirmed', 'pending']);
            })->count();

            $availableSeats = $totalSeats - $bookedSeats;

            // Only include flights with enough seats
            if ($availableSeats >= $passengers) {
                $flight->available_seats = $availableSeats;
                $flight->price = $flight->schedule->base_price_usd * $passengers;
                $availableFlights[] = $flight;
            }
        }

        return view('search', [
            'flights' => collect($availableFlights),
            'searchParams' => $request->all(),
            'origin' => $originAirports->first(),
            'destination' => $destinationAirports->first()
        ]);
    }

    public function show($id)
    {
        $flight = FlightInstance::with([
            'schedule.originAirport',
            'schedule.destinationAirport',
            'schedule.airline',
            'aircraftInstance.aircraft'
        ])
            ->findOrFail($id);

        // Calculate available seats
        $totalSeats = $flight->aircraftInstance->aircraft->total_seats ?? 180;
        $bookedSeats = BookingSeat::whereHas('booking', function ($query) use ($flight) {
            $query->where('flight_instance_id', $flight->flight_instance_id)
                ->whereIn('booking_status', ['confirmed', 'pending']);
        })->count();

        $flight->available_seats = $totalSeats - $bookedSeats;
        $flight->is_full = $flight->available_seats <= 0;

        return view('flight.detail', compact('flight'));
    }
}