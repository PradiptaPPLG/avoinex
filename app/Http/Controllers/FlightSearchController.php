<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;
use App\Models\Schedule;
use App\Models\FlightInstance;
use App\Models\Booking;
use App\Models\BookingSeat;
use Carbon\Carbon;
use App\Models\FlashSale;
use App\Models\PromotionalBanner;
use App\Models\Coupon;

class FlightSearchController extends Controller
{
    public function index()
    {
        $this->cleanupExpiredBookings();
        $airports = Airport::all();

        // Get available flights
        $flights = FlightInstance::with([
            'schedule.originAirport',
            'schedule.destinationAirport',
            'schedule.airline',
            'aircraftInstance.aircraft',
            'flashSale'
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

            // Check for active flash sale and attach it
            $activeFlashSale = $flight->flashSale()->active()->first();
            if ($activeFlashSale) {
                $flight->active_flash_sale = $activeFlashSale;
            }
        }
        // Fetch Flash Sales for Hero Section (Only 1 most worthy/biggest discount)
        $heroFlashSales = FlashSale::with([
            'flightInstance.schedule.originAirport',
            'flightInstance.schedule.destinationAirport',
            'flightInstance.schedule.airline'
        ])
            ->active()
            ->orderBy('priority', 'desc')
            ->orderBy('discount_value', 'desc')
            ->latest()
            ->limit(1)
            ->get();

        $heroIds = $heroFlashSales->pluck('id')->toArray();

        // Fetch remaining Flash Sales for Deals Section
        $secondaryFlashSales = FlashSale::with([
            'flightInstance.schedule.originAirport',
            'flightInstance.schedule.destinationAirport',
            'flightInstance.schedule.airline'
        ])
            ->active()
            ->whereNotIn('id', $heroIds)
            ->orderBy('priority', 'desc')
            ->latest()
            ->take(10)
            ->get();

        $serverTime = now()->toIso8601String();

        $featuredDestinations = \App\Models\FeaturedDestination::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Fetch active banners for carousel
        $banners = PromotionalBanner::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch active coupons
        $coupons = Coupon::where('is_active', true)
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'asc')
            ->get();

        return view('home', compact('airports', 'flights', 'heroFlashSales', 'secondaryFlashSales', 'serverTime', 'featuredDestinations', 'banners', 'coupons'));
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

    public function airportAutocomplete(Request $request)
    {
        $q = request()->query('q');

        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        $airports = Airport::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('iata_code', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%")
                    ->orWhere('airport_name', 'like', "%{$q}%");
            })
            ->orderByRaw("
                CASE 
                    WHEN iata_code LIKE ? THEN 1
                    WHEN city LIKE ? THEN 2
                    WHEN airport_name LIKE ? THEN 3
                    ELSE 4
                END
            ", ["{$q}%", "{$q}%", "%{$q}%"])
            ->select('city', 'iata_code', 'airport_name')
            ->limit(10)
            ->get();

        return response()->json($airports);
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
            'infants' => 'integer|min:0',
            'travel_class' => 'nullable|string|in:economy,premium,business'
        ]);

        // Parse search parameters
        $from = $request->input('from');
        $to = $request->input('to');
        $departDate = $request->input('depart');
        $returnDate = $request->input('return');
        $travelClass = $request->input('travel_class', 'economy');
        $passengers = $request->input('adults', 1) + $request->input('children', 0);

        // Map UI class to DB class
        $dbClassMap = [
            'economy' => 'economy',
            'premium' => 'preferred',
            'business' => 'business'
        ];
        $dbClass = $dbClassMap[$travelClass] ?? 'economy';

        // Price multipliers (relative to base_price_usd)
        $multipliers = [
            'economy' => 1.0,
            'premium' => 1.25,
            'business' => 2.0
        ];
        $multiplier = $multipliers[$travelClass] ?? 1.0;

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
        $flightsQuery = FlightInstance::with([
            'schedule.originAirport',
            'schedule.destinationAirport',
            'schedule.airline',
            'aircraftInstance.aircraft',
            'flashSale'
        ])
            ->join('schedules', 'flight_instances.schedule_id', '=', 'schedules.schedule_id')
            ->whereIn('schedules.origin_iata_code', $originIataCodes)
            ->whereIn('schedules.destination_iata_code', $destinationIataCodes)
            ->where('flight_instances.flight_date', $departDate)
            ->where('flight_instances.is_active', true);

        // Filter by travel class availability
        // A flight must have seats of the requested class
        $flightsQuery->whereHas('aircraftInstance.aircraft.seats', function ($query) use ($dbClass) {
            $query->where('seat_class', $dbClass)
                ->where('is_active', true);
        });

