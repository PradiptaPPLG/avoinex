<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlightInstance;
use App\Models\FlightSeatPrice;
use App\Models\Schedule;
use App\Models\Airport;
use App\Models\AircraftInstance;
use App\Models\Aircraft;
use App\Models\Seat;
use App\Models\Booking;
use App\Models\BookingSeat;

class FlightController extends Controller
{
    public function seats($id, Request $request)
    {
        try {
            // Read passenger counts from query params (passed from search/home)
            $adults = max(1, intval($request->input('adults', 1)));
            $children = max(0, intval($request->input('children', 0)));
            $infants = max(0, intval($request->input('infants', 0)));
            $requiredSeats = $adults + $children; // infants don't need seats

            // Store in session for the booking flow
            session([
                'booking_adults' => $adults,
                'booking_children' => $children,
                'booking_infants' => $infants,
                'booking_required_seats' => $requiredSeats,
            ]);

            // Ambil data penerbangan
            $flight = FlightInstance::with([
                'schedule.originAirport',
                'schedule.destinationAirport',
                'aircraftInstance.aircraft'
            ])->findOrFail($id);

            // Debug: Log flight data
            \Log::info('Flight loaded:', ['flight_id' => $flight->flight_instance_id]);

            // Dapatkan semua seat untuk pesawat ini
            $allSeats = Seat::where('aircraft_id', $flight->aircraftInstance->aircraft_id)
                ->where('is_active', 1)
                ->get()
                ->sortBy(function ($seat) {
                // Custom sort: extract row number and letter for proper sorting
                preg_match('/^(\d+)([A-Z])$/', $seat->seat_number, $matches);
                if (count($matches) === 3) {
                    $row = intval($matches[1]);
                    $letter = $matches[2];
                    return $row * 100 + ord($letter); // e.g., 1A = 165, 10A = 1065
                }
                return 0;
            });

            \Log::info('Total seats found:', ['count' => $allSeats->count()]);

            if ($allSeats->count() === 0) {
                \Log::warning('No seats found in database!');
                return $this->showSeatsWithDummyData($id);
            }

            // Dapatkan seat yang sudah dibooking
            $bookedSeatIds = [];
            $bookings = Booking::where('flight_instance_id', $id)
                ->whereIn('booking_status', ['confirmed', 'pending'])
                ->get();

            foreach ($bookings as $booking) {
                $bookingSeats = BookingSeat::where('booking_id', $booking->booking_id)->get();
                foreach ($bookingSeats as $bookingSeat) {
                    $bookedSeatIds[] = $bookingSeat->seat_id;
                }
            }

            \Log::info('Booked seat IDs:', $bookedSeatIds);

            // Dapatkan harga seat
            $seatPrices = FlightSeatPrice::where('flight_instance_id', $id)
                ->get()
                ->keyBy('seat_id');

            // Format data untuk view
            $availableSeats = [];
            $flashSale = \App\Models\FlashSale::where('flight_id', $id)->active()->first();

            foreach ($allSeats as $seat) {
                $seatId = $seat->seat_id;
                $isBooked = in_array($seatId, $bookedSeatIds);

                // Tentukan harga
                if (isset($seatPrices[$seatId])) {
                    $basePrice = $seatPrices[$seatId]->price_usd;
                    $isAvailable = !$isBooked && $seatPrices[$seatId]->is_available;
                }
                else {
                    $scheduleBasePrice = $flight->schedule->base_price_usd;
                    
                    // Harga default berdasarkan kelas (Multipliers)
                    if ($seat->seat_class == 'business') {
                        $basePrice = $scheduleBasePrice * 2.0;
                    }
                    elseif ($seat->seat_class == 'first') {
                        $basePrice = $scheduleBasePrice * 3.0;
                    }
                    elseif ($seat->seat_class == 'preferred') {
                        $basePrice = $scheduleBasePrice * 1.25;
                    }
                    else {
                        $basePrice = $scheduleBasePrice;
                    }
                    $isAvailable = !$isBooked;

                    // Buat record harga jika belum ada
                    try {
                        FlightSeatPrice::create([
                            'flight_instance_id' => $id,
                            'seat_id' => $seatId,
                            'price_usd' => $basePrice,
                            'currency' => 'USD',
                            'is_available' => $isAvailable
                        ]);
                    }
                    catch (\Exception $e) {
                        \Log::error('Failed to create seat price: ' . $e->getMessage());
                    }
                }

                $finalPrice = $basePrice;
                if ($flashSale) {
                    $finalPrice = $flashSale->getDiscountedPrice($basePrice);
                }

                $availableSeats[$seat->seat_number] = [
                    'seat_id' => $seatId,
                    'seat_number' => $seat->seat_number,
                    'seat_class' => $seat->seat_class,
                    'seat_type' => $seat->seat_type,
                    'is_available' => $isAvailable,
                    'price' => $finalPrice
                ];
            }

            \Log::info('Available seats prepared:', ['count' => count($availableSeats)]);

            // Debug: Cek seat 1A specifically
            if (isset($availableSeats['1A'])) {
                \Log::info('✅ Seat 1A found in availableSeats:', $availableSeats['1A']);
            }
            else {
                \Log::warning('❌ Seat 1A NOT FOUND in availableSeats array!');
            }

            // Debug: Tampilkan row 1 dan row 2
            $row1and2 = array_filter($availableSeats, function ($key) {
                return preg_match('/^[12][A-F]$/', $key);
            }, ARRAY_FILTER_USE_KEY);
            \Log::info('Row 1-2 seats:', array_keys($row1and2));

            $aircraft = $flight->aircraftInstance->aircraft;
            return view('flight.seats', [
                'flight' => $flight,
                'availableSeats' => $availableSeats,
                'requiredSeats' => $requiredSeats,
                'adults' => $adults,
                'children' => $children,
                'infants' => $infants,
                'aircraftConfig' => [
                    'seat_columns' => $aircraft->seat_columns ?? 6,
                    'seat_rows' => $aircraft->seat_rows ?? 30,
                    'business_rows' => $aircraft->business_rows ?? 2,
                    'preferred_zone_enabled' => $aircraft->preferred_zone_enabled ?? false,
                    'preferred_zone_start_row' => $aircraft->preferred_zone_start_row,
                    'preferred_zone_end_row' => $aircraft->preferred_zone_end_row,
                    'seat_letters' => $aircraft->seat_letters ?? ['A', 'B', 'C', 'D', 'E', 'F'],
                ]
            ]);

        }
        catch (\Exception $e) {
            \Log::error('Error in FlightController@seats: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());

            // Fallback dengan dummy data
            return $this->showSeatsWithDummyData($id);
        }
    }

    private function showSeatsWithDummyData($id)
    {
        try {
            $flight = FlightInstance::with([
                'schedule.originAirport',
                'schedule.destinationAirport',
                'aircraftInstance.aircraft'
            ])->findOrFail($id);

            // Create comprehensive dummy data
            $availableSeats = [];

            // Business Class (Rows 1-2) - $250
            for ($row = 1; $row <= 2; $row++) {
                foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $letter) {
                    $seatNumber = $row . $letter;
                    $availableSeats[$seatNumber] = [
                        'seat_id' => 'b_' . $row . $letter,
                        'seat_number' => $seatNumber,
                        'seat_class' => 'business',
                        'seat_type' => in_array($letter, ['A', 'F']) ? 'window' :
                        (in_array($letter, ['C', 'D']) ? 'aisle' : 'middle'),
                        'is_available' => true,
                        'price' => 250.00
                    ];
                }
            }

            // Preferred Zone (Rows 3-5) - $180
            for ($row = 3; $row <= 5; $row++) {
                foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $letter) {
                    $seatNumber = $row . $letter;
                    $availableSeats[$seatNumber] = [
                        'seat_id' => 'p_' . $row . $letter,
                        'seat_number' => $seatNumber,
                        'seat_class' => 'economy',
                        'seat_type' => in_array($letter, ['A', 'F']) ? 'window' :
                        (in_array($letter, ['C', 'D']) ? 'aisle' : 'middle'),
                        'is_available' => true,
                        'price' => 180.00
                    ];
                }
            }

            // Economy Class (Rows 6-30) - $150
            for ($row = 6; $row <= 30; $row++) {
                foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $letter) {
                    $seatNumber = $row . $letter;
                    $availableSeats[$seatNumber] = [
                        'seat_id' => 'e_' . $row . $letter,
                        'seat_number' => $seatNumber,
                        'seat_class' => 'economy',
                        'seat_type' => in_array($letter, ['A', 'F']) ? 'window' :
                        (in_array($letter, ['C', 'D']) ? 'aisle' : 'middle'),
                        'is_available' => true,
                        'price' => 150.00
                    ];
                }
            }

