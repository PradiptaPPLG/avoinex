<?php $__env->startSection('content'); ?>
<?php
    $config = $aircraftConfig ?? [
        'seat_columns' => 6,
        'seat_rows' => 30,
        'business_rows' => 2,
        'preferred_zone_enabled' => false,
        'preferred_zone_start_row' => null,
        'preferred_zone_end_row' => null,
        'seat_letters' => ['A','B','C','D','E','F'],
    ];
    $seatLetters = $config['seat_letters'];
    $halfCols = (int) ceil(count($seatLetters) / 2);
    $leftLetters = array_slice($seatLetters, 0, $halfCols);
    $rightLetters = array_slice($seatLetters, $halfCols);
    $businessRows = $config['business_rows'];
    $prefEnabled = $config['preferred_zone_enabled'];
    $prefStart = $config['preferred_zone_start_row'] ?? ($businessRows + 1);
    $prefEnd = $config['preferred_zone_end_row'] ?? ($businessRows + 3);
    $totalRows = $config['seat_rows'];
    $econStart = $businessRows + 1;
?>
<div class="container mt-4">
    <!-- Flight Info -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <?php if(isset($flight->schedule->airline->logo_path) && $flight->schedule->airline->logo_path): ?>
                            <div class="airline-logo rounded-circle shadow-sm overflow-hidden me-3" style="width: 50px; height: 50px; border: 1px solid #dee2e6; background: #fff; display: flex; align-items: center; justify-content: center;">
                                <img src="<?php echo e(asset('logo_maskapai/' . $flight->schedule->airline->logo_path)); ?>" alt="Airline Logo" style="width: 100%; height: 100%; object-fit: contain; padding: 2px;">
                            </div>
                        <?php else: ?>
                            <div class="airline-logo bg-primary text-white rounded-circle shadow-sm me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-weight: bold; font-size: 1.1rem;">
                                <?php echo e($flight->airline_code ?? 'GA'); ?>

                            </div>
                        <?php endif; ?>
                        <div>
                            <span class="text-muted fw-bold d-block" style="font-size: 0.85rem;"><?php echo e($flight->airline_name ?? 'Airline'); ?></span>
                            <h5 class="text-primary mb-0 mt-1" style="font-weight: 700;"><?php echo e($flight->schedule->flight_number); ?></h5>
                        </div>
                    </div>
                    <p class="mb-0 mt-2">
                        <strong><?php echo e($flight->schedule->originAirport->city); ?> (<?php echo e($flight->schedule->originAirport->iata_code); ?>)</strong>
                        →
                        <strong><?php echo e($flight->schedule->destinationAirport->city); ?> (<?php echo e($flight->schedule->destinationAirport->iata_code); ?>)</strong>
                    </p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><strong>Date:</strong> <?php echo e($flight->flight_date->format('d M Y')); ?></p>
                    <p class="mb-1"><strong>Departure:</strong> <?php echo e(date('H:i', strtotime($flight->schedule->departure_time_gmt))); ?></p>
                    <p class="mb-1"><strong>Arrival:</strong> <?php echo e(date('H:i', strtotime($flight->schedule->arrival_time_gmt))); ?></p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><strong>Aircraft:</strong> <?php echo e($flight->aircraftInstance->aircraft->aircraft_model); ?></p>
                    <p class="mb-1"><strong>Duration:</strong> <?php echo e(floor($flight->schedule->duration_minutes/60)); ?>h <?php echo e($flight->schedule->duration_minutes%60); ?>m</p>
                </div>
                <div class="col-md-2 text-end">
                    <span class="badge bg-primary fs-6"><?php echo e($flight->schedule->flight_number); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- PASSENGER SEAT REQUIREMENT BANNER -->
    <div class="card mb-4 border-info">
        <div class="card-body py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 text-info"><i class="bi bi-people-fill"></i> Seat Selection Requirement</h6>
                    <p class="mb-0">
                        Select exactly <strong><?php echo e($requiredSeats); ?></strong> seat<?php echo e($requiredSeats > 1 ? 's' : ''); ?> for
                        <strong><?php echo e($adults); ?></strong> Adult<?php echo e($adults > 1 ? 's' : ''); ?>

                        <?php if($children > 0): ?>
                            + <strong><?php echo e($children); ?></strong> Child<?php echo e($children > 1 ? 'ren' : ''); ?>

                        <?php endif; ?>
                        <?php if($infants > 0): ?>
                            <span class="text-muted">(+ <?php echo e($infants); ?> Infant<?php echo e($infants > 1 ? 's' : ''); ?>, no seat needed)</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="text-end">
                    <div class="seat-counter-badge">
                        <span id="seat-counter">0</span> / <?php echo e($requiredSeats); ?>

                    </div>
                    <small class="text-muted">seats selected</small>
                </div>
            </div>
        </div>
    </div>

    <!-- AIRCRAFT VISUALIZATION -->
    <div class="aircraft-container">
        <!-- FRONT PLANE IMAGE -->
        <div class="text-center mb-3">
            <img src="<?php echo e(asset('images/Avoinex_Plane_Front Plane.png')); ?>" 
                 alt="Aircraft Front" 
                 class="aircraft-front-img"
                 style="max-width: 220px; height: auto; display: block; margin: 0 auto;">
        </div>

        <!-- SEAT SELECTION INTERFACE -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Select Your Seats</h5>
            </div>
            <div class="card-body">
                <!-- LEGEND -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="legend d-flex flex-wrap gap-3 justify-content-center">
                            <?php if($businessRows > 0): ?>
                            <div class="d-flex align-items-center">
                                <div class="seat-legend business me-2"></div>
                                <span>Business Class</span>
                            </div>
                            <?php endif; ?>
                            <?php if($prefEnabled): ?>
                            <div class="d-flex align-items-center">
                                <div class="seat-legend preferred me-2"></div>
                                <span>Preferred (Extra Legroom)</span>
                            </div>
                            <?php endif; ?>
                            <div class="d-flex align-items-center">
                                <div class="seat-legend economy me-2"></div>
                                <span>Economy Class</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="seat-legend selected me-2"></div>
                                <span>Selected</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="seat-legend unavailable me-2"></div>
                                <span>Unavailable</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GALLEY SECTION -->
                <div class="galley-section mb-3 p-2 bg-secondary text-white rounded text-center">
                    <i class="bi bi-cup-hot"></i> FRONT GALLEY
                </div>

                
                
                
                <?php if($businessRows > 0): ?>
                <div class="business-section mb-5">
                    <h5 class="text-warning mb-3">
                        <i class="bi bi-star-fill"></i> Business Class
                        <small class="text-muted ms-2">Rows 1-<?php echo e($businessRows); ?></small>
                    </h5>
                    
                    <div class="seat-map">
                        <?php for($row = 1; $row <= $businessRows; $row++): ?>
                            <div class="seat-row d-flex justify-content-center align-items-center mb-2">
                                <div class="row-number me-2 fw-bold text-warning"><?php echo e($row); ?></div>
                                
                                
                                <?php $__currentLoopData = $leftLetters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatId = $seat ? $seat['seat_id'] : 'b_' . $row . $letter;
                                        $price = $seat ? $seat['price'] : 250.00;
                                    ?>
                                    <div class="seat m-1">
                                        <?php if($isAvailable): ?>
                                            <div class="seat-item" 
                                                 data-seat-id="<?php echo e($seatId); ?>"
                                                 data-seat-number="<?php echo e($seatNumber); ?>"
                                                 data-price="<?php echo e($price); ?>"
                                                 data-class="business">
                                                <div class="seat-number"><?php echo e($seatNumber); ?></div>
                                                <div class="seat-price">Rp <?php echo e(number_format($price, 0, ',', '.')); ?></div>
                                            </div>
                                        <?php else: ?>
                                            <div class="seat-unavailable">
                                                <?php echo e($seatNumber); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <!-- AISLE -->
                                <div class="aisle mx-3 d-flex align-items-center justify-content-center">
                                    <div class="aisle-line"></div>
                                </div>
                                
                                
                                <?php $__currentLoopData = $rightLetters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatId = $seat ? $seat['seat_id'] : 'b_' . $row . $letter;
                                        $price = $seat ? $seat['price'] : 250.00;
                                    ?>
                                    <div class="seat m-1">
                                        <?php if($isAvailable): ?>
                                            <div class="seat-item" 
                                                 data-seat-id="<?php echo e($seatId); ?>"
                                                 data-seat-number="<?php echo e($seatNumber); ?>"
                                                 data-price="<?php echo e($price); ?>"
                                                 data-class="business">
                                                <div class="seat-number"><?php echo e($seatNumber); ?></div>
                                                <div class="seat-price">Rp <?php echo e(number_format($price, 0, ',', '.')); ?></div>
                                            </div>
                                        <?php else: ?>
                                            <div class="seat-unavailable">
                                                <?php echo e($seatNumber); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <div class="row-number ms-2 fw-bold text-warning"><?php echo e($row); ?></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endif; ?>

                
                
                
                <div class="economy-section position-relative pb-4" id="economySectionWrap">
                    <!-- VIP PAYWALL OVERLAY -->
                    <div id="economyOverlay" class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center px-3" style="z-index: 10; background: rgba(255,255,255,0.85); backdrop-filter: blur(4px); top: 0; left: 0; border-radius: 12px;">
                        <div class="bg-white p-4 rounded-4 shadow border text-center" style="max-width: 450px;">
                            <div class="mb-3">
                                <i class="bi bi-lock-fill text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Economy Seat Selection</h4>
                            <p class="text-muted small mb-4">You can randomly be assigned a seat for free during check-in, or pay a VIP Selection Fee to pick your exact seat right now.</p>
                            
                            <div class="d-grid gap-3">
                                <button type="button" class="btn btn-outline-primary" id="btnRandomSeat">
                                    <i class="bi bi-shuffle me-2"></i> Random Assignment (Free)
                                </button>
                                <button type="button" class="btn btn-warning fw-bold text-dark" id="btnUnlockVip">
                                    <i class="bi bi-star-fill me-2"></i> Unlock Selection (+ Rp 150.000/seat)
                                </button>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-success mb-3 px-3">
                        <i class="bi bi-person-fill"></i> Main Cabin
                        <small class="text-muted ms-2">Rows <?php echo e($econStart); ?>-<?php echo e($totalRows); ?></small>
                    </h5>
                    
                    <div class="seat-map px-3">
                        <?php for($row = $econStart; $row <= $totalRows; $row++): ?>
                            <?php
                                $isPreferred = $prefEnabled && $row >= $prefStart && $row <= $prefEnd;
                            ?>

                            <?php if($isPreferred && $row == $prefStart): ?>
                            <div class="preferred-header text-center my-4 mx-auto p-3" style="max-width: 500px; background: rgba(0, 180, 216, 0.08); border-radius: 10px; border: 1px dashed #7ec8e3;">
                                <h6 class="mb-1 text-info fw-bold"><i class="bi bi-star"></i> PREFERRED ZONE STARTS</h6>
                                <small class="text-muted">+8cm legroom, priority boarding</small>
                            </div>
                            <?php endif; ?>

                            <?php if($row == $prefEnd + 1 && $prefEnabled): ?>
                            <div class="text-center my-3 mx-auto" style="max-width: 400px; border-bottom: 1px dashed #ced4da;">
                                <small class="text-muted">Standard Economy Starts</small>
                            </div>
                            <?php endif; ?>

                            <div class="seat-row d-flex justify-content-center align-items-center mb-2">
                                <div class="row-number me-2 fw-bold <?php echo e($isPreferred ? 'preferred-row-num' : ''); ?>"><?php echo e($row); ?></div>
                                
                                
                                <?php $__currentLoopData = $leftLetters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatClassAttr = $isPreferred ? 'preferred' : 'economy';
                                        $seatId = $seat ? $seat['seat_id'] : ($isPreferred ? 'p_' : 'e_') . $row . $letter;
                                        $price = $seat ? $seat['price'] : ($isPreferred ? 180.00 : 150.00);
                                        $seatItemClass = $isPreferred ? 'seat-item preferred-seat' : 'seat-item';
                                    ?>
                                    <div class="seat m-1">
                                        <?php if($isAvailable): ?>
                                            <div class="<?php echo e($seatItemClass); ?>" 
                                                 data-seat-id="<?php echo e($seatId); ?>"
                                                 data-seat-number="<?php echo e($seatNumber); ?>"
                                                 data-price="<?php echo e($price); ?>"
                                                 data-class="<?php echo e($seatClassAttr); ?>">
                                                <div class="seat-number"><?php echo e($seatNumber); ?></div>
                                                <div class="seat-price">Rp <?php echo e(number_format($price, 0, ',', '.')); ?></div>
                                                <?php if($isPreferred): ?>
                                                <div class="legroom-icon"><i class="bi bi-arrows-expand"></i></div>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="seat-unavailable">
                                                <?php echo e($seatNumber); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <!-- AISLE -->
                                <div class="aisle mx-3 d-flex align-items-center justify-content-center">
                                    <?php if($isPreferred): ?>
                                    <div class="aisle-preferred">
                                        <div class="aisle-preferred-line"></div>
                                        <div class="aisle-preferred-dot"></div>
                                    </div>
                                    <?php else: ?>
                                    <div class="aisle-line"></div>
                                    <?php endif; ?>
                                </div>
                                
                                
                                <?php $__currentLoopData = $rightLetters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatClassAttr = $isPreferred ? 'preferred' : 'economy';
                                        $seatId = $seat ? $seat['seat_id'] : ($isPreferred ? 'p_' : 'e_') . $row . $letter;
                                        $price = $seat ? $seat['price'] : ($isPreferred ? 180.00 : 150.00);
                                        $seatItemClass = $isPreferred ? 'seat-item preferred-seat' : 'seat-item';
                                    ?>
                                    <div class="seat m-1">
                                        <?php if($isAvailable): ?>
                                            <div class="<?php echo e($seatItemClass); ?>" 
                                                 data-seat-id="<?php echo e($seatId); ?>"
                                                 data-seat-number="<?php echo e($seatNumber); ?>"
                                                 data-price="<?php echo e($price); ?>"
                                                 data-class="<?php echo e($seatClassAttr); ?>">
                                                <div class="seat-number"><?php echo e($seatNumber); ?></div>
                                                <div class="seat-price">Rp <?php echo e(number_format($price, 0, ',', '.')); ?></div>
                                                <?php if($isPreferred): ?>
                                                <div class="legroom-icon"><i class="bi bi-arrows-expand"></i></div>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="seat-unavailable">
                                                <?php echo e($seatNumber); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <div class="row-number ms-2 fw-bold <?php echo e($isPreferred ? 'preferred-row-num' : ''); ?>"><?php echo e($row); ?></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- REAR FACILITIES -->
                <div class="rear-facilities mt-4 p-3 bg-light rounded">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="facility-box p-2 bg-secondary text-white rounded mb-2">
                                <i class="bi bi-cup-hot"></i> REAR GALLEY
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="facility-box p-2 bg-info text-white rounded mb-2">
                                <i class="bi bi-door-closed"></i> LAVATORY
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BACK PLANE IMAGE -->
        <div class="text-center mt-3">
            <img src="<?php echo e(asset('images/Avoinex_Plane_Back Plane.png')); ?>" 
                 alt="Aircraft Back" 
                 class="aircraft-back-img"
                 style="max-width: 200px; height: auto; display: block; margin: 0 auto;">
        </div>
    </div>

    <!-- SELECTED SEATS SUMMARY -->
    <div class="selected-seats-card card mt-4 shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-cart-check"></i> Selected Seats</h5>
        </div>
        <div class="card-body">
            <div id="selected-seats-list" class="mb-3">
                <div class="text-center text-muted py-3">
                    <i class="bi bi-emoji-frown display-4"></i>
                    <p class="mt-2">No seats selected yet</p>
                </div>
            </div>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4>Total: <span id="total-price" class="text-primary fw-bold">Rp 0</span></h4>
        <p class="text-muted mb-0"><small>Prices include all taxes and fees</small></p>
    </div>
    <div>
        <button class="btn btn-outline-danger me-2" id="clear-seats">
            <i class="bi bi-x-circle"></i> Clear All
        </button>
        
        <button type="button" class="btn btn-success btn-lg" id="continue-btn" disabled>
            <i class="bi bi-arrow-right"></i> Continue to Booking
        </button>
    </div>
