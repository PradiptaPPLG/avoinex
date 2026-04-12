<?php $__env->startSection('title', 'Search Results - Avoinex'); ?>

<?php $__env->startSection('content'); ?>
<div class="avx-search-results-page">
    
    <div class="container mt-4">
        <div class="card mb-4 avx-search-summary-card">
            <div class="card-body">
                <div id="searchSummaryView" class="row align-items-center" style="cursor: pointer;" onclick="toggleSearchForm()">
                    <div class="col-md-3">
                        <small class="text-muted">FROM</small>
                        <h5 class="mb-0"><?php echo e($origin->city ?? 'Jakarta'); ?> (<?php echo e($origin->iata_code ?? 'CGK'); ?>)</h5>
                        <p class="text-muted mb-0"><?php echo e($origin->airport_name ?? 'Soekarno-Hatta Intl'); ?></p>
                    </div>
                    <div class="col-md-1 text-center text-muted">
                        <i class="bi bi-arrow-right fs-4"></i>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">TO</small>
                        <h5 class="mb-0"><?php echo e($destination->city ?? 'Denpasar'); ?> (<?php echo e($destination->iata_code ?? 'DPS'); ?>)</h5>
                        <p class="text-muted mb-0"><?php echo e($destination->airport_name ?? 'Ngurah Rai Intl'); ?></p>
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted">DEPARTURE</small>
                        <h5 class="mb-0"><?php echo e(date('d M Y', strtotime($searchParams['depart'] ?? now()))); ?></h5>
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted">PASSENGERS</small>
                        <h5 class="mb-0">
                            <?php
                                $totalPax = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0) + ($searchParams['infants'] ?? 0);
                            ?>
                            <?php echo e($totalPax); ?> Passenger<?php echo e($totalPax > 1 ? 's' : ''); ?>

                        </h5>
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3">Ubah</button>
                    </div>
                </div>

                <div id="searchFormView" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-search me-2"></i>Ubah Pencarian</h5>
                        <button type="button" class="btn-close" aria-label="Close" onclick="toggleSearchForm()"></button>
                    </div>
                    <form class="avx-search-form" action="<?php echo e(route('flights.search')); ?>" method="GET">
                        <input type="hidden" name="tab" value="oneway">
                        <input type="hidden" name="adults" value="<?php echo e($searchParams['adults'] ?? 1); ?>">
                        <input type="hidden" name="children" value="<?php echo e($searchParams['children'] ?? 0); ?>">
                        <input type="hidden" name="infants" value="<?php echo e($searchParams['infants'] ?? 0); ?>">
                        <input type="hidden" name="passengers" value="<?php echo e($totalPax ?? 1); ?>">
                        <input type="hidden" name="travel_class" value="economy">
                        <div class="avx-search-main">
                            <div class="avx-field position-relative" style="z-index: 10;">
                                <span class="avx-field-label text-muted small fw-bold">DARI</span>
                                <div class="avx-input-wrap">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    <input type="hidden" name="from" id="from_search" value="<?php echo e($searchParams['from'] ?? ''); ?>">
                                    <input id="from_display_search" name="from_display" placeholder="Kota atau Bandara" autocomplete="off" required 
                                           value="<?php echo e(isset($origin) ? $origin->city . ' (' . $origin->iata_code . ') - ' . $origin->airport_name : ''); ?>">
                                </div>
                                <div class="avx-autocomplete-dropdown" id="from_dropdown_search" style="display: none;"></div>
                            </div>
                            <div class="avx-swap-container" style="display: flex; align-items: flex-end; justify-content: center; padding-bottom: 8px; position: relative; z-index: 11;">
                                <button type="button" class="avx-swap-btn" id="swapLocationsBtnSearch" aria-label="Swap locations" title="Swap locations" onclick="swapSearchLocations(event)">
                                    <i class="bi bi-arrow-left-right"></i>
                                </button>
                            </div>
                            <div class="avx-field position-relative" style="z-index: 9;">
                                <span class="avx-field-label text-muted small fw-bold">KE</span>
                                <div class="avx-input-wrap">
                                    <i class="bi bi-geo text-primary me-2"></i>
                                    <input type="hidden" name="to" id="to_search" value="<?php echo e($searchParams['to'] ?? ''); ?>">
                                    <input id="to_display_search" name="to_display" placeholder="Kota atau Bandara" autocomplete="off" required
                                           value="<?php echo e(isset($destination) ? $destination->city . ' (' . $destination->iata_code . ') - ' . $destination->airport_name : ''); ?>">
                                </div>
                                <div class="avx-autocomplete-dropdown" id="to_dropdown_search" style="display: none;"></div>
                            </div>
                            <label class="avx-field" for="depart_search">
                                <span class="avx-field-label text-muted small fw-bold">TANGGAL PERGI</span>
                                <div class="avx-input-wrap avx-input-date">
                                    <input id="depart_search" name="depart" type="date" required value="<?php echo e($searchParams['depart'] ?? ''); ?>">
                                </div>
                            </label>
                            <button class="btn btn-primary avx-cta-search" type="submit" style="height: 56px; border-radius: 12px; font-weight: bold; padding: 0 24px; align-self: end; white-space: nowrap;">
                                <i class="bi bi-search me-1"></i> Cari Tiket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            
            <div class="col-lg-3 mb-4">
                <div class="avx-filter-sidebar">
                    <div class="avx-filter-header">
                        <h6 class="mb-0"><i class="bi bi-funnel-fill me-2"></i>Filter</h6>
                        <button class="avx-filter-reset" id="resetAllFilters" onclick="resetAllFilters()">Reset</button>
                    </div>

                    
                    <div class="avx-filter-section">
                        <div class="avx-filter-title" onclick="toggleFilterSection(this)">
                            <span><i class="bi bi-airplane me-2"></i>Maskapai</span>
                            <i class="bi bi-chevron-down avx-filter-chevron"></i>
                        </div>
                        <div class="avx-filter-body" id="filterAirlines">
                            
                        </div>
                    </div>

                    
                    <div class="avx-filter-section">
                        <div class="avx-filter-title" onclick="toggleFilterSection(this)">
                            <span><i class="bi bi-cash-coin me-2"></i>Rentang Harga</span>
                            <i class="bi bi-chevron-down avx-filter-chevron"></i>
                        </div>
                        <div class="avx-filter-body">
                            <div class="avx-price-range">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="avx-price-label" id="priceMinLabel">Rp 0</span>
                                    <span class="avx-price-label" id="priceMaxLabel">Rp ∞</span>
                                </div>
                                <input type="range" class="avx-range-slider" id="priceMinSlider" min="0" max="25000000" value="0" oninput="applyFilters()">
                                <input type="range" class="avx-range-slider" id="priceMaxSlider" min="0" max="25000000" value="25000000" oninput="applyFilters()">
                            </div>
                        </div>
                    </div>

                    
                    <div class="avx-filter-section">
                        <div class="avx-filter-title" onclick="toggleFilterSection(this)">
                            <span><i class="bi bi-clock me-2"></i>Waktu Berangkat</span>
                            <i class="bi bi-chevron-down avx-filter-chevron"></i>
                        </div>
                        <div class="avx-filter-body">
                            <label class="avx-filter-check">
                                <input type="checkbox" value="dini_hari" onchange="applyFilters()" checked>
                                <span class="avx-filter-check-label">
                                    <i class="bi bi-moon-stars"></i> Dini Hari <small class="text-muted">(00:00 - 06:00)</small>
                                </span>
                            </label>
                            <label class="avx-filter-check">
                                <input type="checkbox" value="pagi" onchange="applyFilters()" checked>
                                <span class="avx-filter-check-label">
                                    <i class="bi bi-sunrise"></i> Pagi <small class="text-muted">(06:00 - 12:00)</small>
                                </span>
                            </label>
                            <label class="avx-filter-check">
                                <input type="checkbox" value="siang" onchange="applyFilters()" checked>
                                <span class="avx-filter-check-label">
                                    <i class="bi bi-sun"></i> Siang <small class="text-muted">(12:00 - 18:00)</small>
                                </span>
                            </label>
                            <label class="avx-filter-check">
                                <input type="checkbox" value="malam" onchange="applyFilters()" checked>
                                <span class="avx-filter-check-label">
                                    <i class="bi bi-moon"></i> Malam <small class="text-muted">(18:00 - 24:00)</small>
                                </span>
                            </label>
                        </div>
                    </div>

                    
                    <button class="avx-filter-mobile-toggle d-lg-none" id="mobileFilterToggle" onclick="toggleMobileFilter()">
                        <i class="bi bi-funnel"></i> Filter & Sort
                    </button>
                </div>
            </div>

            
            <div class="col-lg-9">
                
                <div class="avx-sort-bar mb-3">
                    <div class="avx-sort-left">
                        <span class="avx-results-count" id="resultsCount">
                            <i class="bi bi-airplane-fill me-1"></i>
                            <strong><?php echo e($flights->count()); ?></strong> penerbangan ditemukan
                        </span>
                    </div>
                    <div class="avx-sort-right">
                        <span class="avx-sort-label">Urutkan:</span>
                        <div class="avx-sort-buttons" id="sortButtons">
                            <button class="avx-sort-btn active" data-sort="price_asc" onclick="setSort(this, 'price_asc')">
                                <i class="bi bi-sort-down"></i> Termurah
                            </button>
                            <button class="avx-sort-btn" data-sort="price_desc" onclick="setSort(this, 'price_desc')">
                                <i class="bi bi-sort-up"></i> Termahal
                            </button>
                            <button class="avx-sort-btn" data-sort="duration_asc" onclick="setSort(this, 'duration_asc')">
                                <i class="bi bi-hourglass-split"></i> Tercepat
                            </button>
                            <button class="avx-sort-btn" data-sort="depart_asc" onclick="setSort(this, 'depart_asc')">
                                <i class="bi bi-sunrise"></i> Paling Pagi
                            </button>
                            <button class="avx-sort-btn" data-sort="depart_desc" onclick="setSort(this, 'depart_desc')">
                                <i class="bi bi-moon"></i> Paling Malam
                            </button>
                        </div>
                    </div>
                </div>

                
                <div id="flightCardsContainer">
                    <?php if($flights->isEmpty()): ?>
                        <div class="avx-empty-state" id="emptyStateOriginal">
                            <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Tidak ada penerbangan ditemukan</h4>
                            <p class="text-muted">Coba ubah kriteria pencarian Anda</p>
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Pencarian Baru</a>
                        </div>
                    <?php else: ?>
                        <?php $__currentLoopData = $flights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $exchangeRate = config('app.usd_to_idr', 15500);
                            $availableSeats = $flight->available_seats ?? 0;
                            $passengerCount = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0);
                            $hasEnoughSeats = $availableSeats >= $passengerCount;
                            
                            $rawBasePrice = $flight->schedule->base_price_usd;
                            $rawDisplayPrice = isset($flight->active_flash_sale)
                                ? $flight->active_flash_sale->getDiscountedPrice($rawBasePrice)
                                : $rawBasePrice;
                                
                            $basePrice = $rawBasePrice * $exchangeRate;
                            $displayPrice = $rawDisplayPrice * $exchangeRate;
                            
                            $departureTime = $flight->schedule->departure_time_gmt;
                            $departureHour = (int) date('H', strtotime($departureTime));
                            $durationMinutes = $flight->schedule->duration_minutes;
                            $airlineName = $flight->schedule->airline->airline_name ?? ($flight->airline_name ?? 'Airline');
                        ?>
                        <div class="flight-card ticket-card avx-flight-item"
                             data-price="<?php echo e($displayPrice); ?>"
                             data-base-price="<?php echo e($basePrice); ?>"
                             data-duration="<?php echo e($durationMinutes); ?>"
                             data-depart-hour="<?php echo e($departureHour); ?>"
                             data-depart-time="<?php echo e($departureTime); ?>"
                             data-airline="<?php echo e($airlineName); ?>"
                             data-has-promo="<?php echo e(isset($flight->active_flash_sale) ? '1' : '0'); ?>">
                            <div class="ticket-top p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-2 d-flex flex-column align-items-center gap-2">
                                        <?php if(isset($flight->schedule->airline->logo_path) && $flight->schedule->airline->logo_path): ?>
                                            <div class="airline-logo rounded-circle shadow-sm overflow-hidden flex-shrink-0" style="background-color: #fff; border: 2px solid #e0e0e0; display: flex; align-items: center; justify-content: center; padding: 0;">
                                                <img src="<?php echo e(asset('logo_maskapai/' . $flight->schedule->airline->logo_path)); ?>" alt="<?php echo e($airlineName); ?> Logo" style="width: 100%; height: 100%; object-fit: contain; padding: 5px;">
                                            </div>
                                        <?php else: ?>
                                            <div class="airline-logo bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                                <?php echo e($flight->airline_code ?? 'GA'); ?>

                                            </div>
                                        <?php endif; ?>
                                        <p class="mb-0 fw-bold text-center" style="font-size: 13px;"><?php echo e($airlineName); ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <h4 class="mb-1"><?php echo e(date('H:i', strtotime($flight->schedule->departure_time_gmt))); ?></h4>
                                        <p class="text-muted mb-0"><?php echo e($flight->schedule->originAirport->city); ?> (<?php echo e($flight->schedule->originAirport->iata_code); ?>)</p>
                                        <small class="text-muted"><?php echo e($flight->flight_date->format('d M')); ?></small>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <p class="mb-1"><?php echo e(floor($durationMinutes / 60)); ?>h <?php echo e($durationMinutes % 60); ?>m</p>
                                        <div class="border-bottom"></div>
                                        <p class="text-muted small mb-0">Direct</p>
                                    </div>
                                    <div class="col-md-2">
                                        <h4 class="mb-1"><?php echo e(date('H:i', strtotime($flight->schedule->arrival_time_gmt))); ?></h4>
                                        <p class="text-muted mb-0"><?php echo e($flight->schedule->destinationAirport->city); ?> (<?php echo e($flight->schedule->destinationAirport->iata_code); ?>)</p>
                                        <small class="text-muted"><?php echo e($flight->flight_date->format('d M')); ?></small>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <?php if(isset($flight->active_flash_sale)): ?>
                                            <div class="mb-1">
                                                <span class="badge bg-danger" style="font-size:10px; letter-spacing:0.5px;">⚡ PROMO</span>
                                            </div>
                                            <span class="text-decoration-line-through text-muted small d-block">Rp <?php echo e(number_format($basePrice, 0, ',', '.')); ?></span>
                                            <h4 class="text-danger mb-0 fw-bold">Rp <?php echo e(number_format($displayPrice, 0, ',', '.')); ?></h4>
                                        <?php else: ?>
                                            <h4 class="text-primary mb-1">Rp <?php echo e(number_format($basePrice, 0, ',', '.')); ?></h4>
                                        <?php endif; ?>
                                        <p class="text-muted small mb-2">per person</p>

                                        <?php if($hasEnoughSeats): ?>
                                            <a href="<?php echo e(route('flight.seats', $flight->flight_instance_id)); ?>?adults=<?php echo e($searchParams['adults'] ?? 1); ?>&children=<?php echo e($searchParams['children'] ?? 0); ?>&infants=<?php echo e($searchParams['infants'] ?? 0); ?>" class="btn btn-primary px-4">Select</a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary" disabled title="Not enough seats available">
                                                <i class="bi bi-exclamation-circle"></i> Limited
                                            </button>
                                            <small class="text-danger d-block mt-1">Only <?php echo e($availableSeats); ?> seat<?php echo e($availableSeats != 1 ? 's' : ''); ?> left</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="ticket-divider">
                                <div class="ticket-cutout-left"></div>
                                <div class="ticket-line"></div>
                                <div class="ticket-cutout-right"></div>
                            </div>

                            <div class="ticket-bottom p-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="mb-0 text-muted small">
                                            <i class="bi bi-suitcase me-1"></i> 20kg baggage &bull;
                                            <i class="bi bi-utensils ms-2 me-1"></i> Meal included &bull;
                                            <i class="bi bi-wifi ms-2 me-1"></i> Free Wi-Fi
                                            <?php
                                                $flashSaleSeatsRemaining = isset($flight->active_flash_sale)
                                                    ? $flight->active_flash_sale->getRemainingSeats()
                                                    : null;
                                            ?>
                                            <span class="badge bg-success ms-3"><?php echo e(isset($flashSaleSeatsRemaining) ? $flashSaleSeatsRemaining . ' promo seats' : $availableSeats . ' seats'); ?> available</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>

                
                <div class="avx-empty-state" id="emptyStateFiltered" style="display: none;">
                    <i class="bi bi-funnel text-muted" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Tidak ada penerbangan yang cocok</h4>
                    <p class="text-muted">Coba ubah atau reset filter Anda</p>
                    <button class="btn btn-outline-primary" onclick="resetAllFilters()"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== FILTER SIDEBAR ===== */
