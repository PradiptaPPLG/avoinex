<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket — Avoinex</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:'Segoe UI',Arial,Helvetica,sans-serif;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding:32px 0;">
<tr><td align="center">

<!-- Main Card -->
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08);">

    <!-- Header -->
    <tr>
        <td style="background:linear-gradient(135deg,#279ED6,#1a7ab5); padding:32px 40px; text-align:center;">
            <h1 style="margin:0; color:#ffffff; font-size:28px; font-weight:800; letter-spacing:1px;">AVOINEX</h1>
            <p style="margin:8px 0 0; color:rgba(255,255,255,0.85); font-size:14px;">Your E-Ticket Confirmation</p>
        </td>
    </tr>

    <!-- Booking Code Banner -->
    <tr>
        <td style="padding:28px 40px 0; text-align:center;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background:#eef7fc; border:2px dashed #279ED6; border-radius:12px; padding:20px; text-align:center;">
                        <p style="margin:0 0 4px; font-size:12px; color:#666; text-transform:uppercase; letter-spacing:1.5px;">Booking Code</p>
                        <p style="margin:0; font-size:32px; font-weight:800; color:#279ED6; letter-spacing:3px;">{{ $booking->booking_code }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Flight Info -->
    <tr>
        <td style="padding:28px 40px 0;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="text-align:left; width:40%;">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px;">From</p>
                        <p style="margin:4px 0 0; font-size:24px; font-weight:800; color:#222;">{{ $booking->flightInstance->schedule->originAirport->iata_code }}</p>
                        <p style="margin:2px 0 0; font-size:13px; color:#666;">{{ $booking->flightInstance->schedule->originAirport->city }}</p>
                    </td>
                    <td style="text-align:center; width:20%; vertical-align:middle;">
                        <p style="margin:0; font-size:24px; color:#279ED6;">✈</p>
                        <p style="margin:0; font-size:11px; color:#999;">Direct</p>
                    </td>
                    <td style="text-align:right; width:40%;">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px;">To</p>
                        <p style="margin:4px 0 0; font-size:24px; font-weight:800; color:#222;">{{ $booking->flightInstance->schedule->destinationAirport->iata_code }}</p>
                        <p style="margin:2px 0 0; font-size:13px; color:#666;">{{ $booking->flightInstance->schedule->destinationAirport->city }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Departure Details -->
    <tr>
        <td style="padding:20px 40px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8f9fa; border-radius:10px; padding:16px;">
                <tr>
                    <td style="padding:12px 16px; width:33%;">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase;">Flight</p>
                        <p style="margin:4px 0 0; font-size:15px; font-weight:700; color:#222;">{{ $booking->flightInstance->schedule->flight_number }}</p>
                    </td>
                    <td style="padding:12px 16px; width:33%;">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase;">Date</p>
                        <p style="margin:4px 0 0; font-size:15px; font-weight:700; color:#222;">{{ $booking->flightInstance->flight_date->format('d M Y') }}</p>
                    </td>
                    <td style="padding:12px 16px; width:33%;">
                        <p style="margin:0; font-size:11px; color:#999; text-transform:uppercase;">Departure</p>
                        <p style="margin:4px 0 0; font-size:15px; font-weight:700; color:#222;">{{ date('H:i', strtotime($booking->flightInstance->schedule->departure_time_gmt)) }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Divider -->
    <tr>
        <td style="padding:0 40px;">
            <hr style="border:none; border-top:1px dashed #ddd; margin:0;">
        </td>
    </tr>

    <!-- Passenger Details -->
    <tr>
        <td style="padding:20px 40px;">
            <p style="margin:0 0 12px; font-size:14px; font-weight:700; color:#222; text-transform:uppercase; letter-spacing:1px;">Passenger Details</p>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                <tr style="background:#279ED6;">
                    <td style="padding:10px 14px; color:#fff; font-size:12px; font-weight:700; border-radius:8px 0 0 0;">Passenger</td>
                    <td style="padding:10px 14px; color:#fff; font-size:12px; font-weight:700; text-align:center;">Seat</td>
                    <td style="padding:10px 14px; color:#fff; font-size:12px; font-weight:700; text-align:center;">Baggage</td>
                    <td style="padding:10px 14px; color:#fff; font-size:12px; font-weight:700; text-align:right; border-radius:0 8px 0 0;">Price</td>
                </tr>
                @foreach($booking->bookingSeats as $index => $bSeat)
                <tr style="background:{{ $index % 2 == 0 ? '#f8f9fa' : '#ffffff' }};">
                    <td style="padding:12px 14px; font-size:13px; color:#333; border-bottom:1px solid #eee;">
                        {{ $bSeat->passenger_first_name }} {{ $bSeat->passenger_last_name }}
                    </td>
                    <td style="padding:12px 14px; font-size:13px; color:#333; text-align:center; border-bottom:1px solid #eee;">
                        <strong>{{ $bSeat->seat->seat_number ?? 'N/A' }}</strong>
                    </td>
                    <td style="padding:12px 14px; font-size:13px; color:#333; text-align:center; border-bottom:1px solid #eee;">
                        {{ $bSeat->baggage_weight ?? 0 }}kg
                    </td>
                    <td style="padding:12px 14px; font-size:13px; color:#333; text-align:right; border-bottom:1px solid #eee;">
                        ${{ number_format($bSeat->price_at_booking + ($bSeat->baggage_price ?? 0), 2) }}
                    </td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>

    <!-- Total Price -->
    <tr>
        <td style="padding:0 40px 24px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef7fc; border-radius:10px;">
                <tr>
                    <td style="padding:16px 20px;">
                        <p style="margin:0; font-size:13px; color:#666;">Total Price</p>
                    </td>
                    <td style="padding:16px 20px; text-align:right;">
                        <p style="margin:0; font-size:24px; font-weight:800; color:#279ED6;">${{ number_format($booking->total_price_usd, 2) }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Status -->
    <tr>
        <td style="padding:0 40px 28px; text-align:center;">
            <span style="display:inline-block; background:#d4edda; color:#155724; padding:8px 24px; border-radius:20px; font-size:13px; font-weight:700; letter-spacing:0.5px;">
                ✓ {{ strtoupper($booking->booking_status) }} — {{ strtoupper($booking->payment_status) }}
            </span>
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f8f9fa; padding:24px 40px; text-align:center; border-top:1px solid #eee;">
            <p style="margin:0 0 4px; font-size:12px; color:#999;">Thank you for choosing Avoinex.</p>
            <p style="margin:0; font-size:12px; color:#bbb;">This is an automated email. Please do not reply.</p>
        </td>
    </tr>

</table>
<!-- /Main Card -->

</td></tr>
</table>

</body>
</html>
