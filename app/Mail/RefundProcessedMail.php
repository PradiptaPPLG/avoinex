<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $status; // 'approved' or 'rejected'

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, string $status)
    {
        $this->booking = $booking;
        $this->status = $status;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->status === 'approved' 
            ? "Refund Disetujui: Booking #{$this->booking->booking_code}" 
            : "Refund Ditolak: Booking #{$this->booking->booking_code}";

        return $this->subject($subject)
                    ->view('emails.refund_processed');
    }
}