</div>

<form id="hidden-form" method="POST" action="<?php echo e(route('flight.book', ['id' => $flight->flight_instance_id])); ?>" style="display: none;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="selected_seats" id="selected-seats-hidden" value="">
    <input type="hidden" name="total_price" id="total-price-hidden" value="0">
</form>
        </div>
    </div>
</div>

<style>
/* CUSTOM PRIMARY COLOR TO MATCH APP.BLADE.PHP (LIGHT BLUE) */
.bg-primary { background-color: var(--primary, #279ED6) !important; }
.text-primary { color: var(--primary, #279ED6) !important; }
.border-primary { border-color: var(--primary, #279ED6) !important; }
.badge.bg-primary { background-color: var(--primary, #279ED6) !important; }
.btn-primary { background-color: var(--primary, #279ED6) !important; border-color: var(--primary, #279ED6) !important; }
.btn-primary:hover { background-color: #1f82b3 !important; border-color: #1f82b3 !important; }

/* AIRCRAFT IMAGES STYLING */
.aircraft-front-img, .aircraft-back-img {
    filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
}

/* SEAT STYLING */
.seat-row {
    min-height: 75px;
}

.seat {
    width: 70px;
}

.seat-item {
    width: 100%;
    height: 70px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    padding: 5px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-color: #ced4da;
    position: relative;
}

.seat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.seat-unavailable {
    width: 100%;
    height: 70px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border: 2px solid #495057;
    border-radius: 8px;
    background-color: #6c757d;
    color: white;
    opacity: 0.6;
    cursor: not-allowed;
    padding: 5px;
}

.seat-number {
    font-weight: bold;
    font-size: 1rem;
}

.seat-price {
    font-size: 0.8rem;
    color: #666;
}

/* SEAT TYPES */
.business-section .seat-item {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    border-color: #ffc107;
}

.economy-section .seat-item {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-color: #ced4da;
}

/* ===================== */
/* PREFERRED ZONE DESIGN */
/* ===================== */
.preferred-section {
    position: relative;
    padding: 20px;
    border-radius: 16px;
    background: linear-gradient(135deg, #e0f4ff 0%, #cce5ff 30%, #e8f4fd 70%, #d6ecfa 100%);
    border: 2px solid #7ec8e3;
    box-shadow: 0 4px 20px rgba(0, 123, 255, 0.12), inset 0 1px 0 rgba(255,255,255,0.6);
}

.preferred-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #00b4d8, #0077b6, #00b4d8);
    border-radius: 16px 16px 0 0;
}

.preferred-header {
    padding: 8px 12px;
    background: linear-gradient(135deg, rgba(0,119,182,0.08), rgba(0,180,216,0.08));
    border-radius: 10px;
    border: 1px solid rgba(0,119,182,0.15);
}

.preferred-icon-badge {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #0077b6, #00b4d8);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    box-shadow: 0 3px 8px rgba(0,119,182,0.3);
}

.preferred-title {
    font-weight: 800;
    letter-spacing: 1.5px;
    background: linear-gradient(135deg, #0077b6, #00b4d8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 1.1rem;
}

.preferred-subtitle {
    color: #4a90a4;
    font-weight: 500;
}

.preferred-badge {
    background: linear-gradient(135deg, #0077b6, #00b4d8);
    color: white;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 1px;
    box-shadow: 0 3px 8px rgba(0,119,182,0.3);
    text-transform: uppercase;
}

.legroom-indicator {
    padding: 8px;
    background: rgba(255,255,255,0.7);
    border-radius: 8px;
    border: 1px dashed #7ec8e3;
}

.legroom-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    color: #0077b6;
    font-weight: 500;
}

.preferred-row-num {
    color: #0077b6 !important;
    font-size: 1.05rem;
}

.preferred-seat-area {
    padding: 10px 0;
}

/* Preferred seat styling — bigger, bolder, premium feel */
.preferred-seat {
    background: linear-gradient(135deg, #d6f0ff 0%, #b3e0ff 50%, #cce8ff 100%) !important;
    border: 2px solid #4db8e8 !important;
    border-radius: 10px !important;
    height: 78px !important;
    box-shadow: 0 2px 8px rgba(0,119,182,0.15);
    position: relative;
}

.preferred-seat:hover {
    background: linear-gradient(135deg, #c0e5ff 0%, #99d6ff 50%, #b3dcff 100%) !important;
    border-color: #0077b6 !important;
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,119,182,0.25);
}

.preferred-seat .seat-number {
    color: #0077b6;
    font-weight: 700;
}

.preferred-seat .seat-price {
    color: #0077b6;
    font-weight: 600;
}

.legroom-icon {
    position: absolute;
    bottom: 2px;
    right: 3px;
    font-size: 0.6rem;
    color: #00b4d8;
    opacity: 0.7;
}

/* Preferred aisle */
.aisle-preferred {
    position: relative;
    width: 8px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.aisle-preferred-line {
    width: 3px;
    height: 100%;
    background: linear-gradient(to bottom, transparent 0%, #7ec8e3 20%, #7ec8e3 80%, transparent 100%);
    border-radius: 2px;
}

.aisle-preferred-dot {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 12px;
    height: 12px;
    background: linear-gradient(135deg, #00b4d8, #0077b6);
    border-radius: 50%;
    box-shadow: 0 0 8px rgba(0,180,216,0.4);
}

/* SELECTED STATE */
.seat-item.selected {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
    border-color: #1e7e34 !important;
    color: white !important;
}

.seat-item.selected .seat-price {
    color: rgba(255,255,255,0.8) !important;
}

.seat-item.selected .seat-number {
    color: white !important;
    -webkit-text-fill-color: white !important;
}

.seat-item.selected .legroom-icon {
    color: rgba(255,255,255,0.6) !important;
}

/* AISLE STYLING */
.aisle {
    min-width: 80px;
    position: relative;
}

.aisle-line {
    width: 4px;
    height: 70px;
    background: linear-gradient(
        to bottom,
        transparent 0%,
        transparent 10%,
        #dee2e6 10%,
        #dee2e6 20%,
        transparent 20%,
        transparent 30%,
        #dee2e6 30%,
        #dee2e6 40%,
        transparent 40%,
        transparent 50%,
        #dee2e6 50%,
        #dee2e6 60%,
        transparent 60%,
        transparent 70%,
        #dee2e6 70%,
        #dee2e6 80%,
        transparent 80%,
        transparent 90%,
        #dee2e6 90%,
        #dee2e6 100%
    );
    border-radius: 2px;
    position: relative;
}

.aisle-line::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 12px;
    height: 12px;
    background: var(--primary, #279ED6);
    border-radius: 50%;
    opacity: 0.6;
}

/* LEGEND */
.legend {
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.seat-legend {
    width: 20px;
    height: 20px;
    border-radius: 4px;
}

.seat-legend.business {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    border: 2px solid #ffc107;
}

.seat-legend.preferred {
    background: linear-gradient(135deg, #d6f0ff, #b3e0ff);
    border: 2px solid #4db8e8;
}

.seat-legend.economy {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border: 2px solid #ced4da;
}

.seat-legend.selected {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: 2px solid #1e7e34;
}

.seat-legend.unavailable {
    background-color: #6c757d;
    border: 2px solid #495057;
}

/* FACILITIES */
.galley-section, .facility-box {
    font-size: 0.9rem;
    font-weight: 500;
}

/* CUSTOM CARD SHADOW */
.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .aircraft-front-img {
        max-width: 180px !important;
    }
    
    .aircraft-back-img {
        max-width: 160px !important;
    }
    
    .seat {
        width: 55px;
    }
    
    .seat-item, .seat-unavailable {
        height: 55px;
        padding: 2px;
    }

    .preferred-seat {
        height: 60px !important;
    }
    
    .seat-number {
        font-size: 0.85rem;
    }
    
    .seat-price {
        font-size: 0.7rem;
    }
    
    .aisle {
        min-width: 50px;
        margin: 0 8px;
    }

    .aisle-line {
        width: 3px;
        height: 55px;
    }

    .aisle-line::before {
        width: 10px;
        height: 10px;
    }
    
    .legend {
        font-size: 0.85rem;
    }
    
    .card-body {
        padding: 1rem;
    }

    .preferred-section {
        padding: 12px;
    }

    .preferred-badge {
        display: none;
    }

    .legroom-indicator {
        flex-direction: column;
        gap: 4px !important;
    }
}

/* SCROLLBAR STYLING */
.aircraft-container {
    max-height: 70vh;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #007bff #f1f1f1;
}

.aircraft-container::-webkit-scrollbar {
    width: 8px;
}

.aircraft-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.aircraft-container::-webkit-scrollbar-thumb {
    background: #007bff;
    border-radius: 4px;
}

.aircraft-container::-webkit-scrollbar-thumb:hover {
    background: #0056b3;
}

/* DISABLED SEAT STATE - when max seats reached */
.seat-item.seat-disabled {
    opacity: 0.35;
    cursor: not-allowed !important;
    pointer-events: none;
    transform: none !important;
    box-shadow: none !important;
}

/* SEAT COUNTER BADGE */
.seat-counter-badge {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0d6efd;
    line-height: 1;
}

.seat-counter-badge .counter-full {
    color: #198754;
}

.border-info {
    border-color: #0dcaf0 !important;
}
</style>

<?php $__env->startPush('scripts'); ?>
<script>
// SEAT SELECTION LOGIC WITH PASSENGER LIMIT ENFORCEMENT
console.log('=== SEAT SELECTION PAGE LOADING ===');

const REQUIRED_SEATS = <?php echo e($requiredSeats ?? 1); ?>;
const ADULTS = <?php echo e($adults ?? 1); ?>;
const CHILDREN = <?php echo e($children ?? 0); ?>;
const INFANTS = <?php echo e($infants ?? 0); ?>;
const EXCHANGE_RATE = <?php echo e(config('app.usd_to_idr', 15000)); ?>;

let selectedSeats = [];
let totalPrice = 0;
let isVipEconomyUnlocked = false;
const VIP_SEAT_FEE = 150000;

function initializeSeatSelection() {
    console.log('🔄 Initializing seat selection...');
    selectedSeats = [];
    totalPrice = 0;
    
    // Clear JS state
    document.querySelectorAll('.seat-item').forEach(s => s.classList.remove('selected'));
    document.getElementById('economySectionWrap')?.classList.remove('vip-unlocked');
    document.getElementById('economyOverlay')?.classList.remove('d-none');
    document.getElementById('economyOverlay').style.display = 'flex';
    isVipEconomyUnlocked = false;

    updateUI();
    console.log('✅ Initialization complete');
}

// Handled globally now

// Global function to unlock VIP mapping
window.unlockVipSelection = function() {
    isVipEconomyUnlocked = true;
    const overlay = document.getElementById('economyOverlay');
    if (overlay) {
        overlay.classList.add('d-none');
        overlay.style.setProperty('display', 'none', 'important');
    }
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Manual Seat Selection Unlocked',
        showConfirmButton: false,
        timer: 3000
    });
};

document.getElementById('btnUnlockVip')?.addEventListener('click', function() {
    unlockVipSelection();
});

// Global function to assign random seats
window.assignRandomSeats = function() {
    // Collect all available economy seats
    const allEcon = Array.from(document.querySelectorAll('.seat-item[data-class="economy"], .seat-item[data-class="preferred"]'));
    if (allEcon.length < REQUIRED_SEATS) {
        Swal.fire('Error', 'Not enough economy seats available!', 'error');
        return;
    }
    
    // Pick random seats
    const shuffled = allEcon.sort(() => 0.5 - Math.random());
    const picked = shuffled.slice(0, REQUIRED_SEATS);
    
    // Clear existing
    handleClearSeats(true);
    
    // Check them silently
    picked.forEach(seatEl => {
        handleSeatClick(seatEl, true); // true = isRandom (no VIP fee)
    });

    // Update overlay to show "Success" state instead of hiding
    const overlay = document.getElementById('economyOverlay');
    if (overlay) {
        const overlayContent = overlay.querySelector('.bg-white');
        if (overlayContent) {
            overlayContent.innerHTML = `
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold mb-2">Random Seats Assigned</h4>
                <p class="text-muted small mb-4">We've picked the best available seats for you. You can see them in the summary below.</p>
                
                <div class="d-grid gap-3">
                    <button type="button" class="btn btn-warning fw-bold text-dark" onclick="unlockVipSelection()">
                        <i class="bi bi-star-fill me-2"></i> Change to VIP Selection (+ Rp 150.000/seat)
                    </button>
                    <p class="small text-muted mb-0">The seat map will remain blurred for protection.</p>
                </div>
            `;
        }
    }

    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: 'Random Seats Assigned',
        showConfirmButton: false,
        timer: 3000
    });
};

document.getElementById('btnRandomSeat')?.addEventListener('click', function() {
    assignRandomSeats();
});

document.addEventListener('click', function(event) {
    if (event.target.closest('.seat-item')) {
        const seatElement = event.target.closest('.seat-item');
        handleSeatClick(seatElement);
    }
    if (event.target.closest('#clear-seats')) {
        handleClearSeats();
    }
    if (event.target.closest('#continue-btn')) {
        handleContinueBooking();
    }
});

    function handleSeatClick(seatElement, isRandom = false) {
        const seatId = seatElement.dataset.seatId;
        const seatNumber = seatElement.dataset.seatNumber;
        let basePriceUsd = parseFloat(seatElement.dataset.price);
        
        // Use the dynamic exchange rate injected from Laravel
        let finalPrice = basePriceUsd * EXCHANGE_RATE; 
        
        const isEconomy = seatElement.dataset.class === 'economy' || seatElement.dataset.class === 'preferred';
        
        // BLOCK MANUAL SELECTION if not unlocked
        if (isEconomy && !isRandom && !isVipEconomyUnlocked) {
            const overlay = document.getElementById('economyOverlay');
            if (overlay) {
                overlay.classList.remove('d-none');
                overlay.style.setProperty('display', 'flex', 'important');
            }
            Swal.fire({
                icon: 'warning',
                title: 'Manual Selection Locked',
                text: 'Please unlock manual selection to pick specific seats, or use Random Assignment for free.',
                confirmButtonColor: '#279ED6'
            });
            return;
        }

        // If it's an economy seat selected manually (not random)
        let appliedVipFee = 0;
        if (isEconomy && !isRandom && isVipEconomyUnlocked) {
            appliedVipFee = VIP_SEAT_FEE;
        }

        const totalSeatPrice = finalPrice + appliedVipFee;
        
        console.log(`🪑 Seat clicked: ${seatNumber} (Base: Rp ${finalPrice}, VIP Fee: Rp ${appliedVipFee})`);
        
        if (seatElement.classList.contains('selected')) {
            // Deselect
            seatElement.classList.remove('selected');
            const removedSeat = selectedSeats.find(s => s.id === seatId);
            if (removedSeat) {
                totalPrice -= removedSeat.totalSeatPrice;
                selectedSeats = selectedSeats.filter(s => s.id !== seatId);
            }
            console.log(`➖ Deselected: ${seatNumber}`);
        } else {
            // Check against required seats limit
            if (selectedSeats.length >= REQUIRED_SEATS) {
                // Auto-cancel the earliest selected seat
                const oldestSeat = selectedSeats.shift();
                const oldestSeatElement = document.querySelector(`.seat-item[data-seat-id="${oldestSeat.id}"]`);
                if (oldestSeatElement) {
                    oldestSeatElement.classList.remove('selected');
                }
                totalPrice -= oldestSeat.totalSeatPrice;
                console.log(`➖ Auto-deselected: ${oldestSeat.number}`);
            }
            
            seatElement.classList.add('selected');
            selectedSeats.push({
                id: seatId,
                number: seatNumber,
                price: finalPrice, // sending original converted IDR price
                vipFee: appliedVipFee,
                totalSeatPrice: totalSeatPrice,
                isVipSelected: appliedVipFee > 0
            });
            totalPrice += totalSeatPrice;
            console.log(`➕ Selected: ${seatNumber} (${selectedSeats.length}/${REQUIRED_SEATS})`);
        }
        
        updateUI();
    }

function toggleSeatDisabledState() {
    // We no longer disable unselected seats when max is reached.
    // Instead, clicking a new seat will auto-cancel the oldest selection.
    const allSeatItems = document.querySelectorAll('.seat-item');
    allSeatItems.forEach(seat => {
        seat.classList.remove('seat-disabled');
    });
}

function handleClearSeats(bypassConfirm = false) {
    if (selectedSeats.length === 0) {
        if(!bypassConfirm) alert('No seats to clear');
        return;
    }
    
    if (bypassConfirm || confirm('Clear all selected seats?')) {
        document.querySelectorAll('.seat-item.selected').forEach(seat => {
            seat.classList.remove('selected');
        });
        selectedSeats = [];
        totalPrice = 0;
        console.log('🗑️ All seats cleared');
        
        // RESET OVERLAY if it was showing the "Random" success screen
        if (!isVipEconomyUnlocked) {
            const overlay = document.getElementById('economyOverlay');
            if (overlay) {
                const overlayContent = overlay.querySelector('.bg-white');
                if (overlayContent) {
                    overlayContent.innerHTML = `
                        <div class="mb-4">
                            <i class="bi bi-lock-fill text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Economy Seat Selection</h4>
                        <p class="text-muted small mb-4 px-3">Seat selection for economy class is locked. You can choose a random assignment for free, or unlock manual selection for a premium fee.</p>
                        
                        <div class="d-grid gap-3 px-3">
                            <button type="button" class="btn btn-primary fw-bold py-3" id="btnRandomSeat">
                                <i class="bi bi-shuffle me-2"></i> Random Assignment (Free)
                            </button>
                            <div class="text-center">
                                <span class="bg-white px-2 text-muted small position-relative" style="z-index: 1;">OR</span>
                                <hr class="mt-n2" style="margin-top: -10px;">
                            </div>
                            <button type="button" class="btn btn-warning fw-bold py-3 text-dark" id="btnUnlockVip">
                                <i class="bi bi-star-fill me-2"></i> Unlock Selection (+ Rp 150.000/seat)
                            </button>
                        </div>
                        
                        <p class="mt-4 small text-muted mb-0">VIP Manual selection allows you to choose any available seat.</p>
                    `;
                    
                    // Re-attach listeners to the fresh elements
                    document.getElementById('btnRandomSeat')?.addEventListener('click', function() {
                        assignRandomSeats();
                    });
                     document.getElementById('btnUnlockVip')?.addEventListener('click', function() {
                        unlockVipSelection();
                    });
                }
            }
        }
        
        updateUI();
    }
}

function handleContinueBooking() {
    console.log('🚀 CONTINUE TO BOOKING CLICKED!');
    
    const continueBtn = document.getElementById('continue-btn');
    if (continueBtn.disabled) {
        return;
    }
    
    if (selectedSeats.length !== REQUIRED_SEATS) {
        alert(`Please select exactly ${REQUIRED_SEATS} seat${REQUIRED_SEATS > 1 ? 's' : ''}.`);
        return;
    }
    
    console.log('📊 Selected seats:', selectedSeats);
    console.log('💰 Total price:', totalPrice);
    console.log('✈️ Flight ID:', <?php echo e($flight->flight_instance_id); ?>);
    
    continueBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Redirecting...';
    continueBtn.disabled = true;
    
    setTimeout(() => {
        try {
            localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
            localStorage.setItem('totalPrice', totalPrice);
            localStorage.setItem('flightId', <?php echo e($flight->flight_instance_id); ?>);
            
            sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
            sessionStorage.setItem('totalPrice', totalPrice);
            sessionStorage.setItem('flightId', <?php echo e($flight->flight_instance_id); ?>);
            
            console.log('💾 Data saved to storage');
        } catch (e) {
            console.log('⚠️ Could not save to storage:', e);
        }
        
        const params = new URLSearchParams();
        params.set('seats', JSON.stringify(selectedSeats));
        params.set('total', totalPrice);
        params.set('flight_id', <?php echo e($flight->flight_instance_id); ?>);
        params.set('adults', ADULTS);
        params.set('children', CHILDREN);
        params.set('infants', INFANTS);

        const redirectUrl = '<?php echo e(route("booking.auth")); ?>?' + params.toString();
        console.log('🔗 Redirect URL:', redirectUrl);

        window.location.href = redirectUrl;
        
    }, 500);
}

function updateUI() {
    console.log('🎨 Updating UI...');
    
    // Update total price display
    const totalElement = document.getElementById('total-price');
    if (totalElement) {
        totalElement.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }
    
    // Update seat counter badge
    const seatCounter = document.getElementById('seat-counter');
    if (seatCounter) {
        seatCounter.textContent = selectedSeats.length;
        if (selectedSeats.length === REQUIRED_SEATS) {
            seatCounter.classList.add('counter-full');
            seatCounter.parentElement.style.color = '#198754';
        } else {
            seatCounter.classList.remove('counter-full');
            seatCounter.parentElement.style.color = '#0d6efd';
        }
    }
    
    // Update continue button
    const continueBtn = document.getElementById('continue-btn');
    if (continueBtn) {
        const remaining = REQUIRED_SEATS - selectedSeats.length;
        if (selectedSeats.length === REQUIRED_SEATS) {
            continueBtn.disabled = false;
            continueBtn.classList.remove('btn-secondary');
            continueBtn.classList.add('btn-success');
            continueBtn.innerHTML = '<i class="bi bi-arrow-right"></i> Continue to Booking';
        } else {
            continueBtn.disabled = true;
            continueBtn.classList.remove('btn-success');
            continueBtn.classList.add('btn-secondary');
            if (remaining > 0) {
                continueBtn.innerHTML = `<i class="bi bi-geo-alt"></i> Select ${remaining} more seat${remaining > 1 ? 's' : ''}`;
            } else {
                continueBtn.innerHTML = '<i class="bi bi-arrow-right"></i> Continue to Booking';
            }
        }
    }
    
    // Toggle disabled state on remaining seats
    toggleSeatDisabledState();
    
    updateSeatList();
}

function updateSeatList() {
    const container = document.getElementById('selected-seats-list');
    if (!container) return;
    
    if (selectedSeats.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-3">
                <i class="bi bi-emoji-frown display-4"></i>
                <p class="mt-2">No seats selected yet. Please select ${REQUIRED_SEATS} seat${REQUIRED_SEATS > 1 ? 's' : ''}.</p>
            </div>
        `;
        return;
    }
    
    let html = '<div class="row">';
    selectedSeats.forEach((seat, index) => {
        let vipBadge = seat.isVipSelected ? `<span class="badge bg-warning text-dark ms-2" style="font-size: 0.65rem;">VIP Seat +Rp150k</span>` : '';
        html += `
            <div class="col-md-4 mb-2">
                <div class="border rounded p-2 bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="fs-5">${seat.number}</strong> ${vipBadge}
                            <div class="small text-muted">Passenger ${index + 1}</div>
                        </div>
                        <div class="text-end">
                            <span class="text-primary fw-bold">Rp ${seat.totalSeatPrice.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    html += '</div>';
    
    container.innerHTML = html;
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    updateUI();
});

console.log('✅ Seat selection script loaded');
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/flight/seats.blade.php ENDPATH**/ ?>