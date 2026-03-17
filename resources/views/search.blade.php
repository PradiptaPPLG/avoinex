@extends('layouts.app')

@section('title', 'Search Results - Avoinex')

@section('content')
<div class="container mt-4">
    <!-- Search Summary Card (Click to Modify) -->
    <div class="card mb-4 avx-search-summary-card">
        <div class="card-body">
            <!-- Summary View (Default) -->
            <div id="searchSummaryView" class="row align-items-center" style="cursor: pointer;" onclick="toggleSearchForm()">
                <div class="col-md-3">
                    <small class="text-muted">FROM</small>
                    <h5 class="mb-0">{{ $origin->city ?? 'Jakarta' }} ({{ $origin->iata_code ?? 'CGK' }})</h5>
                    <p class="text-muted mb-0">{{ $origin->airport_name ?? 'Soekarno-Hatta Intl' }}</p>
                </div>
                <div class="col-md-1 text-center text-muted">
                    <i class="bi bi-arrow-right fs-4"></i>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">TO</small>
                    <h5 class="mb-0">{{ $destination->city ?? 'Denpasar' }} ({{ $destination->iata_code ?? 'DPS' }})</h5>
                    <p class="text-muted mb-0">{{ $destination->airport_name ?? 'Ngurah Rai Intl' }}</p>
                </div>
                <div class="col-md-2">
                    <small class="text-muted">DEPARTURE</small>
                    <h5 class="mb-0">{{ date('d M Y', strtotime($searchParams['depart'] ?? now())) }}</h5>
                </div>
                <div class="col-md-2">
                    <small class="text-muted">PASSENGERS</small>
                    <h5 class="mb-0">
                        @php
                            $totalPax = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0) + ($searchParams['infants'] ?? 0);
                        @endphp
                        {{ $totalPax }} Passenger{{ $totalPax > 1 ? 's' : '' }}
                    </h5>
                </div>
                <div class="col-md-1 text-end">
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3">Ubah Pencarian</button>
                </div>
            </div>

            <!-- Edit Form View (Hidden by default) -->
            <div id="searchFormView" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-search me-2"></i>Ubah Pencarian</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="toggleSearchForm()"></button>
                </div>
                
                <form class="avx-search-form" action="{{ route('flights.search') }}" method="GET">
                    <input type="hidden" name="tab" value="oneway">
                    <input type="hidden" name="adults" value="{{ $searchParams['adults'] ?? 1 }}">
                    <input type="hidden" name="children" value="{{ $searchParams['children'] ?? 0 }}">
                    <input type="hidden" name="infants" value="{{ $searchParams['infants'] ?? 0 }}">
                    <input type="hidden" name="passengers" value="{{ $totalPax ?? 1 }}">
                    <input type="hidden" name="travel_class" value="economy">
                    
                    <div class="avx-search-main">
                        <!-- Dari -->
                        <label class="avx-field position-relative" for="from_display_search" style="z-index: 10;">
                            <span class="avx-field-label text-muted small fw-bold">DARI</span>
                            <div class="avx-input-wrap">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <input type="hidden" name="from" id="from_search" value="{{ $searchParams['from'] ?? '' }}">
                                <input id="from_display_search" name="from_display" placeholder="Kota atau Bandara" autocomplete="off" required 
                                       value="{{ isset($origin) ? $origin->city . ' (' . $origin->iata_code . ') - ' . $origin->airport_name : '' }}">
                            </div>
                            <div class="avx-autocomplete-dropdown" id="from_dropdown_search" style="display: none;"></div>
                        </label>

                        <!-- Swap Button -->
                        <div class="avx-swap-container" style="display: flex; align-items: flex-end; justify-content: center; padding-bottom: 8px;">
                            <button type="button" class="avx-swap-btn" id="swapLocationsBtnSearch" aria-label="Swap locations" title="Swap locations">
                                <i class="bi bi-arrow-left-right"></i>
                            </button>
                        </div>

                        <!-- Ke -->
                        <label class="avx-field position-relative" for="to_display_search" style="z-index: 9;">
                            <span class="avx-field-label text-muted small fw-bold">KE</span>
                            <div class="avx-input-wrap">
                                <i class="bi bi-geo text-primary me-2"></i>
                                <input type="hidden" name="to" id="to_search" value="{{ $searchParams['to'] ?? '' }}">
                                <input id="to_display_search" name="to_display" placeholder="Kota atau Bandara" autocomplete="off" required
                                       value="{{ isset($destination) ? $destination->city . ' (' . $destination->iata_code . ') - ' . $destination->airport_name : '' }}">
                            </div>
                            <div class="avx-autocomplete-dropdown" id="to_dropdown_search" style="display: none;"></div>
                        </label>

                        <!-- Tanggal Pergi -->
                        <label class="avx-field" for="depart_search">
                            <span class="avx-field-label text-muted small fw-bold">TANGGAL PERGI</span>
                            <div class="avx-input-wrap avx-input-date">
                                <input id="depart_search" name="depart" type="date" required value="{{ $searchParams['depart'] ?? '' }}">
                            </div>
                        </label>

                        <!-- Tombol Cari Tiket -->
                        <button class="btn btn-primary avx-cta-search w-100 mt-4 h-100" type="submit" style="min-height: 56px; border-radius: 12px; font-weight: bold;">
                            <i class="bi bi-search me-1"></i> Cari Tiket
                        </button>
                    </div>
                </form>
            </div>
        </div>
            <div class="row">
                <div class="col-md-3">
                    <small class="text-muted">FROM</small>
                    <h5 class="mb-0">{{ $origin->city ?? 'Jakarta' }} ({{ $origin->iata_code ?? 'CGK' }})</h5>
                    <p class="text-muted mb-0">{{ $origin->airport_name ?? 'Soekarno-Hatta Intl' }}</p>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">TO</small>
                    <h5 class="mb-0">{{ $destination->city ?? 'Denpasar' }} ({{ $destination->iata_code ?? 'DPS' }})</h5>
                    <p class="text-muted mb-0">{{ $destination->airport_name ?? 'Ngurah Rai Intl' }}</p>
                </div>
                <div class="col-md-2">
                    <small class="text-muted">DEPARTURE</small>
                    <h5 class="mb-0">{{ date('d M Y', strtotime($searchParams['depart'] ?? now())) }}</h5>
                </div>
                <div class="col-md-2">
                    <small class="text-muted">PASSENGERS</small>
                    <h5 class="mb-0">
                        @php
                            $totalPax = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0) + ($searchParams['infants'] ?? 0);
                        @endphp
                        {{ $totalPax }} Passenger{{ $totalPax > 1 ? 's' : '' }}
                    </h5>
                </div>
                <div class="col-md-2">
                    <small class="text-muted">CLASS</small>
                    <h5 class="mb-0">Economy</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Flight Results -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                Available Flights ({{ $flights->count() }} found)
                <small class="text-muted">Sorted by Price</small>
            </h5>
        </div>
        <div class="card-body">
            @if($flights->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">No flights found</h4>
                    <p class="text-muted">Try adjusting your search criteria</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">New Search</a>
                </div>
            @else
                @foreach($flights as $flight)
                <div class="flight-card ticket-card">
                    <div class="ticket-top p-3">
                        <div class="row align-items-center">
                        <div class="col-md-2 d-flex flex-column align-items-center gap-2">
                            @if(isset($flight->schedule->airline->logo_path) && $flight->schedule->airline->logo_path)
                                <div class="airline-logo rounded-circle shadow-sm overflow-hidden flex-shrink-0" style="background-color: #fff; border: 2px solid #e0e0e0; display: flex; align-items: center; justify-content: center; padding: 0;">
                                    <img src="{{ asset('logo_maskapai/' . $flight->schedule->airline->logo_path) }}" alt="{{ $flight->airline_name ?? 'Airline' }} Logo" style="width: 100%; height: 100%; object-fit: contain; padding: 5px;">
                                </div>
                            @else
                                <div class="airline-logo bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                    {{ $flight->airline_code ?? 'GA' }}
                                </div>
                            @endif
                            <p class="mb-0 fw-bold text-center">{{ $flight->airline_name ?? 'Garuda Indonesia' }}</p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="mb-1">{{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}</h4>
                            <p class="text-muted mb-0">{{ $flight->schedule->originAirport->city }} ({{ $flight->schedule->originAirport->iata_code }})</p>
                            <small class="text-muted">{{ $flight->flight_date->format('d M') }}</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <p class="mb-1">{{ floor($flight->schedule->duration_minutes / 60) }}h {{ $flight->schedule->duration_minutes % 60 }}m</p>
                            <div class="border-bottom"></div>
                            <p class="text-muted small mb-0">Direct</p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="mb-1">{{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}</h4>
                            <p class="text-muted mb-0">{{ $flight->schedule->destinationAirport->city }} ({{ $flight->schedule->destinationAirport->iata_code }})</p>
                            <small class="text-muted">{{ $flight->flight_date->format('d M') }}</small>
                        </div>
                        <div class="col-md-3 text-end">
                            @php
                                $availableSeats = $flight->available_seats ?? 0;
                                $passengerCount = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0);
                                $hasEnoughSeats = $availableSeats >= $passengerCount;
                                $basePrice = $flight->schedule->base_price_usd;
                                $displayPrice = isset($flight->active_flash_sale) 
                                    ? $flight->active_flash_sale->getDiscountedPrice($basePrice)
                                    : $basePrice;
                            @endphp

                            @if(isset($flight->active_flash_sale))
                                <div class="mb-1">
                                    <span class="badge bg-danger" style="font-size:10px; letter-spacing:0.5px;">⚡ PROMO</span>
                                </div>
                                <span class="text-decoration-line-through text-muted small d-block">${{ number_format($basePrice, 0) }}</span>
                                <h4 class="text-danger mb-0 fw-bold">${{ number_format($displayPrice, 0) }}</h4>
                            @else
                                <h4 class="text-primary mb-1">${{ number_format($basePrice, 0) }}</h4>
                            @endif
                            <p class="text-muted small mb-2">per person</p>
                            
                            @if($hasEnoughSeats)
                                <a href="{{ route('flight.seats', $flight->flight_instance_id) }}?adults={{ $searchParams['adults'] ?? 1 }}&children={{ $searchParams['children'] ?? 0 }}&infants={{ $searchParams['infants'] ?? 0 }}" class="btn btn-primary px-4">Select</a>
                            @else
                                <button class="btn btn-secondary" disabled title="Not enough seats available">
                                    <i class="bi bi-exclamation-circle"></i> Limited
                                </button>
                                <small class="text-danger d-block mt-1">Only {{ $availableSeats }} seat{{ $availableSeats != 1 ? 's' : '' }} left</small>
                            @endif
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
                                @php
                                    $flashSaleSeatsRemaining = isset($flight->active_flash_sale) 
                                        ? $flight->active_flash_sale->getRemainingSeats() 
                                        : null;
                                @endphp
                                <span class="badge bg-success ms-3">{{ isset($flashSaleSeatsRemaining) ? $flashSaleSeatsRemaining . ' promo seats' : $availableSeats . ' seats' }} available</span>
                            </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<style>
.flight-card.ticket-card {
    background: transparent;
    display: flex;
    flex-direction: column;
    border: none;
    box-shadow: none !important;
    transition: none !important;
    margin-bottom: 24px;
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
    background-color: #ffffff;
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
    width: 70px;
    height: 70px;
    line-height: 1;
    font-weight: bold;
    font-size: 1.3rem;
}

/* ===== SEARCH FORM & AUTOCOMPLETE STYLES (Search Page) ===== */
.avx-search-main {
    display: grid;
    grid-template-columns: 1fr 40px 1fr 1fr 1fr;
    gap: 16px;
    align-items: end;
}

.avx-field { 
    display:flex; 
    flex-direction:column; 
    gap:8px; 
}

.avx-input-wrap { 
    display:flex; 
    align-items:center; 
    padding:0 16px; 
    height: 56px;
    border-radius:12px; 
    border:1px solid rgba(120,120,120,0.35); 
    background: #fff;
    transition: all 0.3s ease;
}

.avx-input-wrap:focus-within {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
}

.avx-input-wrap input { 
    border:0; 
    outline:none; 
    background:transparent; 
    width:100%; 
    font-size:15px; 
    color: #333;
}

.avx-input-date input[type="date"] { 
    padding:0; 
    height: 100%;
    width: 100%;
}

.avx-swap-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid rgba(120,120,120,0.35);
    color: var(--bs-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    z-index: 15;
}

.avx-swap-btn:hover {
    border-color: var(--bs-primary);
    background: #f8fcfd;
    box-shadow: 0 6px 15px rgba(13, 110, 253, 0.15);
    transform: scale(1.05);
}

.avx-swap-btn i {
    font-size: 18px;
    transition: transform 0.4s ease;
}

.avx-swap-btn.swapping i {
    transform: rotate(180deg);
}

.avx-autocomplete-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: #fff;
    border: 1px solid rgba(120,120,120,0.25);
    border-radius: 12px;
    margin-top: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    z-index: 9999;
    max-height: 250px;
    overflow-y: auto;
}

.avx-autocomplete-item {
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid rgba(120,120,120,0.1);
    color: #333;
    display: flex;
    flex-direction: column;
    gap: 2px;
    position: relative;
    z-index: 10000;
}

.avx-autocomplete-item:hover {
    background: rgba(13, 110, 253, 0.08);
}

.avx-autocomplete-item-city {
    font-weight: 600;
    font-size: 14px;
    transition: color 0.2s;
}

.avx-autocomplete-item:hover .avx-autocomplete-item-city {
    color: var(--bs-primary);
}

.avx-autocomplete-item-airport {
    font-size: 12px;
    color: #6c757d;
}

/* Search Summary Hover effect */
.avx-search-summary-card {
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

#searchSummaryView:hover h5 {
    color: var(--bs-primary);
}

@media (max-width: 992px) {
    .avx-search-main {
        grid-template-columns: 1fr 40px 1fr;
    }
    .avx-cta-search {
        grid-column: span 3;
    }
    .avx-field[for="depart_search"] {
        grid-column: span 3;
    }
}

@media (max-width: 768px) {
    .avx-search-main {
        grid-template-columns: 1fr;
    }
    .avx-swap-container {
        transform: rotate(90deg);
        padding-bottom: 0;
        margin: -8px 0;
        z-index: 20;
    }
    .avx-cta-search, .avx-field[for="depart_search"] {
        grid-column: 1;
    }
}
</style>

@push('scripts')
<script>
    // ===== TOGGLE SEARCH FORM =====
    function toggleSearchForm() {
        var summary = document.getElementById('searchSummaryView');
        var form = document.getElementById('searchFormView');
        
        if(form.style.display === 'none') {
            summary.style.display = 'none';
            form.style.display = 'block';
        } else {
            summary.style.display = 'flex';
            form.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
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
                    console.log("Autocomplete Fetching:", '/api/airports?query=' + encodeURIComponent(query));
                    fetch('/api/airports?query=' + encodeURIComponent(query))
                        .then(function(res) { 
                            console.log("Autocomplete Response Status:", res.status);
                            return res.json(); 
                        })
                        .then(function(data) {
                            console.log("Autocomplete Data:", data);
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
                                        console.log("Autocomplete Clicked:", airport.code);
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
                        .catch(function(err) {
                            console.error('Autocomplete fetch error:', err);
                            dropdown.style.display = 'none';
                        });
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }

        setupAutocompleteSearch('from_display_search', 'from_search', 'from_dropdown_search');
        setupAutocompleteSearch('to_display_search', 'to_search', 'to_dropdown_search');

        // ===== SWAP LOCATIONS =====
        var swapBtn = document.getElementById('swapLocationsBtnSearch');
        if (swapBtn) {
            swapBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add animation class
                this.classList.add('swapping');
                setTimeout(() => this.classList.remove('swapping'), 400);

                var fromDisplay = document.getElementById('from_display_search');
                var fromValue = document.getElementById('from_search');
                var toDisplay = document.getElementById('to_display_search');
                var toValue = document.getElementById('to_search');

                // Swap display values
                var tempDisplay = fromDisplay.value;
                fromDisplay.value = toDisplay.value;
                toDisplay.value = tempDisplay;

                // Swap hidden values
                var tempValue = fromValue.value;
                fromValue.value = toValue.value;
                toValue.value = tempValue;

                // Add highlight animation to inputs
                [fromDisplay.parentElement, toDisplay.parentElement].forEach(el => {
                    el.style.borderColor = 'var(--bs-primary)';
                    el.style.boxShadow = '0 0 0 4px rgba(13, 110, 253, 0.1)';
                    setTimeout(() => {
                        el.style.borderColor = '';
                        el.style.boxShadow = '';
                    }, 400);
                });
            });
        }
        
        // ===== DATE VALIDATION =====
        var departInput = document.getElementById('depart_search');
        if(departInput) {
            var today = new Date().toISOString().split('T')[0];
            departInput.min = today;
        }
    });

</script>
@endpush
@endsection