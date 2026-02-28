<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class PaymentController extends Controller
{
    public function create($bookingId)
    {
        \Log::info('PaymentController::create called', ['booking_id' => $bookingId]);

        try {
            $booking = Booking::with([
                    'client',
                    'flightInstance.schedule.originAirport',
                    'flightInstance.schedule.destinationAirport',
                    'bookingSeats'
                ])
                ->findOrFail($bookingId);

            \Log::info('Booking found for payment', [
                'booking_id' => $booking->booking_id,
                'booking_code' => $booking->booking_code,
                'total_price' => $booking->total_price_usd
            ]);

            return view('payment.page', compact('booking'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Booking not found for payment', ['booking_id' => $bookingId]);
            return redirect()->route('home')
                ->with('error', 'Booking not found. Please try again.');
        } catch (\Exception $e) {
            \Log::error('Error loading payment page', [
                'booking_id' => $bookingId,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('home')
                ->with('error', 'Failed to load payment page. Please try again.');
        }
    }

    public function process(Request $request)
    {
        // Simulasi pembayaran sukses
        $booking = Booking::find($request->booking_id);
        $booking->update([
            'payment_status' => 'paid',
            'booking_status' => 'confirmed'
        ]);

        // Generate booking code jika belum ada
        if (!$booking->booking_code) {
            $booking->update([
                'booking_code' => 'AVX-' . strtoupper(substr(md5(uniqid()), 0, 8))
            ]);
        }

        return redirect()->route('booking.confirmation', $booking->booking_id);
    }
}