            $aircraft = $flight->aircraftInstance->aircraft;
            $adults = max(1, intval(session('booking_adults', 1)));
            $children = max(0, intval(session('booking_children', 0)));
            $infants = max(0, intval(session('booking_infants', 0)));
            $requiredSeats = $adults + $children;

            return view('flight.seats', [
                'flight' => $flight,
                'availableSeats' => $availableSeats,
                'requiredSeats' => $requiredSeats,
                'adults' => $adults,
                'children' => $children,
                'infants' => $infants,
                'aircraftConfig' => [
                    'seat_columns' => $aircraft->seat_columns ?? 6,
                    'seat_rows' => $aircraft->seat_rows ?? 30,
                    'business_rows' => $aircraft->business_rows ?? 2,
                    'preferred_zone_enabled' => $aircraft->preferred_zone_enabled ?? false,
                    'preferred_zone_start_row' => $aircraft->preferred_zone_start_row,
                    'preferred_zone_end_row' => $aircraft->preferred_zone_end_row,
                    'seat_letters' => $aircraft->seat_letters ?? ['A', 'B', 'C', 'D', 'E', 'F'],
                ]
            ]);

        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Unable to load seat selection. Please try again later.');
        }
    }

    public function show($id)
    {
        $flight = FlightInstance::with([
            'schedule.originAirport',
            'schedule.destinationAirport',
            'aircraftInstance.aircraft'
        ])->findOrFail($id);

        return view('flight.show', compact('flight'));
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'flight_instance_id' => 'required|exists:flight_instances,flight_instance_id',
            'selected_seats' => 'required|json',
            'total_price' => 'required|numeric'
        ]);

        $selectedSeats = json_decode($request->selected_seats, true);

        if (empty($selectedSeats)) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Please select seats'], 400);
            }
            return redirect()->back()->with('error', 'Please select seats');
        }

        // Simpan ke session
        session([
            'selected_seats' => $request->selected_seats,
            'flight_instance_id' => $request->flight_instance_id,
            'total_price' => $request->total_price
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Seats selected',
                'redirect' => route('booking.form')
            ]);
        }

        return redirect()->route('booking.form')
            ->with('success', 'Seats selected!')
            ->with('selected_seats', $request->selected_seats)
            ->with('total_price', $request->total_price);
    }
}