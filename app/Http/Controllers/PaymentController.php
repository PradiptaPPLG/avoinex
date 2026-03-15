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
        try {
            \DB::beginTransaction();

            $booking = Booking::with(['bookingSeats.flightSeatPrice'])->lockForUpdate()->find($request->booking_id);

            // 1. Lock flash sale record
            $flashSale = \App\Models\FlashSale::where('flight_id', $booking->flight_instance_id) // Add index to flight_id lookup!
                ->lockForUpdate()
                ->first();

            $isPromoBooking = false;
            foreach ($booking->bookingSeats as $seat) {
                // If price at booking is less than normal price, it used a promo
                if ($seat->price_at_booking < ($seat->flightSeatPrice->price_usd ?? 0)) {
                    $isPromoBooking = true;
                    break;
                }
            }

            if ($isPromoBooking && $flashSale) {
                $passengerCount = $booking->bookingSeats->count();
                // 2. Recalculate remaining seats
                $remaining = $flashSale->getRemainingSeats();

                if ($remaining >= $passengerCount && $flashSale->is_active && $flashSale->end_time >= now()) {
                    // 3. If seats available → continue
                    // 4. Increment seats_sold
                    $flashSale->seats_sold += $passengerCount;
                    $flashSale->save();
                } else {
                    // 5. If remaining seats are already 0, fallback to normal price
                    // We must revert all discounted seats to base price
                    $totalAdditional = 0;
                    foreach ($booking->bookingSeats as $bSeat) {
                        $basePrice = $bSeat->flightSeatPrice->price_usd ?? $bSeat->price_at_booking;
                        $diff = max(0, $basePrice - $bSeat->price_at_booking);
                        if ($diff > 0) {
                            $bSeat->price_at_booking = $basePrice;
                            $bSeat->save();
                            $totalAdditional += $diff;
                        }
                    }

                    if ($totalAdditional > 0) {
                        $booking->total_price_usd += $totalAdditional;
                        $booking->save();
                        
                        \DB::commit(); // Save the reverted price
                        
                        // Fail the payment implicitly and notify user to pay normal price
                        return redirect()->route('payment.page', $booking->booking_id)
                            ->with('error', 'The Flash Sale has expired or run out of seats! The price has been updated to the normal base price. Please review and pay again.');
                    }
                }
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

            return redirect()->route('booking.confirmation', $booking->booking_id);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Payment processing failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }
}