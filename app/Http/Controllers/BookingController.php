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
            ->whereIn('booking_status', ['confirmed', 'pending', 'refund_requested', 'cancelled'])
            ->with([
            'flightInstance.schedule.originAirport',
            'flightInstance.schedule.destinationAirport',
            'bookingSeats'
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
        }
        else {
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
            'schedule.destinationAirport',
            'meals'
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
            'seat_prices' => 'required|array',
            'baggage_weights' => 'required|array',
            'baggage_prices' => 'required|array',
            'meal_ids' => 'nullable|array',
            'meal_prices' => 'nullable|array',
            'has_insurances' => 'nullable|array',
            'seat_is_vip' => 'nullable|array'
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

            // 1. Cari Client berdasarkan Email
            \Log::info('Looking for client with email: ' . $validated['contact_email']);
            $client = Client::where('email', $validated['contact_email'])->first();

            // Jika tidak ditemukan dari email, coba cari dari Passport penumpang pertama 
            // (menghindari error Integrity constraint violation unique passport)
            if (!$client && !empty($validated['passenger_passport'][0])) {
                $client = Client::where('passport', $validated['passenger_passport'][0])->first();
            }

            if (!$client) {
                // Jika masih tidak ada, coba buat baru sambil men-catch error duplicate yang langka
                try {
                    $client = Client::create([
                        'first_name' => $validated['contact_first_name'],
                        'last_name' => $validated['contact_last_name'],
                        'phone' => $validated['contact_phone'],
                        'email' => $validated['contact_email'],
                        'passport' => $validated['passenger_passport'][0] ?? 'UNKNOWN-' . uniqid(),
                        'iata_country_code' => $validated['contact_country'] ?? 'ID'
                    ]);
                    \Log::info('New client created:', ['client_id' => $client->client_id]);
                } catch (\Illuminate\Database\QueryException $e) {
                    // Jika tetap bentrok passport (e.g. gara2 race condition atau UNKNOWN duplicate), generate random passport
                    if ($e->errorInfo[1] == 1062) {
                        $client = Client::create([
                            'first_name' => $validated['contact_first_name'],
                            'last_name' => $validated['contact_last_name'],
                            'phone' => $validated['contact_phone'],
                            'email' => $validated['contact_email'],
                            'passport' => 'PASS-' . substr(md5(uniqid()), 0, 8),
                            'iata_country_code' => $validated['contact_country'] ?? 'ID'
                        ]);
                        \Log::info('Client created with generated passport string due to collision');
                    } else {
                        throw $e;
                    }
                }
            } else {
                // Jika ditemukan (baik dari email atau passport), perbarui datanya dengan kontak terbaru
                $client->update([
                    'first_name' => $validated['contact_first_name'],
                    'last_name' => $validated['contact_last_name'],
                    'phone' => $validated['contact_phone'],
                    'email' => $validated['contact_email']
                ]);
                \Log::info('Existing client updated:', ['client_id' => $client->client_id]);
            }

            // 2. Buat Booking
            $bookingCode = 'AVX-' . strtoupper(substr(md5(uniqid()), 0, 8));

            \Log::info('Creating booking with code: ' . $bookingCode);

            // Frontend sends seat_prices and baggage_prices in IDR!
            // We need to convert them back to USD for storage in the 'total_price_usd' column.
            $exchangeRate = config('app.usd_to_idr', 15500);
            
            $subtotalIdr = array_sum($validated['seat_prices']) + array_sum($validated['baggage_prices']);
            
            // Add meal prices (IDR) if present
            if (!empty($validated['meal_prices'])) {
                $subtotalIdr += array_sum($validated['meal_prices']);
            }
            
            // Add insurance prices (IDR) if present
            $insuranceSumIdr = 0;
            if (!empty($validated['has_insurances'])) {
                foreach ($validated['has_insurances'] as $hasIns) {
                    if ($hasIns == '1' || $hasIns == 'true' || $hasIns === true) {
                        $insuranceSumIdr += 45000; // Fixed IDR price
                    }
                }
            }
            $subtotalIdr += $insuranceSumIdr;

            // Convert to USD for DB
            $subtotalUsd = $subtotalIdr / $exchangeRate;

            $taxRate = 0.10;
            $serviceFeeUsd = 5.00; // Fixed USD fee
            
            // Calculate final grand total in USD with higher precision
            // This avoids the Rp 31 difference caused by rounding to 2 decimals too early
            $grandTotalUsd = $subtotalUsd * (1 + $taxRate) + $serviceFeeUsd;

            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'client_id' => $client->client_id,
                'flight_instance_id' => $flightInstanceId,
                'total_price_usd' => $grandTotalUsd,
                'booking_status' => 'pending',
                'payment_status' => 'unpaid',
                'expires_at' => now()->addHours(24)
            ]);

            \Log::info('Booking created:', [
                'booking_id' => $booking->booking_id,
                'booking_code' => $booking->booking_code,
                'total_price' => $booking->total_price_usd
            ]);

            // 3. Buat BookingSeat untuk setiap penumpang
            \Log::info('Creating booking seats, count: ' . count($validated['passenger_first_name']));

            // Get the aircraft_id for this flight (used when resolving dummy seat IDs)
            $flightInst = FlightInstance::with('aircraftInstance')->find($flightInstanceId);
            $aircraftId = null;
            if ($flightInst && $flightInst->aircraftInstance) {
                $aircraftId = $flightInst->aircraftInstance->aircraft_id;
            }

            foreach ($validated['passenger_first_name'] as $index => $firstName) {
                $seatId = $validated['seat_ids'][$index];

                // Handle prefixed dummy seat IDs: e_3F, b_1A, p_3C, test_1
                if (is_string($seatId) && preg_match('/^(e|b|p|test)_(.+)$/', $seatId, $matches)) {
                    $seatNumber = $matches[2];
                    $type = $matches[1];
                    \Log::info('Resolving dummy seat_id', ['raw' => $seatId, 'seat_number' => $seatNumber, 'aircraft_id' => $aircraftId]);

                    // Look up the actual seat_id from the seats table
                    $actualSeat = \App\Models\Seat::where('aircraft_id', $aircraftId)
                        ->where('seat_number', $seatNumber)
                        ->first();

                    if ($actualSeat) {
                        $seatId = $actualSeat->seat_id;
                        \Log::info('Resolved to real seat_id: ' . $seatId);
                    }
                    elseif ($aircraftId) {
                        $seatClass = 'economy';
                        if ($type == 'b') $seatClass = 'business';
                        if ($type == 'p') $seatClass = 'first';
                        
                        $actualSeat = \App\Models\Seat::create([
                            'aircraft_id' => $aircraftId,
                            'seat_number' => $seatNumber,
                            'seat_class' => $seatClass
                        ]);
                        $seatId = $actualSeat->seat_id;
                        \Log::info('Created missing seat on-the-fly: ' . $seatId);
                    }
                    else {
                        \Log::warning('Could not resolve seat_number and no aircraft_id', ['seat_number' => $seatNumber]);
                    }
                }

                // Ensure seat_id is a valid integer
                if (!is_numeric($seatId)) {
                    \Log::error('seat_id is not numeric after resolution, failing', ['seat_id' => $seatId]);
                    throw new \Exception("Invalid seat selected for passenger $firstName.");
                }
                $seatId = intval($seatId);

                // Cari flight_seat_price_id berdasarkan seat_id dan flight_instance_id
                $flightSeatPrice = \App\Models\FlightSeatPrice::where('flight_instance_id', $flightInstanceId)
                    ->where('seat_id', $seatId)
                    ->first();

                // If no flight_seat_price record exists, create one on-the-fly
                if (!$flightSeatPrice) {
                    $price = floatval($validated['seat_prices'][$index]);
                    $flightSeatPrice = \App\Models\FlightSeatPrice::create([
                        'flight_instance_id' => $flightInstanceId,
                        'seat_id' => $seatId,
                        'price_usd' => $price,
                        'currency' => 'USD',
                        'is_available' => true,
                    ]);
                    \Log::info('Auto-created FlightSeatPrice', ['id' => $flightSeatPrice->flight_seat_price_id, 'seat_id' => $seatId]);
                }

                $mealId = isset($validated['meal_ids'][$index]) && $validated['meal_ids'][$index] ? $validated['meal_ids'][$index] : null;
                $mealPriceIdr = isset($validated['meal_prices'][$index]) && $validated['meal_prices'][$index] ? floatval($validated['meal_prices'][$index]) : 0;
                $hasInsurance = isset($validated['has_insurances'][$index]) && ($validated['has_insurances'][$index] == '1' || $validated['has_insurances'][$index] == 'true');

                
                $exchangeRate = config('app.usd_to_idr', 15500);
                $insurancePriceIdr = 45000;
                $insurancePriceUsd = $hasInsurance ? round($insurancePriceIdr / $exchangeRate, 2) : 0.00;
                
                $isVipSeat = isset($validated['seat_is_vip'][$index]) && ($validated['seat_is_vip'][$index] == '1' || $validated['seat_is_vip'][$index] == 'true');

                BookingSeat::create([
                    'booking_id' => $booking->booking_id,
                    'flight_seat_price_id' => $flightSeatPrice->flight_seat_price_id,
                    'passenger_first_name' => $firstName,
                    'passenger_last_name' => $validated['passenger_last_name'][$index],
                    'passenger_passport' => $validated['passenger_passport'][$index],
                    'passenger_date_of_birth' => $validated['passenger_dob'][$index] ?? null,
                    'seat_id' => $seatId,
                    'price_at_booking' => round($validated['seat_prices'][$index] / $exchangeRate, 2),
                    'special_requests' => $validated['special_requests'][$index] ?? null,
                    'baggage_weight' => $validated['baggage_weights'][$index] ?? 0,
                    'baggage_price' => round(($validated['baggage_prices'][$index] ?? 0) / $exchangeRate, 2),
                    'meal_id' => $mealId,
                    'meal_price' => round($mealPriceIdr / $exchangeRate, 2),
                    'has_insurance' => $hasInsurance,
                    'insurance_price' => $insurancePriceUsd,
                    'is_vip_seat_selection' => $isVipSeat
                ]);
            }

            // 4. Simpan booking_id di session untuk payment
            Session::put('current_booking_id', $booking->booking_id);

            // 5. Log success
            \Log::info('Booking process completed successfully:', [
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

        }
        catch (\Exception $e) {
            \Log::error('BookingController::store error: ' . $e->getMessage());
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

    /**
     * Cancel an UNPAID booking (instant, no refund needed).
     */
    public function cancel($bookingId)
    {
        $booking = Booking::with(['flightInstance'])
            ->where('booking_id', $bookingId)
            ->where('client_id', session('client_id'))
            ->first();

        if (!$booking) {
            abort(403);
        }

        if (!$booking->canCancel()) {
            return redirect()->route('booking.index')
                ->with('error', 'Booking ini tidak bisa dibatalkan. Gunakan "Request Refund" untuk pesanan yang sudah dibayar.');
        }

        $booking->update([
            'booking_status' => 'cancelled',
        ]);

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    /**
     * Request a refund for a PAID booking (needs admin approval).
     */
    public function requestRefund(Request $request, $bookingId)
    {
        $booking = Booking::with(['flightInstance'])
            ->where('booking_id', $bookingId)
            ->where('client_id', session('client_id'))
            ->first();

        if (!$booking) {
            abort(403);
        }

        if (!$booking->canRequestRefund()) {
            return redirect()->route('booking.index')
                ->with('error', 'Booking ini tidak bisa di-refund. Pastikan pesanan sudah dibayar dan penerbangan belum lewat.');
        }

        $request->validate([
            'refund_reason' => 'required|string|max:1000',
        ]);

        $booking->update([
            'booking_status'      => 'refund_requested',
            'payment_status'      => 'refund_pending',
            'refund_reason'       => $request->refund_reason,
            'refund_requested_at' => now(),
        ]);

        // Restore flash sale quota if applicable
        $this->restoreFlashSaleQuota($booking);

        return redirect()->route('booking.index')
            ->with('success', 'Permintaan refund berhasil dikirim! Tim kami akan memprosesnya dalam 1-3 hari kerja.');
    }

    /**
     * Guest cancel — for unpaid guest bookings via Find Booking.
     */
    public function cancelGuest(Request $request, $bookingId)
    {
        $request->validate(['email' => 'required|email']);

        $booking = Booking::with(['flightInstance', 'client'])
            ->where('booking_id', $bookingId)
            ->first();

        if (!$booking || $booking->client->email !== $request->email) {
            abort(403, 'Unauthorized. Email does not match.');
        }

        // Guest can cancel unpaid OR request refund for paid
        if ($booking->canCancel()) {
            $booking->update(['booking_status' => 'cancelled']);
            return back()->with('success', 'Booking berhasil dibatalkan.');
        }

        if ($booking->canRequestRefund()) {
            $booking->update([
                'booking_status'      => 'refund_requested',
                'payment_status'      => 'refund_pending',
                'refund_reason'       => $request->input('refund_reason', 'Guest cancellation request'),
                'refund_requested_at' => now(),
            ]);
            $this->restoreFlashSaleQuota($booking);
            return back()->with('success', 'Permintaan refund berhasil dikirim! Tim kami akan memprosesnya dalam 1-3 hari kerja.');
        }

        return back()->with('error', 'Booking ini tidak bisa dibatalkan atau di-refund.');
    }

    /**
     * Restore flash sale quota when a booking is cancelled/refunded.
     */
    private function restoreFlashSaleQuota(Booking $booking)
    {
        $booking->load('bookingSeats.flightSeatPrice');
        $flashSale = \App\Models\FlashSale::where('flight_id', $booking->flight_instance_id)->first();

        if ($flashSale) {
            $passengerCount = $booking->bookingSeats->count();
            $isPromoBooking = false;
            foreach ($booking->bookingSeats as $seat) {
                if ($seat->price_at_booking < ($seat->flightSeatPrice->price_usd ?? 0)) {
                    $isPromoBooking = true;
                    break;
                }
            }
            if ($isPromoBooking && $flashSale->seats_sold >= $passengerCount) {
                $flashSale->decrement('seats_sold', $passengerCount);
            }
        }
    }

    public function confirmation($id)
    {
        $booking = Booking::with([
            'client',
            'flightInstance.schedule.originAirport',
            'flightInstance.schedule.destinationAirport',
            'bookingSeats.seat',
            'bookingSeats.meal'
        ])->findOrFail($id);

        return view('booking.confirmation', compact('booking'));
    }

    /**
     * Auth Gate — check if user is logged in before proceeding to booking form.
     */
    public function authGate(Request $request)
    {
        // If already logged in, go straight to booking form
        if (session('client_logged_in')) {
            return redirect()->route('booking.form', $request->query());
        }

        // Load flight info for the summary card
        $flight = null;
        $flightId = $request->input('flight_id');
        if ($flightId) {
            $flight = FlightInstance::with([
                'schedule.originAirport',
                'schedule.destinationAirport'
            ])->find($flightId);
        }

        // Store seat data in session so it persists through login/register
        if ($request->has('seats')) {
            Session::put('pending_booking_query', $request->query());
        }

        return view('booking.auth', compact('flight'));
    }

    /**
     * Guest Continue — set guest flag and redirect to booking form.
     */
    public function guestContinue(Request $request)
    {
        session(['booking_guest' => true]);

        // Rebuild query params from the form hidden fields
        $query = [];
        foreach (['seats', 'total', 'flight_id', 'adults', 'children', 'infants'] as $key) {
            if ($request->has($key)) {
                $query[$key] = $request->input($key);
            }
        }

        // Also check session for pending booking query (from login/register redirect)
        if (empty($query) || !isset($query['seats'])) {
            $query = Session::get('pending_booking_query', $query);
        }

        return redirect()->route('booking.form', $query);
    }

    /**
     * Find Booking Form — display the search form.
     */
    public function findForm()
    {
        return view('booking.find');
    }

    /**
     * Find Booking — search by booking code + email.
     */
    public function findBooking(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
            'email' => 'required|email',
        ]);

        $booking = Booking::where('booking_code', $request->booking_code)
            ->whereHas('client', function ($query) use ($request) {
                $query->where('email', $request->email);
            })
            ->with([
                'client',
                'flightInstance.schedule.originAirport',
                'flightInstance.schedule.destinationAirport',
                'flightInstance.schedule',
                'bookingSeats.seat'
            ])
            ->first();

        if (!$booking) {
            return back()
                ->withInput()
                ->with('error', 'Booking not found. Please check your booking code and email.');
        }

        return view('booking.find', compact('booking'));
    }

    /**
     * Download the E-Ticket as PDF.
     */
    public function downloadTicket($id)
    {
        $booking = Booking::with([
            'client',
            'flightInstance.schedule.originAirport',
            'flightInstance.schedule.destinationAirport',
            'flightInstance.schedule.airline',
            'bookingSeats.seat',
            'bookingSeats.meal',
            'payment'
        ])->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.ticket', compact('booking'));
        return $pdf->stream('E-Ticket-' . $booking->booking_code . '.pdf');
    }
}
