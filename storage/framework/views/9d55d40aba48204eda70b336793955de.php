<?php $__env->startPush('styles'); ?>
<style>
    @media print {
        .btn, .alert-success, .card-header.bg-success {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .container {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .row {
            display: block !important;
        }
        .col-md-8, .col-md-4 {
            width: 100% !important;
            margin-bottom: 20px;
        }
        .boarding-pass-card {
            border: 2px solid #000 !important;
            padding: 10px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4 mb-4">
    <!-- Booking Steps -->
    <div class="mb-4 position-relative d-print-none">
        <div class="progress" style="height: 3px; position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); z-index: 1;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
            <div class="text-center" style="width: 32%;">
                <div class="bg-success text-white rounded-pill py-2 border border-2 border-success shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> 1. Passenger Details
                </div>
            </div>
            <div class="text-center" style="width: 32%;">
                <div class="bg-success text-white rounded-pill py-2 border border-2 border-success shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> 2. Payment
                </div>
            </div>
            <div class="text-center" style="width: 32%;">
                <div class="bg-success text-white rounded-pill py-2 border border-2 border-success fw-bold shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> 3. Confirmation
                </div>
            </div>
        </div>
    </div>
    <div class="card border-success">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="bi bi-check-circle"></i> Booking Confirmed!</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-success">
                        <h5>Thank you for your booking!</h5>
                        <p class="mb-0">Your e-ticket has been sent to <strong><?php echo e($booking->client->email); ?></strong></p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Booking Details</h6>
                            <p><strong>Booking Code:</strong> <?php echo e($booking->booking_code); ?></p>
                            <p><strong>Booking Date:</strong> <?php echo e($booking->created_at->format('d M Y H:i')); ?></p>
                            <p><strong>Status:</strong> <span class="badge bg-success">Confirmed</span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Flight Details</h6>
                            <p><strong>Flight:</strong> <?php echo e($booking->flightInstance->schedule->flight_number); ?></p>
                            <p><strong>Route:</strong> 
                                <?php echo e($booking->flightInstance->schedule->originAirport->city); ?> (<?php echo e($booking->flightInstance->schedule->originAirport->iata_code); ?>) 
                                → 
                                <?php echo e($booking->flightInstance->schedule->destinationAirport->city); ?> (<?php echo e($booking->flightInstance->schedule->destinationAirport->iata_code); ?>)
                            </p>
                            <p><strong>Date:</strong> <?php echo e($booking->flightInstance->flight_date->format('d M Y')); ?></p>
                        </div>
                    </div>
                    
                    <h6 class="mt-4" style="font-weight: 700;">Passengers & Price Breakdown</h6>
                    <?php
                        $seatSubtotal = 0;
                        $baggageTotal = 0;
                    ?>
                    <table class="table table-sm" style="font-size: 13px;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Passport</th>
                                <th>Seat & Baggage</th>
                                <th class="text-end">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $booking->bookingSeats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $seatSubtotal += $seat->price_at_booking;
                                $baggageTotal += $seat->baggage_price ?? 0;
                            ?>
                            <tr>
                                <td><?php echo e($seat->passenger_first_name); ?> <?php echo e($seat->passenger_last_name); ?></td>
                                <td><?php echo e($seat->passenger_passport); ?></td>
                                <td>
                                    <div><?php echo e($seat->seat->seat_number ?? 'N/A'); ?></div>
                                    <?php if($seat->baggage_weight > 0): ?>
                                    <div class="small text-muted"><i class="bi bi-suitcase"></i> <?php echo e($seat->baggage_weight); ?> kg</div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div>Rp <?php echo e(number_format($seat->price_at_booking, 0, ',', '.')); ?></div>
                                    <?php if($seat->baggage_price > 0): ?>
                                    <div class="small text-muted">+Rp <?php echo e(number_format($seat->baggage_price, 0, ',', '.')); ?></div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <?php
                            $subtotal = $seatSubtotal + $baggageTotal;
                            $taxAmount = $subtotal * 0.10;
                            $serviceFee = 5.00;
                            $grandTotal = $subtotal + $taxAmount + $serviceFee;
                        ?>
                        <tfoot>
                            <tr class="text-muted" style="font-size: 12px;">
                                <td colspan="3" class="text-end border-0 py-1">Subtotal (Seats + Baggage)</td>
                                <td class="text-end border-0 py-1">Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?></td>
                            </tr>
                            <tr class="text-muted" style="font-size: 12px;">
                                <td colspan="3" class="text-end border-0 py-1"><i class="bi bi-receipt" style="font-size: 10px;"></i> Tax (10%)</td>
                                <td class="text-end border-0 py-1">Rp <?php echo e(number_format($taxAmount, 0, ',', '.')); ?></td>
                            </tr>
                            <tr class="text-muted" style="font-size: 12px;">
                                <td colspan="3" class="text-end border-0 py-1"><i class="bi bi-gear" style="font-size: 10px;"></i> Service Fee</td>
                                <td class="text-end border-0 py-1">Rp <?php echo e(number_format($serviceFee, 0, ',', '.')); ?></td>
                            </tr>
                            <tr style="border-top: 2px solid #dee2e6;">
                                <th colspan="3" class="text-end py-2">Total Paid</th>
                                <th class="text-end py-2" style="color: #0066CC; font-size: 15px;">Rp <?php echo e(number_format($grandTotal, 0, ',', '.')); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <div class="mt-4">
                        <a href="<?php echo e(route('booking.ticket', $booking->booking_id)); ?>" class="btn btn-outline-primary" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Download E-Ticket
                        </a>
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">
                            <i class="bi bi-house"></i> Back to Home
                        </a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card boarding-pass-card">
                        <div class="card-header">
                            <h6 class="mb-0">Boarding Pass</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="border p-4 mb-3">
                                <h5 class="text-primary"><?php echo e($booking->booking_code); ?></h5>
                                <h3><?php echo e($booking->flightInstance->schedule->flight_number); ?></h3>
                                <p class="mb-1"><?php echo e($booking->flightInstance->schedule->originAirport->iata_code); ?> → <?php echo e($booking->flightInstance->schedule->destinationAirport->iata_code); ?></p>
                                <p class="mb-1"><?php echo e($booking->flightInstance->flight_date->format('d M Y')); ?></p>
                                <p class="mb-0">Departure: <?php echo e($booking->flightInstance->schedule->departure_time_gmt); ?></p>
                            </div>
                            <div class="alert alert-info small">
                                <i class="bi bi-info-circle"></i> Present this code at check-in counter
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/booking/confirmation.blade.php ENDPATH**/ ?>