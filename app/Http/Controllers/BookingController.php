<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Client;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\FlightInstance;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('client_id', session('client_id'))
            ->whereIn('booking_status', ['confirmed', 'pending'])
            ->where('payment_status', 'paid')
            ->with([
                'flightInstance.schedule.originAirport',
                'flightInstance.schedule.destinationAirport'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        // ========== AMBIL DATA DARI URL ATAU SESSION ==========
        if ($request->has('seats')) {
            // Data dari URL parameters (dari seat selection)
            $selectedSeats = $request->input('seats');
            $flightInstanceId = $request->input('flight_id', 1);
            $totalPrice = $request->input('total', 0);

            // Simpan ke session
            Session::put('selected_seats', $selectedSeats);
            Session::put('flight_instance_id', $flightInstanceId);
            Session::put('total_price', $totalPrice);
        } else {
            // Data dari session
            $selectedSeats = Session::get('selected_seats');
            $flightInstanceId = Session::get('flight_instance_id');
            $totalPrice = Session::get('total_price');
        }

        // ========== VALIDASI DATA ==========
        if (empty($selectedSeats) || !$flightInstanceId) {
            return redirect()->route('flight.seats', ['flightInstanceId' => 1])
                ->with('error', 'Please select seats first.');
        }

        // ========== PARSE SEATS DATA ==========
        $seatsArray = json_decode($selectedSeats, true) ?: [];

        // Validasi format data seats
        foreach ($seatsArray as &$seat) {
            $seat['id'] = $seat['id'] ?? 'unknown';
            $seat['number'] = $seat['number'] ?? 'N/A';
            $seat['class'] = $seat['class'] ?? 'economy';
            $seat['price'] = floatval($seat['price'] ?? 150.00);
        }

        // ========== AMBIL DATA FLIGHT ==========
        $flight = FlightInstance::with([
            'schedule.originAirport',
            'schedule.destinationAirport'
        ])->find($flightInstanceId);

        if (!$flight) {
            return redirect()->route('home')
                ->with('error', 'Flight not found.');
        }

        // ========== RETURN VIEW ==========
        return view('booking.form', [
            'flight' => $flight,
            'selectedSeats' => $seatsArray,
            'totalPrice' => $totalPrice
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('=== BOOKING STORE START ===');
        \Log::info('Request data:', $request->except(['_token']));
        \Log::info('Full session data:', Session::all());

        // Validasi input
        $validated = $request->validate([
            'contact_first_name' => 'required|string|max:45',
            'contact_last_name' => 'required|string|max:45',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'contact_country' => 'nullable|string|size:2',
            'passenger_first_name' => 'required|array',
            'passenger_last_name' => 'required|array',
            'passenger_passport' => 'required|array',
            'passenger_dob' => 'nullable|array',
            'special_requests' => 'nullable|array',
            'seat_ids' => 'required|array',
            'seat_numbers' => 'required|array',
            'seat_prices' => 'required|array'
        ]);

        \Log::info('Validated data keys:', array_keys($validated));
        \Log::info('Passenger count: ' . count($validated['passenger_first_name']));
        \Log::info('Seat IDs:', $validated['seat_ids']);

        // Ambil flight_instance_id dari session
        $flightInstanceId = Session::get('flight_instance_id');

        \Log::info('Flight Instance ID from session: ' . $flightInstanceId);

        if (!$flightInstanceId) {
            \Log::error('Flight instance ID not found in session');
            return redirect()->route('flight.seats', ['flightInstanceId' => 1])
                ->with('error', 'Flight information missing. Please select seats again.');
        }

        try {
            \Log::info('Starting booking process for flight: ' . $flightInstanceId);

            // 1. Cari atau buat Client - PERBAIKAN
            \Log::info('Looking for client with email: ' . $validated['contact_email']);

            // Cek dulu apakah client ada
            $client = Client::where('email', $validated['contact_email'])->first();

            if (!$client) {
                // Buat client baru
                $client = Client::create([
                    'first_name' => $validated['contact_first_name'],
                    'last_name' => $validated['contact_last_name'],
                    'phone' => $validated['contact_phone'],
                    'email' => $validated['contact_email'],
                    'passport' => $validated['passenger_passport'][0] ?? 'UNKNOWN',
                    'iata_country_code' => $validated['contact_country'] ?? 'ID'
                ]);
                \Log::info('New client created:', ['client_id' => $client->client_id]);
            } else {
                // Update client yang ada
                $client->update([
                    'first_name' => $validated['contact_first_name'],
                    'last_name' => $validated['contact_last_name'],
                    'phone' => $validated['contact_phone']
                ]);
                \Log::info('Existing client found:', ['client_id' => $client->client_id]);
            }

            // 2. Buat Booking
            $bookingCode = 'AVX-' . strtoupper(substr(md5(uniqid()), 0, 8));

            \Log::info('Creating booking with code: ' . $bookingCode);

            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'client_id' => $client->client_id,
                'flight_instance_id' => $flightInstanceId,
                'total_price_usd' => array_sum($validated['seat_prices']),
                'booking_status' => 'pending',
                'payment_status' => 'unpaid',
                'expires_at' => now()->addHours(24)
            ]);

            \Log::info('Booking created:', [
                'booking_id' => $booking->booking_id,
                'booking_code' => $booking->booking_code,
                'total_price' => $booking->total_price_usd
            ]);

            // 3. Buat BookingSeat untuk setiap penumpang - PERBAIKAN
            \Log::info('Creating booking seats, count: ' . count($validated['passenger_first_name']));

            // Cari flight_seat_price_id berdasarkan seat_id
            foreach ($validated['passenger_first_name'] as $index => $firstName) {
                // Konversi seat_id ke integer jika perlu
                $seatId = $validated['seat_ids'][$index];
                if (is_string($seatId) && strpos($seatId, 'test_') === 0) {
                    // Jika seat_id adalah string test_1, ambil angka saja
                    $seatId = intval(str_replace('test_', '', $seatId));
                }

                // Cari flight_seat_price_id berdasarkan seat_id dan flight_instance_id
                $flightSeatPrice = \App\Models\FlightSeatPrice::where('flight_instance_id', $flightInstanceId)
                    ->where('seat_id', $seatId)
                    ->first();

                $flightSeatPriceId = $flightSeatPrice ? $flightSeatPrice->flight_seat_price_id : 1; // Default ke 1 jika tidak ditemukan

                BookingSeat::create([
                    'booking_id' => $booking->booking_id,
                    'flight_seat_price_id' => $flightSeatPriceId,
                    'passenger_first_name' => $firstName,
                    'passenger_last_name' => $validated['passenger_last_name'][$index],
                    'passenger_passport' => $validated['passenger_passport'][$index],
                    'passenger_date_of_birth' => $validated['passenger_dob'][$index] ?? null,
                    'seat_id' => $seatId,
                    'price_at_booking' => $validated['seat_prices'][$index],
                    'special_requests' => $validated['special_requests'][$index] ?? null
                ]);
            }

            // 4. Simpan booking_id di session untuk payment
            Session::put('current_booking_id', $booking->booking_id);

            // 5. Log success dengan detail
            \Log::info('✅ Booking process completed successfully:', [
                'booking_id' => $booking->booking_id,
                'booking_code' => $booking->booking_code,
                'client_id' => $client->client_id,
                'seats_count' => count($validated['passenger_first_name']),
                'total_price' => $booking->total_price_usd,
                'redirect_url' => route('payment.page', ['booking' => $booking->booking_id])
            ]);

            // 6. Redirect ke payment page
            return redirect()->route('payment.page', ['booking' => $booking->booking_id])
                ->with('success', 'Booking created successfully! Please complete payment.');

        } catch (\Exception $e) {
            \Log::error('❌ BookingController::store error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            \Log::error('Full error context:', [
                'validated_data' => $validated,
                'flight_instance_id' => $flightInstanceId,
                'session_data' => Session::all()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to create booking. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function cancel($bookingId)
    {
        $booking = Booking::with(['flightInstance', 'bookingSeats'])
            ->where('booking_id', $bookingId)
            ->where('client_id', session('client_id'))
            ->first();

        if (!$booking) {
            abort(403);
        }

        if ($booking->booking_status !== 'confirmed') {
            return redirect()->route('booking.index')
                ->with('error', 'Only confirmed bookings can be cancelled.');
        }

        if ($booking->flightInstance->flight_date->isPast()) {
            return redirect()->route('booking.index')
                ->with('error', 'Cannot cancel past flights.');
        }

        $booking->update(['booking_status' => 'cancelled']);

        return redirect()->route('booking.index')
            ->with('success', 'Booking successfully cancelled.');
    }

    public function confirmation($id)
    {
        $booking = Booking::with([
            'client',
            'flightInstance.schedule.originAirport',
            'flightInstance.schedule.destinationAirport',
            'bookingSeats.seat'
        ])->findOrFail($id);

        return view('booking.confirmation', compact('booking'));
    }
}
