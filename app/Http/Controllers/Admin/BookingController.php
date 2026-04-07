<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RefundProcessedMail;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['client', 'flightInstance.schedule']);

        if ($request->has('status') && $request->status != '') {
            $query->where('booking_status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);

        // Count refund requests for the badge
        $refundCount = Booking::where('booking_status', 'refund_requested')->count();

        return view('admin.bookings.index', compact('bookings', 'refundCount'));
    }

    public function show($id)
    {
        $booking = Booking::with([
            'client',
            'flightInstance.schedule.originAirport',
            'flightInstance.schedule.destinationAirport',
            'bookingSeats'
        ])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show all pending refund requests.
     */
    public function refunds()
    {
        $refundRequests = Booking::with(['client', 'flightInstance.schedule.originAirport', 'flightInstance.schedule.destinationAirport', 'bookingSeats'])
            ->where('booking_status', 'refund_requested')
            ->orderBy('refund_requested_at', 'asc')
            ->paginate(20);

        return view('admin.bookings.refunds', compact('refundRequests'));
    }

    /**
     * Process a refund request (approve or reject).
     */
    public function processRefund(Request $request, $bookingId)
    {
        $booking = Booking::with(['flightInstance'])->findOrFail($bookingId);

        if ($booking->booking_status !== 'refund_requested') {
            return back()->with('error', 'Booking ini tidak sedang dalam status permintaan refund.');
        }

        $request->validate([
            'action'       => 'required|in:approve,reject',
            'admin_notes'  => 'nullable|string|max:1000',
        ]);

        if ($request->action === 'approve') {
            // Auto calculate based on policy
            $calc = $booking->calculateRefundAmount();
            
            $booking->update([
                'booking_status'      => 'cancelled',
                'payment_status'      => 'refunded',
                'refund_amount_usd'   => $calc['amount'],
                'refund_admin_notes'  => $request->admin_notes,
                'refund_processed_at' => now(),
            ]);

            // Kirim Email Notifikasi
            try {
                Mail::to($booking->client->email)->send(new RefundProcessedMail($booking, 'approved'));
            } catch (\Exception $e) {
                // Log error but don't stop the process
                \Illuminate\Support\Facades\Log::error("Gagal kirim email refund approved: " . $e->getMessage());
            }

            return back()->with('success', "Refund untuk booking {$booking->booking_code} BERHASIL disetujui secara otomatis senilai Rp " . number_format($calc['amount'], 0, ',', '.') . " (" . $calc['percentage'] . "%). Email notifikasi telah dikirim ke " . $booking->client->email);
        }

        // Reject
        $booking->update([
            'booking_status'      => 'confirmed',
            'payment_status'      => 'refund_rejected',
            'refund_admin_notes'  => $request->admin_notes,
            'refund_processed_at' => now(),
        ]);

        // Kirim Email Notifikasi
        try {
            Mail::to($booking->client->email)->send(new RefundProcessedMail($booking, 'rejected'));
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Illuminate\Support\Facades\Log::error("Gagal kirim email refund rejected: " . $e->getMessage());
        }

        return back()->with('success', "Permintaan refund untuk booking {$booking->booking_code} telah ditolak. Email notifikasi telah dikirim ke " . $booking->client->email);
    }
}
