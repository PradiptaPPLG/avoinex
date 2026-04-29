<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Booking Steps -->
            <div class="mb-4 position-relative">
                <div class="progress" style="height: 3px; position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); z-index: 1; background-color: rgba(39, 158, 214, 0.2);">
                    <div class="progress-bar" role="progressbar" style="width: 50%; background-color: #279ED6;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                    <div class="text-center" style="width: 32%;">
                        <div class="rounded-pill py-2 border border-2 shadow-sm" style="background-color: #BDE3FF; border-color: #BDE3FF !important; color: #003366;">
                            <i class="bi bi-check-circle-fill me-1"></i> 1. Passenger Details
                        </div>
                    </div>
                    <div class="text-center" style="width: 32%;">
                        <div class="text-white rounded-pill py-2 border border-2 shadow-sm" style="background-color: #003366; border-color: #003366 !important;">
                            <i class="bi bi-credit-card-fill me-1"></i> 2. Payment
                        </div>
                    </div>
                    <div class="text-center" style="width: 32%;">
                        <div class="bg-light text-muted rounded-pill py-2 border border-2 shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> 3. Confirmation
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Payment Method</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('payment.process')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="booking_id" value="<?php echo e($booking->booking_id); ?>">
                        
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Select Payment Method</h6>
                            
                            <!-- E-Wallet -->
                            <div class="mb-3">
                                <label class="text-muted small fw-bold text-uppercase tracking-wide mb-2"><i class="bi bi-wallet2 me-1"></i> E-Wallet</label>
                                <div class="row g-2">
                                    <div class="col-6 col-md-3">
                                        <input type="radio" name="payment_method" id="gopay" value="ewallet_gopay" class="payment-radio">
                                        <label class="payment-card" for="gopay">
                                            <div class="payment-icon" style="color: #00AED6; font-weight: 800; font-size: 14px;">gopay</div>
                                        </label>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <input type="radio" name="payment_method" id="ovo" value="ewallet_ovo" class="payment-radio">
                                        <label class="payment-card" for="ovo">
                                            <div class="payment-icon" style="color: #4C2A86; font-weight: 800; font-size: 14px;">OVO</div>
                                        </label>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <input type="radio" name="payment_method" id="dana" value="ewallet_dana" class="payment-radio">
                                        <label class="payment-card" for="dana">
                                            <div class="payment-icon" style="color: #118EE9; font-weight: 800; font-size: 14px;">DANA</div>
                                        </label>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <input type="radio" name="payment_method" id="shopeepay" value="ewallet_shopeepay" class="payment-radio">
                                        <label class="payment-card" for="shopeepay">
                                            <div class="payment-icon" style="color: #EE4D2D; font-weight: 800; font-size: 12px;">ShopeePay</div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Virtual Account -->
                            <div class="mb-3">
                                <label class="text-muted small fw-bold text-uppercase tracking-wide mb-2"><i class="bi bi-bank me-1"></i> Virtual Account</label>
                                <div class="row g-2">
                                    <div class="col-6 col-md-4">
                                        <input type="radio" name="payment_method" id="bca" value="va_bca" class="payment-radio">
                                        <label class="payment-card" for="bca">
                                            <div class="payment-icon" style="color: #0066AE; font-weight: 800; font-size: 14px;">BCA</div>
                                        </label>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <input type="radio" name="payment_method" id="mandiri" value="va_mandiri" class="payment-radio">
                                        <label class="payment-card" for="mandiri">
                                            <div class="payment-icon" style="color: #F7A600; font-weight: 800; font-size: 14px;">MANDIRI</div>
                                        </label>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <input type="radio" name="payment_method" id="bni" value="va_bni" class="payment-radio">
                                        <label class="payment-card" for="bni">
                                            <div class="payment-icon" style="color: #005E6A; font-weight: 800; font-size: 14px;">BNI</div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Credit Card -->
                            <div class="mb-3">
                                <label class="text-muted small fw-bold text-uppercase tracking-wide mb-2"><i class="bi bi-credit-card me-1"></i> Credit / Debit Card</label>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="radio" name="payment_method" id="credit_card" value="credit_card" class="payment-radio" checked>
                                        <label class="payment-card d-flex justify-content-between align-items-center" for="credit_card">
                                            <div class="fw-bold text-dark"><i class="bi bi-credit-card-2-front text-primary me-2"></i> Visa / Mastercard / JCB</div>
                                            <div class="d-flex gap-1 opacity-75">
                                                <i class="bi bi-cc-visa fs-4 text-primary"></i>
                                                <i class="bi bi-cc-mastercard fs-4 text-danger"></i>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Simulasi kartu kredit -->
                        <div id="credit-card-form">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" class="form-control" placeholder="1234 5678 9012 3456" value="4111111111111111">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control" placeholder="MM/YY" value="12/30">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">CVV</label>
                                    <input type="text" class="form-control" placeholder="123" value="123">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Cardholder Name</label>
                                    <input type="text" class="form-control" value="<?php echo e($booking->client->first_name); ?> <?php echo e($booking->client->last_name); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> This is a demo payment. No real transaction will be processed.
                        </div>

                        <?php if(!session('client_logged_in')): ?>
                        <div class="alert alert-warning mb-4 shadow-sm border-warning" style="background-color: #fff3cd;">
                            <h6 class="alert-heading fw-bold text-dark"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Guest Alert</h6>
                            <p class="mb-0 text-dark small">
                                Anda melakukan pemesanan sebagai Tamu (Guest). Harap simpan atau catat Nomor Booking dan Nama Pemesan Anda, karena Anda tidak dapat melihat riwayat pesanan setelah halaman ini ditutup.
                            </p>
                        </div>
                        <?php endif; ?>

                        <?php $exchangeRate = config('app.usd_to_idr', 15000); ?>
                        <button type="submit" class="btn btn-lg w-100 fw-bold border-0" style="background-color: #FFCB2A; color: #000;">
                            <i class="bi bi-lock me-2"></i> Pay Now Rp <?php echo e(number_format($booking->total_price_usd * $exchangeRate, 0, ',', '.')); ?>

                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 88px; z-index: 10;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-receipt-cutoff me-2"></i>Order Summary</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-1">Booking #<?php echo e($booking->booking_code ?? 'PENDING'); ?></h6>
                    <p class="mb-1"><strong><?php echo e($booking->flightInstance->schedule->flight_number); ?></strong></p>
                    <p class="mb-1"><?php echo e($booking->flightInstance->schedule->originAirport->city); ?> → 
                        <?php echo e($booking->flightInstance->schedule->destinationAirport->city); ?></p>
                    <p class="mb-3"><?php echo e($booking->flightInstance->flight_date->format('d M Y')); ?></p>
                    
                    <h6 style="font-weight: 700; font-size: 13px; margin-bottom: 10px;">Passengers & Seats</h6>
                    <?php
                        $exchangeRate = config('app.usd_to_idr', 15000);
                        $seatSubtotal = 0;
                        $baggageTotal = 0;
                        $mealTotal = 0;
                        $insuranceTotal = 0;
                    ?>
                    <table class="table table-sm mb-0" style="font-size: 13px;">
                        <tbody>
                            <?php $__currentLoopData = $booking->bookingSeats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                                $seatSubtotal += $seat->price_at_booking;
                                $baggageTotal += $seat->baggage_price ?? 0;
                                $mealTotal += $seat->meal_price ?? 0;
                                // Assuming insurance is $3.00 if present or handled similarly
                                $insuranceTotal += $seat->insurance_price ?? 0;
                            ?>
                            <tr style="border-bottom: 1px solid #f0f2f5;">
                                <td class="border-0 py-2">
                                    <div class="fw-bold text-dark">
                                        <i class="bi bi-person-fill text-primary" style="font-size: 11px;"></i>
                                        <?php echo e($seat->passenger_first_name); ?> <?php echo e($seat->passenger_last_name); ?>

                                    </div>
                                    <div class="text-muted small" style="margin-left: 16px;">
                                        Seat <?php echo e($seat->seat->seat_number ?? '-'); ?>

                                    </div>
                                    <?php if($seat->meal): ?>
                                    <div class="text-muted small" style="margin-left: 16px;">
                                        <i class="bi bi-cup-hot" style="font-size: 10px;"></i> <?php echo e($seat->meal->name); ?>

                                    </div>
                                    <?php endif; ?>
                                    <?php if($seat->has_insurance): ?>
                                    <div class="text-muted small" style="margin-left: 16px;">
                                        <i class="bi bi-shield-check" style="font-size: 10px;"></i> Travel Insurance
                                    </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end border-0 py-2 align-top">
                                    <div class="fw-bold">Rp <?php echo e(number_format($seat->price_at_booking * $exchangeRate, 0, ',', '.')); ?></div>
                                    <?php if($seat->meal_price > 0): ?>
                                    <div class="text-muted small">+Rp <?php echo e(number_format($seat->meal_price * $exchangeRate, 0, ',', '.')); ?></div>
                                    <?php endif; ?>
                                    <?php if($seat->insurance_price > 0): ?>
                                    <div class="text-muted small">+Rp <?php echo e(number_format($seat->insurance_price * $exchangeRate, 0, ',', '.')); ?></div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if($seat->baggage_price > 0): ?>
                            <tr>
                                <td class="border-0 py-1 text-muted" style="font-size: 11px; padding-left: 16px !important;">
                                    <i class="bi bi-suitcase" style="font-size: 10px;"></i> Baggage <?php echo e($seat->baggage_weight); ?>kg
                                </td>
                                <td class="text-end border-0 py-1 text-muted" style="font-size: 11px;">+Rp <?php echo e(number_format($seat->baggage_price * $exchangeRate, 0, ',', '.')); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        
                        <!-- Fee Breakdown -->
                        <?php
                            $subtotal = $seatSubtotal + $baggageTotal + $mealTotal + $insuranceTotal;
                            $taxAmount = $subtotal * 0.10;
                            $serviceFeeUsd = 5.00;
                            $serviceFeeIdr = $serviceFeeUsd * $exchangeRate;
                            
                            // Use stored grand total to ensure identity with button
                            $grandTotalIdr = $booking->total_price_usd * $exchangeRate;
                        ?>
                        <tbody id="payment-fee-breakdown">
                            <tr>
                                <td class="py-1 text-muted" style="font-size: 12px; border-top: 1px dashed #dee2e6;">
                                    <i class="bi bi-receipt" style="font-size: 10px;"></i> Tax (10%)
                                </td>
                                <td class="text-end py-1 text-muted" style="font-size: 12px; border-top: 1px dashed #dee2e6;">
                                    Rp <?php echo e(number_format($taxAmount * $exchangeRate, 0, ',', '.')); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="border-0 py-1 text-muted" style="font-size: 12px;">
                                    <i class="bi bi-gear" style="font-size: 10px;"></i> Service Fee
                                </td>
                                <td class="text-end border-0 py-1 text-muted" style="font-size: 12px;">
                                    Rp <?php echo e(number_format($serviceFeeIdr, 0, ',', '.')); ?>

                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="border-top: 2px solid #dee2e6;">
                                <th class="py-2" style="font-size: 15px;">Total</th>
                                <th class="text-end py-2" style="font-size: 15px; color: #0066CC;">
                                    Rp <?php echo e(number_format($grandTotalIdr, 0, ',', '.')); ?>

                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="mt-2 p-2 rounded" style="background: rgba(39,158,214,0.06); font-size: 11px; color: #5A6B82;">
                        <i class="bi bi-info-circle"></i> Harga sudah termasuk pajak dan biaya layanan.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tampilkan form sesuai payment method
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('credit-card-form').style.display = 
            this.value === 'credit_card' ? 'block' : 'none';
    });
});
</script>

<style>
.tracking-wide {
    letter-spacing: 0.05em;
}
.payment-radio {
    display: none;
}
.payment-card {
    border: 2px solid #eaedf1;
    border-radius: 12px;
    padding: 12px 16px;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    background: #fff;
    display: block;
    width: 100%;
    margin-bottom: 0;
}
.payment-card:hover {
    border-color: #bbdefb;
    background-color: #f8fbfe;
}
.payment-icon {
    text-align: center;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.payment-radio:checked + .payment-card {
    border-color: #279ED6;
    background-color: #eef7fc;
    box-shadow: 0 4px 12px rgba(39,158,214,0.15);
}
.payment-radio:checked + .payment-card .payment-icon {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/payment/page.blade.php ENDPATH**/ ?>