<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Booking Steps -->
            <div class="mb-4 position-relative">
                <div class="progress" style="height: 3px; position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); z-index: 1;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                    <div class="text-center" style="width: 32%;">
                        <div class="bg-primary text-white rounded-pill py-2 border border-2 border-primary fw-bold shadow-sm">
                            <i class="bi bi-person-lines-fill me-1"></i> 1. Passenger Details
                        </div>
                    </div>
                    <div class="text-center" style="width: 32%;">
                        <div class="bg-light text-muted rounded-pill py-2 border border-2 shadow-sm">
                            <i class="bi bi-credit-card me-1"></i> 2. Payment
                        </div>
                    </div>
                    <div class="text-center" style="width: 32%;">
                        <div class="bg-light text-muted rounded-pill py-2 border border-2 shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> 3. Confirmation
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passenger Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Passenger Details</h5>
                </div>
                <div class="card-body">
                    <!-- Display Errors -->
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Please fix the following issues:
                            <ul class="mb-0 mt-2">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form id="bookingForm" action="<?php echo e(route('booking.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Data Pemesan -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Data Pemesan</h5>
                            
                            <div class="alert alert-warning d-flex align-items-start p-3 mb-3" style="background-color: #fffde7; border-color: #ffe082; border-left: 4px solid #ffc107; border-radius: 8px;">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-2 mt-1" style="font-size: 1.2rem;"></i>
                                <div style="color: #424242; font-size: 0.95rem;">
                                    <strong style="color: #666;">Penting</strong><br>
                                    Orang di bawah ini yang akan menerima e-tiket, dan akan menjadi kontak untuk permintaan refund atau reschedule.
                                </div>
                            </div>
                            
                            <div class="card shadow-sm border-light mb-4 rounded-3">
                                <div class="card-body p-4">
                                    <div class="row mb-3 gx-4">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label class="form-label text-muted small mb-0">Nama Depan *</label>
                                            <input type="text" class="form-control border-top-0 border-end-0 border-start-0 rounded-0 shadow-none px-0" name="contact_first_name" required style="border-bottom: 1.5px solid #e0e0e0; transition: border-color 0.2s;" onfocus="this.style.borderColor='#279ED6'" onblur="this.style.borderColor='#e0e0e0'">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small mb-0">Nama Belakang *</label>
                                            <input type="text" class="form-control border-top-0 border-end-0 border-start-0 rounded-0 shadow-none px-0" name="contact_last_name" required style="border-bottom: 1.5px solid #e0e0e0; transition: border-color 0.2s;" onfocus="this.style.borderColor='#279ED6'" onblur="this.style.borderColor='#e0e0e0'">
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4 gx-4">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <label class="form-label text-muted small mb-0">Kode Negara</label>
                                            <select class="form-select border-top-0 border-end-0 border-start-0 rounded-0 shadow-none px-0" name="contact_country" style="border-bottom: 1.5px solid #e0e0e0; cursor: pointer;">
                                                <option value="ID">+62 (Indonesia)</option>
                                                <option value="SG">+65 (Singapura)</option>
                                                <option value="MY">+60 (Malaysia)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label text-muted small mb-0">No. Handphone *</label>
                                            <input type="tel" class="form-control border-top-0 border-end-0 border-start-0 rounded-0 shadow-none px-0" name="contact_phone" required style="border-bottom: 1.5px solid #e0e0e0; transition: border-color 0.2s;" onfocus="this.style.borderColor='#279ED6'" onblur="this.style.borderColor='#e0e0e0'">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label small mb-0" style="color: #279ED6; font-weight: 500;">Email *</label>
                                            <input type="email" class="form-control border-top-0 border-end-0 border-start-0 rounded-0 shadow-none px-0" name="contact_email" placeholder="Contoh: email@example.com" required style="border-bottom: 1.5px solid #279ED6;">
                                            <small class="text-muted d-block mt-2"><i class="bi bi-info-circle me-1"></i>E-tiket akan dikirim kepada alamat email ini.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Passenger List -->
                        <h6 class="border-bottom pb-2">Passenger List</h6>
                        <div id="passengers-container">
                            <?php if(!empty($selectedSeats)): ?>
                                <?php $__currentLoopData = $selectedSeats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="passenger-form border rounded p-3 mb-3">
                                    <h6>Passenger <?php echo e($index + 1); ?> - Seat <?php echo e($seat['number'] ?? 'N/A'); ?> (<?php echo e($seat['class'] ?? 'economy'); ?>)</h6>
                                    <input type="hidden" name="seat_ids[]" value="<?php echo e($seat['id'] ?? ''); ?>">
                                    <input type="hidden" name="seat_numbers[]" value="<?php echo e($seat['number'] ?? ''); ?>">
                                    <input type="hidden" name="seat_prices[]" value="<?php echo e($seat['price'] ?? 150); ?>">
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">First Name *</label>
                                            <input type="text" class="form-control" name="passenger_first_name[]" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Last Name *</label>
                                            <input type="text" class="form-control" name="passenger_last_name[]" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Passport Number *</label>
                                            <input type="text" class="form-control" name="passenger_passport[]" required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" name="passenger_dob[]">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Special Requests</label>
                                            <input type="text" class="form-control" name="special_requests[]" placeholder="e.g., Wheelchair assistance">
                                        </div>
                                    </div>

                                    <!-- Checked Baggage Section -->
                                    <hr class="mt-4 mb-3">
                                    <h6>Checked Baggage</h6>
                                    <input type="hidden" name="baggage_weights[]" value="0" class="baggage-weight-input">
                                    <input type="hidden" name="baggage_prices[]" value="0" class="baggage-price-input">
                                    
                                    <div class="row g-2 mt-2 baggage-options" data-passenger-index="<?php echo e($index); ?>">
                                        <?php
                                            $baggageOptions = [
                                                ['weight' => 0, 'price' => 0, 'label' => 'No Extra', 'sub' => 'Included'],
                                                ['weight' => 20, 'price' => 20, 'label' => '20 kg', 'sub' => '+Rp ' . number_format(20, 0, ',', '.')],
                                                ['weight' => 25, 'price' => 25, 'label' => '25 kg', 'sub' => '+Rp ' . number_format(25, 0, ',', '.')],
                                                ['weight' => 30, 'price' => 30, 'label' => '30 kg', 'sub' => '+Rp ' . number_format(30, 0, ',', '.')],
                                                ['weight' => 40, 'price' => 40, 'label' => '40 kg', 'sub' => '+Rp ' . number_format(40, 0, ',', '.')],
                                                ['weight' => 50, 'price' => 50, 'label' => '50 kg', 'sub' => '+Rp ' . number_format(50, 0, ',', '.')],
                                                ['weight' => 60, 'price' => 60, 'label' => '60 kg', 'sub' => '+Rp ' . number_format(60, 0, ',', '.')],
                                            ];
                                        ?>
                                        <?php $__currentLoopData = $baggageOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bgIdx => $bg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-6 col-md-3">
                                            <input type="radio" class="btn-check baggage-radio" name="baggage_selection_<?php echo e($index); ?>" id="baggage_<?php echo e($index); ?>_<?php echo e($bg['weight']); ?>" value="<?php echo e($bg['weight']); ?>" data-price="<?php echo e($bg['price']); ?>" autocomplete="off" <?php echo e($bg['weight'] == 0 ? 'checked' : ''); ?>>
                                            <label class="btn btn-outline-primary w-100 text-start p-2 rounded-3 h-100" for="baggage_<?php echo e($index); ?>_<?php echo e($bg['weight']); ?>">
                                                <div class="fw-bold"><?php echo e($bg['label']); ?></div>
                                                <div class="small"><?php echo e($bg['sub']); ?></div>
                                            </label>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i> No seat data available. Please go back and select seats.
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Proceed to Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 90px; z-index: 10;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <!-- Flight Info -->
                    <div class="mb-3">
                        <h6>Flight Details</h6>
                        <p class="mb-1"><strong><?php echo e($flight->schedule->flight_number ?? 'GA-201'); ?></strong></p>
                        <p class="mb-1"><?php echo e($flight->schedule->originAirport->city ?? 'Jakarta'); ?> (<?php echo e($flight->schedule->originAirport->iata_code ?? 'CGK'); ?>) 
                            → <?php echo e($flight->schedule->destinationAirport->city ?? 'Denpasar'); ?> (<?php echo e($flight->schedule->destinationAirport->iata_code ?? 'DPS'); ?>)</p>
                        <p class="mb-1"><?php echo e($flight->flight_date->format('d M Y') ?? '1 Feb 2026'); ?>, 
                            <?php echo e(date('H:i', strtotime($flight->schedule->departure_time_gmt ?? '08:00'))); ?> - 
                            <?php echo e(date('H:i', strtotime($flight->schedule->arrival_time_gmt ?? '10:30'))); ?></p>
                    </div>

                    <!-- Selected Seats -->
                    <div class="mb-3">
                        <h6>Selected Seats</h6>
                        <div id="summary-seats">
                            <?php if(!empty($selectedSeats)): ?>
                                <?php $__currentLoopData = $selectedSeats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-secondary me-1 mb-1"><?php echo e($seat['number'] ?? 'N/A'); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <p class="text-muted small">No seats selected</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div>
                        <h6 class="mb-2" style="font-weight: 700; font-size: 14px;">Price Breakdown</h6>
                        <table class="table table-sm mb-0" style="font-size: 13px;">
                            <tbody id="summary-prices">
                                <?php
                                    $seatSubtotal = 0;
                                ?>
                                <?php if(!empty($selectedSeats)): ?>
                                    <?php $__currentLoopData = $selectedSeats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $seatSubtotal += floatval($seat['price'] ?? 150); ?>
                                    <tr>
                                        <td class="border-0 py-1">
                                            <i class="bi bi-person-fill text-muted" style="font-size: 11px;"></i>
                                            Seat <?php echo e($seat['number'] ?? 'N/A'); ?> 
                                            <span class="text-muted">(<?php echo e(ucfirst($seat['class'] ?? 'economy')); ?>)</span>
                                        </td>
                                        <td class="text-end border-0 py-1">Rp <?php echo e(number_format($seat['price'] ?? 150, 0, ',', '.')); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <!-- Fee breakdown -->
                            <tbody id="summary-fees">
                                <?php
                                    $taxRate = 0.10;
                                    $serviceFee = 5.00;
                                    $taxAmount = $seatSubtotal * $taxRate;
                                    $baseTotal = $seatSubtotal + $taxAmount + $serviceFee;
                                ?>
                                <tr>
                                    <td class="border-0 py-1 text-muted" style="font-size: 12px;">
                                        <i class="bi bi-receipt" style="font-size: 10px;"></i> Tax (10%)
                                    </td>
                                    <td class="text-end border-0 py-1 text-muted" style="font-size: 12px;" id="summary-tax">
                                        Rp <?php echo e(number_format($taxAmount, 0, ',', '.')); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0 py-1 text-muted" style="font-size: 12px;">
                                        <i class="bi bi-gear" style="font-size: 10px;"></i> Service Fee
                                    </td>
                                    <td class="text-end border-0 py-1 text-muted" style="font-size: 12px;">
                                        Rp <?php echo e(number_format($serviceFee, 0, ',', '.')); ?>

                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr style="border-top: 2px solid #dee2e6;">
                                    <th class="py-2" style="font-size: 14px;">Total</th>
                                    <th class="text-end py-2" id="summary-grand-total" style="font-size: 14px; color: #0066CC;">
                                        Rp <?php echo e(number_format($baseTotal, 0, ',', '.')); ?>

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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Booking form loaded');
    console.log('Form action:', document.getElementById('bookingForm').action);
    console.log('Form method:', document.getElementById('bookingForm').method);

    // Check if we have seat data
    const seatIds = document.querySelectorAll('input[name="seat_ids[]"]');
    console.log('Number of seats:', seatIds.length);

    // Get form and button
    const form = document.getElementById('bookingForm');
    const submitBtn = form.querySelector('button[type="submit"]');

    // Simple form validation
    form.addEventListener('submit', function(e) {
        console.log('🚀 Form submit triggered!');
        console.log('Form is valid:', form.checkValidity());

        if (!form.checkValidity()) {
            console.log('❌ Form has HTML5 validation errors');
            return true;
        }

        const firstName = document.querySelector('input[name="contact_first_name"]');
        const lastName = document.querySelector('input[name="contact_last_name"]');
        const email = document.querySelector('input[name="contact_email"]');

        console.log('Contact info:', {
            firstName: firstName?.value,
            lastName: lastName?.value,
            email: email?.value
        });

        if (!firstName?.value || !lastName?.value || !email?.value) {
            e.preventDefault();
            alert('Please fill in all required contact fields');
            console.log('❌ Validation failed - missing contact info');
            return false;
        }

        const passengerFirstNames = document.querySelectorAll('input[name="passenger_first_name[]"]');
        const passengerLastNames = document.querySelectorAll('input[name="passenger_last_name[]"]');
        const passengerPassports = document.querySelectorAll('input[name="passenger_passport[]"]');

        let allPassengersFilled = true;
        let missingFields = [];

        passengerFirstNames.forEach((input, index) => {
            if (!input.value) {
                allPassengersFilled = false;
                missingFields.push(`Passenger ${index + 1} first name`);
            }
        });

        passengerLastNames.forEach((input, index) => {
            if (!input.value) {
                allPassengersFilled = false;
                missingFields.push(`Passenger ${index + 1} last name`);
            }
        });

        passengerPassports.forEach((input, index) => {
            if (!input.value) {
                allPassengersFilled = false;
                missingFields.push(`Passenger ${index + 1} passport`);
            }
        });

        if (!allPassengersFilled) {
            e.preventDefault();
            alert('Missing required fields:\n' + missingFields.join('\n'));
            console.log('❌ Validation failed - missing fields:', missingFields);
            return false;
        }

        const seatIds = document.querySelectorAll('input[name="seat_ids[]"]');
        if (seatIds.length === 0) {
            e.preventDefault();
            alert('No seat data found. Please go back and select seats.');
            console.log('❌ No seat data');
            return false;
        }

        if (submitBtn) {
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing Booking...';
            submitBtn.disabled = true;
        }

        console.log('✅ Form validation passed, submitting...');
        return true;
    });

    // --- Baggage Selection & Price Breakdown ---
    const seatSubtotal = <?php echo e($seatSubtotal ?? 0); ?>;
    const TAX_RATE = 0.10;
    const SERVICE_FEE = 5.00;
    const baggageTotals = {};
    const summaryPrices = document.getElementById('summary-prices');
    const summaryTax = document.getElementById('summary-tax');
    const summaryGrandTotal = document.getElementById('summary-grand-total');

    document.querySelectorAll('.baggage-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const container = this.closest('.baggage-options');
                const passengerIndex = container.dataset.passengerIndex;
                const price = parseFloat(this.dataset.price);
                const weight = this.value;

                const formContainer = this.closest('.passenger-form');
                formContainer.querySelector('.baggage-weight-input').value = weight;
                formContainer.querySelector('.baggage-price-input').value = price;

                baggageTotals[passengerIndex] = { weight, price };
                updateSummary();
            }
        });
    });

    function updateSummary() {
        document.querySelectorAll('.baggage-summary-row').forEach(el => el.remove());

        let totalBaggageCost = 0;

        Object.keys(baggageTotals).forEach(index => {
            const item = baggageTotals[index];
            if (item.price > 0) {
                totalBaggageCost += item.price;
                
                const tr = document.createElement('tr');
                tr.className = 'baggage-summary-row';
                tr.innerHTML = `
                    <td class="border-0 py-1"><small class="text-muted"><i class="bi bi-suitcase" style="font-size:10px;"></i> Pass ${parseInt(index) + 1} Baggage (${item.weight}kg)</small></td>
                    <td class="text-end border-0 py-1"><small class="text-muted">+Rp ${item.price.toLocaleString('id-ID')}</small></td>
                `;
                summaryPrices.appendChild(tr);
            }
        });

        // Recalculate with tax
        const subtotalWithBaggage = seatSubtotal + totalBaggageCost;
        const tax = subtotalWithBaggage * TAX_RATE;
        const grandTotal = subtotalWithBaggage + tax + SERVICE_FEE;

        if (summaryTax) summaryTax.textContent = 'Rp ' + tax.toLocaleString('id-ID');
        if (summaryGrandTotal) summaryGrandTotal.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/booking/form.blade.php ENDPATH**/ ?>