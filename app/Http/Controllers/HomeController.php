<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Airport;
use App\Models\FlightInstance;
use App\Models\BookingSeat;
use App\Models\Booking;
use App\Models\FlashSale;
use App\Models\PromotionalBanner;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch active banners for carousel
        $banners = PromotionalBanner::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch active coupons
        $coupons = \App\Models\Coupon::where('is_active', true)
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'asc')
            ->get();

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

        // If client is logged in, load client data
        if (session('client_id')) {
            $clientId = session('client_id');
            $clientName = session('client_name');
            $clientEmail = session('client_email');
            $client = Client::find($clientId);

            return view('home', compact('client', 'airports', 'clientName', 'clientEmail', 'flights', 'heroFlashSales', 'secondaryFlashSales', 'serverTime', 'featuredDestinations', 'banners', 'coupons'));
        }

        return view('home', compact('airports', 'flights', 'heroFlashSales', 'secondaryFlashSales', 'serverTime', 'featuredDestinations', 'banners', 'coupons'));
    }

    public function dashboard()
    {
        return $this->index();
    }

    public function deals()
    {
        $banners = PromotionalBanner::where('is_active', true)->orderBy('order')->get();
        $coupons = \App\Models\Coupon::where('is_active', true)
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'asc')
            ->get();

        return view('pages.deals', compact('banners', 'coupons'));
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