        // Filter by promo if the tab is selected
        if ($request->input('tab') === 'promo') {
            $flightsQuery->whereHas('flashSale', function ($query) {
                $query->active();
            });
        }

        $flights = $flightsQuery->orderBy('schedules.departure_time_gmt')
            ->select('flight_instances.*')
            ->get();

        // Calculate available seats and filter full flights
        $availableFlights = [];
        foreach ($flights as $flight) {
            // Get total seats for the requested class
            $totalClassSeats = \App\Models\Seat::where('aircraft_id', $flight->aircraftInstance->aircraft_id)
                ->where('seat_class', $dbClass)
                ->where('is_active', true)
                ->count();

            // Get booked seats for this flight instance AND this class
            $bookedClassSeats = BookingSeat::whereHas('booking', function ($query) use ($flight) {
                $query->where('flight_instance_id', $flight->flight_instance_id)
                    ->whereIn('booking_status', ['confirmed', 'pending']);
            })->whereHas('seat', function ($query) use ($dbClass) {
                $query->where('seat_class', $dbClass);
            })->count();

            $availableClassSeats = $totalClassSeats - $bookedClassSeats;

            // Only include flights with enough seats in the requested class
            if ($availableClassSeats >= $passengers) {
                $flight->available_seats = $availableClassSeats;
                
                // Calculate original and discounted prices
                $basePrice = $flight->schedule->base_price_usd * $multiplier;
                $flight->original_price = $basePrice * $passengers;
                $flight->price = $basePrice * $passengers;

                // Check for active flash sale and apply manually
                $activeFlashSale = $flight->flashSale()->active()->first();
                if ($activeFlashSale) {
                    $discountedBase = $activeFlashSale->getDiscountedPrice($basePrice);
                    $flight->price = $discountedBase * $passengers;
                    $flight->active_flash_sale = $activeFlashSale;
                }

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

    public function show($id, Request $request)
    {
        $flight = FlightInstance::with([
            'schedule.originAirport',
            'schedule.destinationAirport',
            'schedule.airline',
            'aircraftInstance.aircraft'
        ])
            ->findOrFail($id);

        $travelClass = $request->input('travel_class', 'economy');
        
        // Map UI class to DB class
        $dbClassMap = [
            'economy' => 'economy',
            'premium' => 'preferred',
            'business' => 'business'
        ];
        $dbClass = $dbClassMap[$travelClass] ?? 'economy';

        // Price multipliers
        $multipliers = [
            'economy' => 1.0,
            'premium' => 1.25,
            'business' => 2.0
        ];
        $multiplier = $multipliers[$travelClass] ?? 1.0;

        // Calculate available seats for this class
        $totalClassSeats = \App\Models\Seat::where('aircraft_id', $flight->aircraftInstance->aircraft_id)
            ->where('seat_class', $dbClass)
            ->where('is_active', true)
            ->count();

        $bookedClassSeats = BookingSeat::whereHas('booking', function ($query) use ($flight) {
            $query->where('flight_instance_id', $flight->flight_instance_id)
                ->whereIn('booking_status', ['confirmed', 'pending']);
        })->whereHas('seat', function ($query) use ($dbClass) {
            $query->where('seat_class', $dbClass);
        })->count();

        $flight->available_seats = $totalClassSeats - $bookedClassSeats;
        $flight->is_full = $flight->available_seats <= 0;

        // Apply base price with class multiplier
        $basePrice = $flight->schedule->base_price_usd * $multiplier;

        // Apply flash sale price if active
        $activeFlashSale = $flight->flashSale()->active()->first();
        if ($activeFlashSale) {
            $flight->price = $activeFlashSale->getDiscountedPrice($basePrice);
            $flight->active_flash_sale = $activeFlashSale;
        } else {
            $flight->price = $basePrice;
        }

        return view('flight.detail', compact('flight', 'travelClass'));
    }

    /**
     * Cleanup expired pending bookings to release reserved seats.
     */
    private function cleanupExpiredBookings()
    {
        try {
            $expiredBookings = \App\Models\Booking::where('booking_status', 'pending')
                ->where('expires_at', '<', now())
                ->get();

            foreach ($expiredBookings as $booking) {
                \DB::beginTransaction();
                try {
                    $booking->update(['booking_status' => 'cancelled']);
                    $booking->restoreFlashSaleQuota();
                    \DB::commit();
                } catch (\Exception $e) {
                    \DB::rollBack();
                    \Log::error('Failed to cleanup booking ' . $booking->booking_id . ': ' . $e->getMessage());
                }
            }
        } catch (\Exception $ge) {
            \Log::error('General booking cleanup error: ' . $ge->getMessage());
        }
    }
}