<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket: {{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #279ED6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #279ED6;
        }
        .e-ticket-title {
            text-align: right;
            font-size: 24px;
            font-weight: bold;
            color: #666;
            display: inline-block;
            float: right;
        }
        .booking-info {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            width: 30%;
        }
        .info-value {
            font-weight: bold;
            font-size: 16px;
        }
        .section-title {
            font-size: 18px;
            color: #279ED6;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
            margin-top: 30px;
        }
        .flight-card {
            background-color: #f8fbfe;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .flight-table {
            width: 100%;
            text-align: center;
        }
        .airport-code {
            font-size: 32px;
            font-weight: bold;
            color: #279ED6;
        }
        .city-name {
            font-size: 14px;
            color: #666;
        }
        .passenger-table {
            width: 100%;
            border-collapse: collapse;
        }
        .passenger-table th {
            background-color: #279ED6;
            color: #fff;
            padding: 10px;
            text-align: left;
        }
        .passenger-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #999;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .vip-badge {
            background-color: #FFC107;
            color: #000;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
            margin-left: 5px;
        }
        .insurance-tag {
            color: #279ED6;
            font-size: 11px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td>
                <div class="logo">Avoinex</div>
            </td>
            <td>
                <div class="e-ticket-title">E-TICKET / BOARDING PASS</div>
            </td>
        </tr>
    </table>

    <table class="booking-info">
        <tr>
            <td width="50%" valign="top">
                <table class="info-table">
                    <tr>
                        <td class="info-label">Booking Code</td>
                        <td class="info-value" style="color: #279ED6;">{{ $booking->booking_code }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Booking Date</td>
                        <td class="info-value">{{ $booking->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Status</td>
                        <td class="info-value">
                            <span style="color: {{ $booking->booking_status == 'confirmed' ? 'green' : 'orange' }}; text-transform: uppercase;">
                                {{ $booking->booking_status }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%" valign="top">
                <table class="info-table">
                    <tr>
                        <td class="info-label">Contact Name</td>
                        <td class="info-value">{{ $booking->client->first_name }} {{ $booking->client->last_name }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Email</td>
                        <td class="info-value">{{ $booking->client->email }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Phone</td>
                        <td class="info-value">{{ $booking->client->phone ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="section-title">FLIGHT DETAILS</div>
    
    <div class="flight-card">
        <table width="100%">
            <tr>
                <td width="30%">
                    <div style="font-weight: bold; font-size: 16px;">{{ $booking->flightInstance->schedule->airline->airline_name ?? 'Airline' }}</div>
                    <div style="color: #666;">Flight {{ $booking->flightInstance->schedule->flight_number }}</div>
                    <div style="margin-top: 10px; font-weight: bold;">{{ \Carbon\Carbon::parse($booking->flightInstance->departure_date)->format('D, d M Y') }}</div>
                </td>
                <td width="70%">
                    <table class="flight-table">
                        <tr>
                            <td width="40%">
                                <div class="airport-code">{{ $booking->flightInstance->schedule->originAirport->iata_code }}</div>
                                <div class="city-name">{{ $booking->flightInstance->schedule->originAirport->city }}</div>
                                <div style="font-weight: bold; margin-top: 5px;">{{ $booking->flightInstance->schedule->departure_time_gmt }}</div>
                            </td>
                            <td width="20%">
                                <div style="color: #999; font-size: 24px;">&#9992;</div>
                                <div style="font-size: 11px; color: #999;">{{ $booking->flightInstance->schedule->duration_minutes }} min</div>
                            </td>
                            <td width="40%">
                                <div class="airport-code">{{ $booking->flightInstance->schedule->destinationAirport->iata_code }}</div>
                                <div class="city-name">{{ $booking->flightInstance->schedule->destinationAirport->city }}</div>
                                <div style="font-weight: bold; margin-top: 5px;">{{ $booking->flightInstance->schedule->arrival_time_gmt }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">PASSENGER DETAILS</div>
    
    <table class="passenger-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Passenger Name</th>
                <th>Seat & Class</th>
                <th>Add-ons (Meals & Insurance)</th>
                <th>Baggage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking->bookingSeats as $index => $seat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-weight: bold; text-transform: uppercase;">{{ $seat->passenger_first_name }} {{ $seat->passenger_last_name }}</td>
                <td>
                    <span style="font-weight: bold; color: #279ED6;">{{ $seat->seat->seat_number }}</span>
                    <span style="text-transform: capitalize; color: #666; font-size: 11px;">({{ $seat->seat->seat_class ?? 'Economy' }})</span>
                    @if($seat->is_vip_seat_selection)
                        <span class="vip-badge">VIP CHOICE</span>
                    @endif
                </td>
                <td>
                    @if($seat->meal_id)
                        <div style="font-size: 12px;">Meal: {{ $seat->meal->name ?? 'Meal' }}</div>
                    @endif
                    @if($seat->has_insurance)
                        <div class="insurance-tag">Travel Protection Included</div>
                    @else
                        <div style="font-size: 11px; color: #999;">No Insurance</div>
                    @endif
                </td>
                <td>{{ $seat->baggage_weight > 0 ? $seat->baggage_weight . ' kg' : 'Cabin Only' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title" style="margin-top: 40px;">PAYMENT DETAILS</div>
    <table class="info-table" style="width: 50%;">
        <tr>
            <td class="info-label">Payment Status</td>
            <td class="info-value" style="color: {{ $booking->payment_status == 'paid' ? 'green' : 'orange' }}; text-transform: uppercase;">
                {{ $booking->payment_status }}
            </td>
        </tr>
        <tr>
            <td class="info-label">Total Amount</td>
            <td class="info-value" style="font-size: 20px; color: #279ED6;">Rp {{ number_format($booking->total_price_usd, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        This document is electronically generated by Avoinex. Please show this E-Ticket and your valid ID at the check-in counter.<br>
        Thank you for choosing Avoinex for your travel needs.
    </div>

</body>
</html>
