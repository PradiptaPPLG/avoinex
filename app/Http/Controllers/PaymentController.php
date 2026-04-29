<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Booking;
use App\Mail\BookingConfirmationMail;

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
                    'bookingSeats.seat',
                    'bookingSeats.meal'
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
        try {
            \DB::beginTransaction();

            $booking = Booking::with(['bookingSeats.flightSeatPrice'])->lockForUpdate()->find($request->booking_id);

            if (!$booking || $booking->booking_status !== 'pending') {
                \DB::rollBack();
                return redirect()->route('booking.index')
                    ->with('error', 'Sesi pembayaran telah berakhir atau booking tidak valid. Silakan pesan kembali.');
            }

            // Simulasi pembayaran sukses
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

            \DB::commit();

            // Send E-Ticket confirmation email (fail silently if SMTP is not configured)
            try {
                $booking->load([
                    'client',
                    'flightInstance.schedule.originAirport',
                    'flightInstance.schedule.destinationAirport',
                    'flightInstance.schedule',
                    'bookingSeats.seat'
                ]);

                $recipientEmail = $booking->client->email ?? null;
                if ($recipientEmail) {
                    Mail::to($recipientEmail)->send(new BookingConfirmationMail($booking));
                    \Log::info('E-ticket email sent to: ' . $recipientEmail, ['booking_code' => $booking->booking_code]);
                }
            } catch (\Exception $mailEx) {
                \Log::warning('E-ticket email failed (booking still confirmed): ' . $mailEx->getMessage(), [
                    'booking_id' => $booking->booking_id,
                    'booking_code' => $booking->booking_code
                ]);
            }

            return redirect()->route('booking.confirmation', $booking->booking_id);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Payment processing failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }
}