.avx-filter-sidebar {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 16px;
    overflow: hidden;
    position: sticky;
    top: 88px;
}
.avx-filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: linear-gradient(135deg, #279ED6 0%, #1a7bb5 100%);
    color: #fff;
}
.avx-filter-header h6 { font-weight: 700; font-size: 15px; }
.avx-filter-reset {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    color: #fff;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.avx-filter-reset:hover {
    background: rgba(255,255,255,0.35);
}
.avx-filter-section {
    border-bottom: 1px solid #f0f0f0;
}
.avx-filter-section:last-child { border-bottom: none; }
.avx-filter-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    cursor: pointer;
    font-weight: 600;
    font-size: 13.5px;
    color: #333;
    transition: background 0.2s;
}
.avx-filter-title:hover { background: #f8fbff; }
.avx-filter-chevron {
    transition: transform 0.3s;
    font-size: 12px;
    color: #999;
}
.avx-filter-section.collapsed .avx-filter-chevron {
    transform: rotate(-90deg);
}
.avx-filter-section.collapsed .avx-filter-body {
    display: none;
}
.avx-filter-body {
    padding: 0 20px 16px;
}
.avx-filter-check {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s;
    margin-bottom: 4px;
}
.avx-filter-check:hover { background: #f0f8ff; }
.avx-filter-check input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #279ED6;
    flex-shrink: 0;
}
.avx-filter-check-label {
    font-size: 13px;
    font-weight: 500;
    color: #444;
    display: flex;
    align-items: center;
    gap: 8px;
}
.avx-filter-check-label i { color: #279ED6; font-size: 15px; }
.avx-filter-check-count {
    margin-left: auto;
    background: #f0f0f0;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 11px;
    color: #888;
    font-weight: 600;
}

/* Price Range Slider */
.avx-price-range { padding: 8px 0; }
.avx-price-label {
    font-size: 12px;
    color: #279ED6;
    font-weight: 700;
    font-family: 'Poppins', sans-serif;
}
.avx-range-slider {
    width: 100%;
    height: 6px;
    -webkit-appearance: none;
    appearance: none;
    background: #e9ecef;
    border-radius: 3px;
    outline: none;
    margin-bottom: 6px;
}
.avx-range-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #279ED6;
    cursor: pointer;
    border: 3px solid #fff;
    box-shadow: 0 2px 6px rgba(39,158,214,0.4);
}

/* ===== SORT BAR ===== */
.avx-sort-bar {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 14px;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.avx-results-count {
    font-size: 14px;
    color: #555;
}
.avx-sort-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.avx-sort-label {
    font-size: 13px;
    color: #888;
    font-weight: 500;
}
.avx-sort-buttons {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.avx-sort-btn {
    padding: 6px 14px;
    border-radius: 20px;
    border: 1.5px solid #e0e0e0;
    background: #fff;
    color: #666;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.avx-sort-btn:hover {
    border-color: #279ED6;
    color: #279ED6;
    background: #f0f8ff;
}
.avx-sort-btn.active {
    background: #279ED6;
    color: #fff;
    border-color: #279ED6;
    box-shadow: 0 3px 10px rgba(39,158,214,0.3);
}
.avx-sort-btn i { margin-right: 4px; }

/* ===== FLIGHT CARDS ===== */
.flight-card.ticket-card {
    background: transparent;
    display: flex;
    flex-direction: column;
    border: none;
    box-shadow: none !important;
    transition: all 0.3s ease;
    margin-bottom: 20px;
    opacity: 1;
}
.flight-card.ticket-card.avx-hidden {
    display: none !important;
}
.flight-card.ticket-card:hover {
    transform: none !important;
    box-shadow: none !important;
    border-color: transparent !important;
    cursor: default;
}
.ticket-top {
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-bottom: none;
    border-radius: 12px 12px 0 0;
    transition: box-shadow 0.2s;
}
.ticket-top:hover {
    box-shadow: 0 4px 16px rgba(39,158,214,0.1);
}
.ticket-bottom {
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 12px 12px;
}
.ticket-divider {
    height: 30px;
    display: flex;
    align-items: center;
    position: relative;
    background: transparent;
}
.ticket-divider::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: #ffffff;
    border-left: 1px solid #dee2e6;
    border-right: 1px solid #dee2e6;
    z-index: 1;
}
.ticket-line {
    flex-grow: 1;
    border-top: 2px dashed #dee2e6;
    margin: 0 16px;
    z-index: 2;
}
.ticket-cutout-left,
.ticket-cutout-right {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 15px;
    height: 30px;
    background-color: #F8F9FA;
    z-index: 3;
    border: 1px solid #dee2e6;
}
.ticket-cutout-left {
    left: -1px;
    border-left: none;
    border-radius: 0 30px 30px 0;
}
.ticket-cutout-right {
    right: -1px;
    border-right: none;
    border-radius: 30px 0 0 30px;
}
.airline-logo {
    width: 60px;
    height: 60px;
    line-height: 1;
    font-weight: bold;
    font-size: 1.1rem;
}

/* ===== EMPTY STATE ===== */
.avx-empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #dee2e6;
}

/* ===== MOBILE FILTER TOGGLE ===== */
.avx-filter-mobile-toggle {
    display: none;
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 12px 24px;
    background: #279ED6;
    color: #fff;
    border: none;
    border-radius: 30px;
    font-weight: 700;
    font-size: 14px;
    z-index: 999;
    box-shadow: 0 6px 20px rgba(39,158,214,0.4);
    cursor: pointer;
}

/* ===== SEARCH FORM STYLES ===== */
.avx-search-main {
    display: grid;
    grid-template-columns: 1fr 40px 1fr 1fr auto;
    gap: 16px;
    align-items: end;
}
.avx-field { display:flex; flex-direction:column; gap:8px; }
.avx-input-wrap {
    display:flex; align-items:center; padding:0 16px; height: 56px;
    border-radius:12px; border:1px solid rgba(120,120,120,0.35); background: #fff;
    transition: all 0.3s ease;
}
.avx-input-wrap:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(39,158,214,0.1);
}
.avx-input-wrap input { border:0; outline:none; background:transparent; width:100%; font-size:15px; color: #333; }
.avx-input-date input[type="date"] { padding:0; height: 100%; width: 100%; }
.avx-swap-btn {
    width: 40px; height: 40px; border-radius: 50%; background: #fff;
    border: 1px solid rgba(120,120,120,0.35); color: var(--primary);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.3s; z-index: 15;
}
.avx-swap-btn:hover { border-color: var(--primary); background: #f8fcfd; }
.avx-swap-btn i { font-size: 18px; transition: transform 0.4s ease; }
.avx-swap-btn.swapping i { transform: rotate(180deg); }
.avx-autocomplete-dropdown {
    position: absolute; top: 100%; left: 0; width: 100%; background: #fff;
    border: 1px solid rgba(120,120,120,0.25); border-radius: 12px; margin-top: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 9999; max-height: 250px; overflow-y: auto;
}
.avx-autocomplete-item {
    padding: 12px 16px; cursor: pointer; border-bottom: 1px solid rgba(120,120,120,0.1);
    color: #333; display: flex; flex-direction: column; gap: 2px;
}
.avx-autocomplete-item:hover { background: rgba(39,158,214,0.08); }
.avx-autocomplete-item-city { font-weight: 600; font-size: 14px; }
.avx-autocomplete-item:hover .avx-autocomplete-item-city { color: var(--primary); }
.avx-autocomplete-item-airport { font-size: 12px; color: #6c757d; }

.avx-search-summary-card { transition: all 0.2s ease; border: 1px solid transparent; }
#searchSummaryView:hover h5 { color: var(--primary); }

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .avx-search-main { grid-template-columns: 1fr 40px 1fr; }
    .avx-cta-search { grid-column: span 3; }
    .avx-field[for="depart_search"] { grid-column: span 3; }
    .avx-filter-sidebar {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 9999;
        border-radius: 0;
        overflow-y: auto;
    }
    .avx-filter-sidebar.avx-mobile-open { display: block; }
    .avx-filter-mobile-toggle { display: block; }
    .avx-sort-buttons { overflow-x: auto; flex-wrap: nowrap; -webkit-overflow-scrolling: touch; }
}
@media (max-width: 768px) {
    .avx-search-main { grid-template-columns: 1fr; }
    .avx-swap-container { transform: rotate(90deg); padding-bottom: 0; margin: -8px 0; z-index: 20; }
    .avx-cta-search, .avx-field[for="depart_search"] { grid-column: 1; }
    .avx-sort-bar { flex-direction: column; align-items: flex-start; }
}
</style>

<?php $__env->startPush('scripts'); ?>
<script>
// ===== GLOBAL STATE =====
var currentSort = 'price_asc';
var allPrices = [];

// ===== SWAP LOCATIONS (standalone function for inline onclick) =====
function swapSearchLocations(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    var swapBtn = document.getElementById('swapLocationsBtnSearch');
    if (swapBtn) {
        swapBtn.classList.add('swapping');
        setTimeout(function() { swapBtn.classList.remove('swapping'); }, 400);
    }

    var fromDisplay = document.getElementById('from_display_search');
    var fromValue = document.getElementById('from_search');
    var toDisplay = document.getElementById('to_display_search');
    var toValue = document.getElementById('to_search');

    // Swap display values
    var tempDisplay = fromDisplay.value;
    fromDisplay.value = toDisplay.value;
    toDisplay.value = tempDisplay;

    // Swap hidden IATA code values
    var tempValue = fromValue.value;
    fromValue.value = toValue.value;
    toValue.value = tempValue;
}

document.addEventListener('DOMContentLoaded', function() {

    // ===== COLLECT FLIGHT DATA =====
    var cards = document.querySelectorAll('.avx-flight-item');
    var airlines = {};

    cards.forEach(function(card) {
        var price = parseFloat(card.dataset.price);
        var airline = card.dataset.airline;
        allPrices.push(price);
        if (!airlines[airline]) airlines[airline] = 0;
        airlines[airline]++;
    });

    // ===== POPULATE AIRLINE FILTERS =====
    var airlineContainer = document.getElementById('filterAirlines');
    if (airlineContainer) {
        var sortedAirlines = Object.keys(airlines).sort();
        sortedAirlines.forEach(function(name) {
            var label = document.createElement('label');
            label.className = 'avx-filter-check';
            label.innerHTML =
                '<input type="checkbox" value="' + name + '" onchange="applyFilters()" checked>' +
                '<span class="avx-filter-check-label">' + name + '</span>' +
                '<span class="avx-filter-check-count">' + airlines[name] + '</span>';
            airlineContainer.appendChild(label);
        });
    }

    // ===== SETUP PRICE SLIDERS =====
    if (allPrices.length > 0) {
        var minPrice = Math.min.apply(null, allPrices);
        var maxPrice = Math.max.apply(null, allPrices);
        var minSlider = document.getElementById('priceMinSlider');
        var maxSlider = document.getElementById('priceMaxSlider');

        if (minSlider && maxSlider) {
            minSlider.min = 0;
            minSlider.max = maxPrice > 25000000 ? maxPrice : 25000000;
            minSlider.value = minPrice;
            maxSlider.min = 0;
            maxSlider.max = maxPrice > 25000000 ? maxPrice : 25000000;
            maxSlider.value = maxPrice;
            updatePriceLabels();
        }
    }

    // Apply initial sort
    applyFilters();

    // ===== AUTOCOMPLETE =====
    setupAutocompleteSearch('from_display_search', 'from_search', 'from_dropdown_search');
    setupAutocompleteSearch('to_display_search', 'to_search', 'to_dropdown_search');

    // ===== DATE VALIDATION =====
    var departInput = document.getElementById('depart_search');
    if (departInput) {
        var today = new Date().toISOString().split('T')[0];
        departInput.min = today;
    }
});

// ===== TOGGLE SEARCH FORM =====
function toggleSearchForm() {
    var summary = document.getElementById('searchSummaryView');
    var form = document.getElementById('searchFormView');
    if (form.style.display === 'none') {
        summary.style.display = 'none';
        form.style.display = 'block';
    } else {
        summary.style.display = 'flex';
        form.style.display = 'none';
    }
}

// ===== SORTING =====
function setSort(btn, sortType) {
    currentSort = sortType;
    document.querySelectorAll('.avx-sort-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    applyFilters();
}

// ===== FILTERING & SORTING LOGIC =====
function applyFilters() {
    var cards = document.querySelectorAll('.avx-flight-item');
    var container = document.getElementById('flightCardsContainer');

    // Collect active airline filters
    var airlineCheckboxes = document.querySelectorAll('#filterAirlines input[type="checkbox"]');
    var activeAirlines = [];
    airlineCheckboxes.forEach(function(cb) {
        if (cb.checked) activeAirlines.push(cb.value);
    });

    // Collect time filters
    var timeCheckboxes = document.querySelectorAll('.avx-filter-body input[type="checkbox"][value="dini_hari"], .avx-filter-body input[type="checkbox"][value="pagi"], .avx-filter-body input[type="checkbox"][value="siang"], .avx-filter-body input[type="checkbox"][value="malam"]');
    var activeTimes = [];
    timeCheckboxes.forEach(function(cb) {
        if (cb.checked) activeTimes.push(cb.value);
    });

    // Price range
    var minSlider = document.getElementById('priceMinSlider');
    var maxSlider = document.getElementById('priceMaxSlider');
    var priceMin = minSlider ? parseFloat(minSlider.value) : 0;
    var priceMax = maxSlider ? parseFloat(maxSlider.value) : Infinity;

    if (priceMin > priceMax) {
        var temp = priceMin;
        priceMin = priceMax;
        priceMax = temp;
    }

    updatePriceLabels();

    // Apply filters
    var visibleCards = [];
    cards.forEach(function(card) {
        var price = parseFloat(card.dataset.price);
        var airline = card.dataset.airline;
        var hour = parseInt(card.dataset.departHour);

        // Time category
        var timeCategory = 'dini_hari';
        if (hour >= 6 && hour < 12) timeCategory = 'pagi';
        else if (hour >= 12 && hour < 18) timeCategory = 'siang';
        else if (hour >= 18) timeCategory = 'malam';

        var show = true;
        if (activeAirlines.length > 0 && activeAirlines.indexOf(airline) === -1) show = false;
        if (price < priceMin || price > priceMax) show = false;
        if (activeTimes.length > 0 && activeTimes.indexOf(timeCategory) === -1) show = false;

        if (show) {
            card.classList.remove('avx-hidden');
            visibleCards.push(card);
        } else {
            card.classList.add('avx-hidden');
        }
    });

    // Sort visible cards
    visibleCards.sort(function(a, b) {
        switch (currentSort) {
            case 'price_asc':
                return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            case 'price_desc':
                return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            case 'duration_asc':
                return parseInt(a.dataset.duration) - parseInt(b.dataset.duration);
            case 'depart_asc':
                return a.dataset.departTime.localeCompare(b.dataset.departTime);
            case 'depart_desc':
                return b.dataset.departTime.localeCompare(a.dataset.departTime);
            default:
                return 0;
        }
    });

    // Reorder DOM
    visibleCards.forEach(function(card) {
        container.appendChild(card);
    });

    // Update count
    var countEl = document.getElementById('resultsCount');
    if (countEl) {
        countEl.innerHTML = '<i class="bi bi-airplane-fill me-1"></i><strong>' + visibleCards.length + '</strong> penerbangan ditemukan';
    }

    // Show/hide empty state
    var emptyFiltered = document.getElementById('emptyStateFiltered');
    var emptyOriginal = document.getElementById('emptyStateOriginal');
    if (visibleCards.length === 0 && cards.length > 0) {
        if (emptyFiltered) emptyFiltered.style.display = 'block';
    } else {
        if (emptyFiltered) emptyFiltered.style.display = 'none';
    }
}

function updatePriceLabels() {
    var minSlider = document.getElementById('priceMinSlider');
    var maxSlider = document.getElementById('priceMaxSlider');
    var minLabel = document.getElementById('priceMinLabel');
    var maxLabel = document.getElementById('priceMaxLabel');

    if (minSlider && maxSlider && minLabel && maxLabel) {
        minLabel.textContent = 'Rp ' + parseInt(minSlider.value).toLocaleString('id-ID');
        maxLabel.textContent = 'Rp ' + parseInt(maxSlider.value).toLocaleString('id-ID');
    }
}

function resetAllFilters() {
    // Reset airline checkboxes
    document.querySelectorAll('#filterAirlines input[type="checkbox"]').forEach(function(cb) {
        cb.checked = true;
    });

    // Reset time checkboxes
    document.querySelectorAll('.avx-filter-body input[type="checkbox"][value="dini_hari"], .avx-filter-body input[type="checkbox"][value="pagi"], .avx-filter-body input[type="checkbox"][value="siang"], .avx-filter-body input[type="checkbox"][value="malam"]').forEach(function(cb) {
        cb.checked = true;
    });

    // Reset price sliders
    if (allPrices.length > 0) {
        var minSlider = document.getElementById('priceMinSlider');
        var maxSlider = document.getElementById('priceMaxSlider');
        if (minSlider) minSlider.value = Math.min.apply(null, allPrices);
        if (maxSlider) maxSlider.value = Math.max.apply(null, allPrices);
    }

    // Reset sort
    currentSort = 'price_asc';
    document.querySelectorAll('.avx-sort-btn').forEach(function(b) { b.classList.remove('active'); });
    var defaultBtn = document.querySelector('.avx-sort-btn[data-sort="price_asc"]');
    if (defaultBtn) defaultBtn.classList.add('active');

    applyFilters();
}

function toggleFilterSection(el) {
    var section = el.closest('.avx-filter-section');
    section.classList.toggle('collapsed');
}

function toggleMobileFilter() {
    var sidebar = document.querySelector('.avx-filter-sidebar');
    sidebar.classList.toggle('avx-mobile-open');
}

// ===== AUTOCOMPLETE =====
function setupAutocompleteSearch(inputId, hiddenId, dropdownId) {
    var input = document.getElementById(inputId);
    var hidden = document.getElementById(hiddenId);
    var dropdown = document.getElementById(dropdownId);
    var timeout = null;

    if (!input || !hidden || !dropdown) return;

    input.addEventListener('input', function() {
        clearTimeout(timeout);
        var query = this.value;
        hidden.value = query;

        if (query.length < 2) {
            dropdown.style.display = 'none';
            return;
        }

        timeout = setTimeout(function() {
            fetch('/api/airports?query=' + encodeURIComponent(query))
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.length > 0) {
                        dropdown.innerHTML = '';
                        data.forEach(function(airport) {
                            var item = document.createElement('div');
                            item.className = 'avx-autocomplete-item';
                            item.innerHTML =
                                '<div class="avx-autocomplete-item-city">' + airport.city + ' (' + airport.code + ')</div>' +
                                '<div class="avx-autocomplete-item-airport">' + airport.name + '</div>';
                            item.addEventListener('click', function(e) {
                                e.stopPropagation();
                                e.preventDefault();
                                input.value = airport.city + ' (' + airport.code + ') - ' + airport.name;
                                hidden.value = airport.code;
                                dropdown.style.display = 'none';
                            });
                            dropdown.appendChild(item);
                        });
                        dropdown.style.display = 'block';
                    } else {
                        dropdown.style.display = 'none';
                    }
                })
                .catch(function() { dropdown.style.display = 'none'; });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/search.blade.php ENDPATH**/ ?>