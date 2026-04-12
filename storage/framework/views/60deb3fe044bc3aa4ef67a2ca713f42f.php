<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket: <?php echo e($booking->booking_code); ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            width: 100%;
            border-bottom: 3px solid #279ED6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header td {
            vertical-align: middle;
        }
        .logo-img {
            height: 40px;
        }
        .e-ticket-title {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            color: #555;
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
        .flight-arrow {
            color: #279ED6;
            margin: 0 auto;
            text-align: center;
            display: block;
            height: 20px;
            position: relative;
            width: 80px;
        }
        .arrow-line {
            height: 2px;
            background-color: #279ED6;
            width: 100%;
            position: absolute;
            top: 50%;
            margin-top: -1px;
        }
        .arrow-head {
            width: 0;
            height: 0;
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-left: 10px solid #279ED6;
            position: absolute;
            right: 0;
            top: 50%;
            margin-top: -5px;
        }
        .flight-duration {
            font-size: 11px;
            color: #999;
            margin-top: 4px;
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

    <table class="header" style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <img src="<?php echo e(public_path('images/logo_new.png')); ?>" class="logo-img" alt="Avoinex">
            </td>
            <td style="width: 50%;">
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
                        <td class="info-value" style="color: #279ED6;"><?php echo e($booking->booking_code); ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Booking Date</td>
                        <td class="info-value"><?php echo e($booking->created_at->format('d M Y, H:i')); ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Status</td>
                        <td class="info-value">
                            <span style="color: <?php echo e($booking->booking_status == 'confirmed' ? 'green' : 'orange'); ?>; text-transform: uppercase;">
                                <?php echo e($booking->booking_status); ?>

                            </span>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%" valign="top">
                <table class="info-table">
                    <tr>
                        <td class="info-label">Contact Name</td>
                        <td class="info-value"><?php echo e($booking->client->first_name); ?> <?php echo e($booking->client->last_name); ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Email</td>
                        <td class="info-value"><?php echo e($booking->client->email); ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Phone</td>
                        <td class="info-value"><?php echo e($booking->client->phone ?? '-'); ?></td>
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
                    <div style="font-weight: bold; font-size: 16px;"><?php echo e($booking->flightInstance->schedule->airline->airline_name ?? 'Airline'); ?></div>
                    <div style="color: #666;">Flight <?php echo e($booking->flightInstance->schedule->flight_number); ?></div>
                    <div style="margin-top: 10px; font-weight: bold;"><?php echo e(\Carbon\Carbon::parse($booking->flightInstance->departure_date)->format('D, d M Y')); ?></div>
                </td>
                <td width="70%">
                    <table class="flight-table">
                        <tr>
                            <td width="40%">
                                <div class="airport-code"><?php echo e($booking->flightInstance->schedule->originAirport->iata_code); ?></div>
                                <div class="city-name"><?php echo e($booking->flightInstance->schedule->originAirport->city); ?></div>
                                <div style="font-weight: bold; margin-top: 5px;"><?php echo e($booking->flightInstance->schedule->departure_time_gmt); ?></div>
                            </td>
                            <td width="20%">
                                <div class="flight-arrow">
                                    <div class="arrow-line"></div>
                                    <div class="arrow-head"></div>
                                </div>
                                <div class="flight-duration"><?php echo e($booking->flightInstance->schedule->duration_minutes); ?> min</div>
                            </td>
                            <td width="40%">
                                <div class="airport-code"><?php echo e($booking->flightInstance->schedule->destinationAirport->iata_code); ?></div>
                                <div class="city-name"><?php echo e($booking->flightInstance->schedule->destinationAirport->city); ?></div>
                                <div style="font-weight: bold; margin-top: 5px;"><?php echo e($booking->flightInstance->schedule->arrival_time_gmt); ?></div>
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
            <?php $__currentLoopData = $booking->bookingSeats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td style="font-weight: bold; text-transform: uppercase;"><?php echo e($seat->passenger_first_name); ?> <?php echo e($seat->passenger_last_name); ?></td>
                <td>
                    <span style="font-weight: bold; color: #279ED6;"><?php echo e($seat->seat->seat_number); ?></span>
                    <span style="text-transform: capitalize; color: #666; font-size: 11px;">(<?php echo e($seat->seat->seat_class ?? 'Economy'); ?>)</span>
                    <?php if($seat->is_vip_seat_selection): ?>
                        <span class="vip-badge">VIP CHOICE</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($seat->meal_id): ?>
                        <div style="font-size: 12px;">Meal: <?php echo e($seat->meal->name ?? 'Meal'); ?></div>
                    <?php endif; ?>
                    <?php if($seat->has_insurance): ?>
                        <div class="insurance-tag">Travel Protection Included</div>
                    <?php else: ?>
                        <div style="font-size: 11px; color: #999;">No Insurance</div>
                    <?php endif; ?>
                </td>
                <td><?php echo e($seat->baggage_weight > 0 ? $seat->baggage_weight . ' kg' : 'Cabin Only'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="section-title" style="margin-top: 40px;">PAYMENT DETAILS</div>
    <table class="info-table" style="width: 50%;">
        <tr>
            <td class="info-label">Payment Status</td>
            <td class="info-value" style="color: <?php echo e($booking->payment_status == 'paid' ? 'green' : 'orange'); ?>; text-transform: uppercase;">
                <?php echo e($booking->payment_status); ?>

            </td>
        </tr>
        <tr>
            <td class="info-label">Total Amount</td>
            <td class="info-value" style="font-size: 20px; color: #279ED6;">
                <?php $exchangeRate = config('app.usd_to_idr', 15500); ?>
                Rp <?php echo e(number_format($booking->total_price_usd * $exchangeRate, 0, ',', '.')); ?>

            </td>
        </tr>
    </table>

    <div class="footer">
        This document is electronically generated by Avoinex. Please show this E-Ticket and your valid ID at the check-in counter.<br>
        Thank you for choosing Avoinex for your travel needs.
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/pdf/ticket.blade.php ENDPATH**/ ?>