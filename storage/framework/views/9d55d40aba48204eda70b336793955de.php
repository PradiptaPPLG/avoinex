<?php $__env->startPush('styles'); ?>
<style>
    @media print {
        .btn, .alert-soft-green, .card-header.bg-soft-green {
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
        <div class="progress" style="height: 3px; position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); z-index: 1; background-color: rgba(39, 158, 214, 0.2);">
            <div class="progress-bar" role="progressbar" style="width: 100%; background-color: #279ED6;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
            <div class="text-center" style="width: 32%;">
                <div class="rounded-pill py-2 border border-2 shadow-sm" style="background-color: #BDE3FF; border-color: #BDE3FF !important; color: #003366;">
                    <i class="bi bi-check-circle-fill me-1"></i> 1. Passenger Details
                </div>
            </div>
            <div class="text-center" style="width: 32%;">
                <div class="rounded-pill py-2 border border-2 shadow-sm" style="background-color: #BDE3FF; border-color: #BDE3FF !important; color: #003366;">
                    <i class="bi bi-check-circle-fill me-1"></i> 2. Payment
                </div>
            </div>
            <div class="text-center" style="width: 32%;">
                <div class="text-white rounded-pill py-2 border border-2 shadow-sm" style="background-color: #003366; border-color: #003366 !important;">
                    <i class="bi bi-check-circle-fill me-1"></i> 3. Confirmation
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0" style="border: 1px solid #C8E6C9 !important; border-radius: 12px; overflow: hidden;">
        <div class="card-header py-3 fw-bold" style="background-color: #E8F5E9; color: #2E7D32; border-bottom: 2px solid #C8E6C9;">
            <h4 class="mb-0 fs-5"><i class="bi bi-check-circle-fill me-2"></i> Booking Confirmed!</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert shadow-sm border-0" style="background-color: #F1F8E9; border-left: 5px solid #81C784; color: #335933; border-radius: 8px;">
                        <h6 class="fw-bold mb-1"><i class="bi bi-envelope-check-fill me-2"></i>Thank you for your booking!</h6>
                        <p class="mb-0 small">Your e-ticket has been sent to <strong><?php echo e($booking->client->email); ?></strong>. Please check your inbox and spam folder.</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Booking Details</h6>
                            <p><strong>Booking Code:</strong> <?php echo e($booking->booking_code); ?></p>
                            <p><strong>Booking Date:</strong> <?php echo e($booking->created_at->format('d M Y H:i')); ?></p>
                            <p class="mb-2"><strong>Status:</strong> <span class="badge" style="background-color: #E8F5E9; color: #2E7D32; border: 1px solid #C8E6C9;">Confirmed</span></p>
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
                        $exchangeRate = config('app.usd_to_idr', 15500);
                        $seatSubtotal = 0;
                        $baggageTotal = 0;
                        $mealTotal = 0;
                        $insuranceTotal = 0;
                    ?>
                    <table class="table table-sm" style="font-size: 13px;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Passport</th>
                                <th>Seat & Add-ons</th>
                                <th class="text-end">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $booking->bookingSeats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $seatSubtotal += $seat->price_at_booking;
                                $baggageTotal += $seat->baggage_price ?? 0;
                                $mealTotal += $seat->meal_price ?? 0;
                                $insuranceTotal += $seat->insurance_price ?? 0;
                            ?>
                            <tr>
                                <td><?php echo e($seat->passenger_first_name); ?> <?php echo e($seat->passenger_last_name); ?></td>
                                <td><?php echo e($seat->passenger_passport); ?></td>
                                <td>
                                    <div>
                                        <strong><?php echo e($seat->seat->seat_number ?? 'N/A'); ?></strong>
                                        <?php if($seat->is_vip_seat_selection): ?>
                                            <span class="badge bg-warning text-dark small ms-1"><i class="bi bi-star-fill"></i> VIP</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($seat->meal_id): ?>
                                    <div class="small text-muted"><i class="bi bi-cup-hot"></i> <?php echo e($seat->meal->name ?? 'Meal'); ?></div>
                                    <?php endif; ?>
                                    <?php if($seat->baggage_weight > 0): ?>
                                    <div class="small text-muted"><i class="bi bi-suitcase"></i> <?php echo e($seat->baggage_weight); ?> kg</div>
                                    <?php endif; ?>
                                    <?php if($seat->has_insurance): ?>
                                    <div class="small text-muted"><i class="bi bi-shield-check"></i> Travel Protection</div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div>Rp <?php echo e(number_format($seat->price_at_booking * $exchangeRate, 0, ',', '.')); ?></div>
                                    <?php if($seat->meal_price > 0): ?>
                                    <div class="small text-muted">+Rp <?php echo e(number_format($seat->meal_price * $exchangeRate, 0, ',', '.')); ?></div>
                                    <?php endif; ?>
                                    <?php if($seat->baggage_price > 0): ?>
                                    <div class="small text-muted">+Rp <?php echo e(number_format($seat->baggage_price * $exchangeRate, 0, ',', '.')); ?></div>
                                    <?php endif; ?>
                                    <?php if($seat->insurance_price > 0): ?>
                                    <div class="small text-muted">+Rp <?php echo e(number_format($seat->insurance_price * $exchangeRate, 0, ',', '.')); ?></div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <?php
                            $exchangeRate = config('app.usd_to_idr', 15000);
                            $subtotal = $seatSubtotal + $baggageTotal + $mealTotal + $insuranceTotal;
                            $taxAmount = $subtotal * 0.10;
                            $serviceFeeUsd = 5.00;
                            $serviceFeeIdr = $serviceFeeUsd * $exchangeRate;
                            
                            // Use stored grand total to ensure absolute consistency
                            $grandTotalIdr = $booking->total_price_usd * $exchangeRate;
                        ?>
                        <tfoot>
                            <tr class="text-muted" style="font-size: 12px;">
                                <td colspan="3" class="text-end border-0 py-1">Subtotal (Add-ons Incl.)</td>
                                <td class="text-end border-0 py-1">Rp <?php echo e(number_format($subtotal * $exchangeRate, 0, ',', '.')); ?></td>
                            </tr>
                            <tr class="text-muted" style="font-size: 12px;">
                                <td colspan="3" class="text-end border-0 py-1"><i class="bi bi-receipt" style="font-size: 10px;"></i> Tax (10%)</td>
                                <td class="text-end border-0 py-1">Rp <?php echo e(number_format($taxAmount * $exchangeRate, 0, ',', '.')); ?></td>
                            </tr>
                            <tr class="text-muted" style="font-size: 12px;">
                                <td colspan="3" class="text-end border-0 py-1"><i class="bi bi-gear" style="font-size: 10px;"></i> Service Fee</td>
                                <td class="text-end border-0 py-1">Rp <?php echo e(number_format($serviceFeeIdr, 0, ',', '.')); ?></td>
                            </tr>
                            <tr style="border-top: 2px solid #dee2e6;">
                                <th colspan="3" class="text-end py-2">Total Paid</th>
                                <th class="text-end py-2" style="color: #0066CC; font-size: 15px;">Rp <?php echo e(number_format($grandTotalIdr, 0, ',', '.')); ?></th>
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