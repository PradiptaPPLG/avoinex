@extends('layouts.app')

@section('title', 'Avoinex - Dashboard')

@section('content')
<!-- Dashboard Hero + Search -->
<div class="avx-hero">
    <!-- wallpaper alam FULL tanpa crop -->
    <div class="avx-hero-bg" aria-hidden="true"></div>

    <!-- Main content area -->
    <main class="avx-main">
        <!-- Background putih hanya bagian bawah -->
        <div class="avx-white-bg" aria-hidden="true"></div>
        
        <!-- Card transparan (rongga) DI ATAS -->
        <div class="avx-rongga" aria-hidden="true">
            @if(isset($heroFlashSales) && $heroFlashSales->count() > 0)
            <!-- FLASH SALE HERO BANNER -->
            <div class="avx-flash-hero-container px-4">
                @foreach($heroFlashSales as $flashSale)
                    @php
                        $basePrice = $flashSale->flightInstance->schedule->base_price_usd;
                        $discountedPrice = $flashSale->getDiscountedPrice($basePrice);
                        $remainingSeats = $flashSale->getRemainingSeats();
                        $seatsClaimed = $flashSale->seats_sold;
                        $totalSeats = $flashSale->max_seats;
                        $percentage = $totalSeats > 0 ? min(100, round(($seatsClaimed / $totalSeats) * 100)) : 0;
                        
                        $seatColorClass = 'text-success';
                        if ($remainingSeats < 10) $seatColorClass = 'text-warning';
                        if ($remainingSeats < 5) $seatColorClass = 'text-danger fw-bold';
                    @endphp
                    <div class="avx-flash-card w-100 flex-row justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-4">
                            <div class="avx-flash-badge mb-0">
                                <span class="pulse-dot"></span> FLASH SALE
                            </div>
                            <div class="avx-flash-route text-truncate mb-0" style="font-size: 24px;">
                                {{ $flashSale->flightInstance->schedule->originAirport->iata_code }} &rarr; {{ $flashSale->flightInstance->schedule->destinationAirport->iata_code }}
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-5">
                            <div class="avx-flash-prices text-end">
                                <span class="avx-flash-original d-block mb-1" style="font-size: 16px;">${{ number_format($basePrice, 0) }}</span>
                                <span class="avx-flash-discounted d-block" style="font-size: 32px;">${{ number_format($discountedPrice, 0) }}</span>
                            </div>
                            <div class="text-center">
                                <div class="avx-flash-timer avx-countdown mb-2 px-4 py-2" data-endtime="{{ $flashSale->end_time->toIso8601String() }}">
                                    <!-- JS WILL FILL THIS -->
                                </div>
                                <div class="avx-flash-seats w-100">
                                    <div class="avx-seat-text justify-content-center {{ $seatColorClass }}">
                                        @if($remainingSeats < 10) <i class="bi bi-fire"></i> Selling Fast! @endif
                                        {{ $remainingSeats }} seats left
                                    </div>
                                    <div class="avx-progress-wrap mx-auto" style="width: 80%;" title="{{ $seatsClaimed }} / {{ $totalSeats }} claimed">
                                        <div class="avx-progress-bar bg-danger" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        <section class="avx-search-wrap" role="region" aria-label="Search flights">
            <!-- Card utama DI BAWAH rongga -->
            <div class="avx-search-card">
                <!-- BARIS ATAS: Tabs + Options SEJAJAR -->
                <div class="avx-search-header">
                    <!-- Tabs -->
                    <nav class="avx-tabs" role="tablist" aria-label="flight types">
                        <button class="avx-tab avx-tab-active" data-tab="oneway" type="button"><i class="bi bi-arrow-right me-1"></i>Sekali Jalan</button>
                        <button class="avx-tab" data-tab="round" type="button"><i class="bi bi-arrow-left-right me-1"></i>Pulang-Pergi</button>
                        <button class="avx-tab" data-tab="multi" type="button"><i class="bi bi-signpost-split me-1"></i>Multi-Kota</button>
                        <button class="avx-tab text-danger" style="font-weight:700;" data-tab="promo" type="button"><i class="bi bi-tags-fill me-1"></i>Promo</button>
                    </nav>
                    
                    <!-- Options: Penerbangan Langsung + Passenger + Class -->
                    <div class="avx-header-options">
                        <!-- Checkbox Penerbangan Langsung -->
                        <label class="avx-checkbox-inline">
                            <input type="checkbox" name="direct" checked>
                            <span>Penerbangan Langsung</span>
                        </label>
                        
                        <!-- Passenger & Class -->
                        <div class="avx-passenger-class">
                            <button type="button" class="avx-passenger-toggle" id="passengerToggleBtn" aria-haspopup="true" aria-expanded="false">
                                <svg class="avx-icon-user" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zM2 20c0-3 6-5 10-5s10 2 10 5v1H2v-1z"/></svg>
                                <span class="avx-passenger-text" id="passengerSummaryText">1 Penumpang</span>
                                <svg class="avx-icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M7 10l5 5 5-5z"/></svg>
                            </button>
                            
                            <div class="avx-pax-dropdown" id="passengerDropdown" aria-hidden="true" style="display: none;">
                                <!-- Adults -->
                                <div class="avx-pax-row">
                                    <div class="avx-pax-info">
                                        <span class="avx-pax-label">Dewasa</span>
                                        <span class="avx-pax-desc">Usia 12 tahun ke atas</span>
                                    </div>
                                    <div class="avx-pax-stepper">
                                        <button type="button" class="avx-pax-btn avx-pax-minus" data-target="adults" aria-label="Kurangi dewasa">−</button>
                                        <span class="avx-pax-count" id="adultsCount">1</span>
                                        <button type="button" class="avx-pax-btn avx-pax-plus" data-target="adults" aria-label="Tambah dewasa">+</button>
                                    </div>
                                </div>
                                <!-- Children -->
                                <div class="avx-pax-row">
                                    <div class="avx-pax-info">
                                        <span class="avx-pax-label">Anak</span>
                                        <span class="avx-pax-desc">Usia 2 - 11 tahun</span>
                                    </div>
                                    <div class="avx-pax-stepper">
                                        <button type="button" class="avx-pax-btn avx-pax-minus" data-target="children" aria-label="Kurangi anak">−</button>
                                        <span class="avx-pax-count" id="childrenCount">0</span>
                                        <button type="button" class="avx-pax-btn avx-pax-plus" data-target="children" aria-label="Tambah anak">+</button>
                                    </div>
                                </div>
                                <!-- Infants -->
                                <div class="avx-pax-row">
                                    <div class="avx-pax-info">
                                        <span class="avx-pax-label">Bayi</span>
                                        <span class="avx-pax-desc">Di bawah 2 tahun</span>
                                    </div>
                                    <div class="avx-pax-stepper">
                                        <button type="button" class="avx-pax-btn avx-pax-minus" data-target="infants" aria-label="Kurangi bayi">−</button>
                                        <span class="avx-pax-count" id="infantsCount">0</span>
                                        <button type="button" class="avx-pax-btn avx-pax-plus" data-target="infants" aria-label="Tambah bayi">+</button>
                                    </div>
                                </div>
                                <!-- Done button -->
                                <div class="avx-pax-done-row">
                                    <button type="button" class="avx-pax-done-btn" id="paxDoneBtn">Selesai</button>
                                </div>
                            </div>
                            
                            <div class="avx-class-select-container">
                                <button type="button" class="avx-class-toggle" id="classToggleBtn" aria-haspopup="true" aria-expanded="false">
                                    <svg class="avx-icon-seat" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M4 18v3h3v-3h10v3h3v-6H4v3zm15-8h3v3h-3v-3zM2 10h3v3H2v-3zm15 3H7V5c0-1.1.9-2 2-2h6c1.1 0 2 .9 2 2v8z"/></svg>
                                    <span class="avx-class-text" id="classSummaryText">Ekonomi</span>
                                    <svg class="avx-icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M7 10l5 5 5-5z"/></svg>
                                </button>
                                
                                <div class="avx-class-dropdown" id="classDropdown" aria-hidden="true" style="display: none;">
                                    <button type="button" class="avx-class-option active" data-value="economy">
                                        <div class="avx-class-indicator"></div>
                                        <span>Ekonomi</span>
                                    </button>
                                    <button type="button" class="avx-class-option" data-value="premium">
                                        <div class="avx-class-indicator"></div>
                                        <span>Premium Economy</span>
                                    </button>
                                    <button type="button" class="avx-class-option" data-value="business">
                                        <div class="avx-class-indicator"></div>
                                        <span>Business</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BARIS TENGAH: Form Input -->
                <form class="avx-search-form" action="{{ route('flights.search') }}" method="GET">
                    <input type="hidden" name="tab" id="hiddenSearchTab" value="oneway">
                    <input type="hidden" name="adults" id="hiddenAdults" value="1">
                    <input type="hidden" name="children" id="hiddenChildren" value="0">
                    <input type="hidden" name="infants" id="hiddenInfants" value="0">
                    <input type="hidden" name="passengers" id="hiddenPassengers" value="1">
                    <input type="hidden" name="travel_class" id="hiddenTravelClass" value="economy">
                    <div class="avx-search-main">
                        <!-- Dari -->
                        <label class="avx-field" for="from_display" style="position: relative;">
                            <span class="avx-field-label">Dari</span>
                            <div class="avx-input-wrap">
                                <svg class="avx-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M2 21l21-9L2 3v7l15 2-15 2z"/></svg>
                                <input type="hidden" name="from" id="from">
                                <input id="from_display" name="from_display" placeholder="Kota atau Bandara" autocomplete="off" required>
                            </div>
                            <div class="avx-autocomplete-dropdown" id="from_dropdown" style="display: none;"></div>
                        </label>

                        <!-- Ke -->
                        <label class="avx-field" for="to_display" style="position: relative;">
                            <span class="avx-field-label">Ke</span>
                            <div class="avx-input-wrap">
                                <svg class="avx-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M2 21l21-9L2 3v7l15 2-15 2z"/></svg>
                                <input type="hidden" name="to" id="to">
                                <input id="to_display" name="to_display" placeholder="Kota atau Bandara" autocomplete="off" required>
                            </div>
                            <div class="avx-autocomplete-dropdown" id="to_dropdown" style="display: none;"></div>
                        </label>

                        <!-- Tanggal Pergi -->
                        <label class="avx-field" for="depart">
                            <span class="avx-field-label">Tanggal Pergi</span>
                            <div class="avx-input-wrap avx-input-date">
                                <input id="depart" name="depart" type="date" required>
                            </div>
                        </label>

                        <!-- Tanggal Pulang (default hidden, muncul saat tab Pulang-Pergi/Multi-Kota) -->
                        <label class="avx-field avx-return-field" for="return" style="display: none;">
                            <span class="avx-field-label">Tanggal Pulang</span>
                            <div class="avx-input-wrap avx-input-date">
                                <input id="return" name="return" type="date">
                            </div>
                        </label>

                        <!-- Tombol Cari Tiket -->
                        <button class="avx-cta" type="submit">
                            <span><i class="bi bi-search me-1"></i> Cari Tiket</span>
                        </button>
                    </div>
                </form>
            </div>
            
        </section>

    {{-- flight results card list below hero --}}

    </main>
</div>

@if(isset($secondaryFlashSales) && $secondaryFlashSales->count() > 0)
    <div class="avx-kupon-wrapper mt-5">
        <section id="avoinex-deals" class="container py-5">
            <h3 class="fw-bold mb-4 avx-kupon-title">Kupon Terbatas, SPESIAL UNTUKMU!</h3>
            
            <div class="avx-kupon-pills mb-4">
                <span class="avx-kupon-pill">Semua Promosi</span>
                <span class="avx-kupon-pill">Penerbangan Domestik</span>
                <span class="avx-kupon-pill">Penerbangan Internasional</span>
            </div>

            <div class="avx-kupon-scroll-container position-relative">
                <div class="avx-kupon-track d-flex gap-4 overflow-auto pb-4 pt-2 px-2" style="scrollbar-width: none;">
                    @foreach($secondaryFlashSales as $deal)
                        @php
                            $basePrice = $deal->flightInstance->schedule->base_price_usd;
                            $discountedPrice = $deal->getDiscountedPrice($basePrice);
                        @endphp
                        <div class="avx-kupon-card flex-shrink-0">
                            <div class="avx-kupon-top position-relative p-4">
                                <!-- Airline info -->
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    @if(isset($deal->flightInstance->schedule->airline->logo_path))
                                        <img src="{{ asset('logo_maskapai/' . $deal->flightInstance->schedule->airline->logo_path) }}" height="24" alt="Airline">
                                    @else
                                        <span class="badge bg-primary">{{ $deal->flightInstance->schedule->airline_code }}</span>
                                    @endif
                                    <span class="fw-semibold small text-muted">{{ $deal->flightInstance->schedule->airline->name ?? 'Airlines' }}</span>
                                </div>
                                
                                <h5 class="fw-bold mb-1 text-dark">
                                    {{ $deal->flightInstance->schedule->originAirport->city }} &rarr; {{ $deal->flightInstance->schedule->destinationAirport->city }}
                                </h5>
                                <p class="text-muted small mb-3">{{ $deal->flightInstance->flight_date->format('d M Y') }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1 border-0"><i class="bi bi-clock-history"></i> <span class="avx-countdown" data-endtime="{{ $deal->end_time->toIso8601String() }}"></span></span>
                                    <span class="badge bg-warning-subtle text-warning-emphasis border-0"><i class="bi bi-fire"></i> {{ $deal->getRemainingSeats() }} Seats Left</span>
                                </div>
                            </div>
                            
                            <div class="avx-kupon-divider">
                                <div class="avx-kupon-cutout-left shadow-inner"></div>
                                <div class="avx-kupon-line"></div>
                                <div class="avx-kupon-cutout-right shadow-inner"></div>
                            </div>
                            
                            <div class="avx-kupon-bottom p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-decoration-line-through text-muted small d-block" style="font-size: 0.85rem;">${{ number_format($basePrice, 0) }}</span>
                                    <span class="text-primary fw-bold fs-5">${{ number_format($discountedPrice, 0) }}</span>
                                </div>
                                <a href="{{ route('flights.search', [
                                        'tab' => 'promo',
                                        'from' => $deal->flightInstance->schedule->originAirport->iata_code,
                                        'to' => $deal->flightInstance->schedule->destinationAirport->iata_code,
                                        'depart' => $deal->flightInstance->flight_date->format('Y-m-d'),
                                        'adults' => 1
                                    ]) }}" class="btn avx-btn-light-blue fw-bold rounded-pill px-4">Gunakan</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($secondaryFlashSales->count() > 3)
                <button class="avx-kupon-nav-right shadow-sm" aria-label="Next deals">
                    <i class="bi bi-chevron-right text-primary fw-bold"></i>
                </button>
                @endif
            </div>
        </section>
    </div>
@endif

@if(isset($flights) && $flights->count())
    <section id="available-flights" class="flight-list-container">
        <!-- BARIS ATAS: Promo Text dipindah ke atas Available Flights -->
        <a href="#available-flights" class="text-decoration-none avx-hover-link mb-3 mx-auto" style="max-width: 1400px; padding: 0 24px;">
            <div class="avx-promo shadow-sm">
                <i class="bi bi-tags-fill avx-promo-icon me-2" style="color: var(--avx-primary); font-size: 1.25rem;"></i>
                <span class="mb-0">Harga tiket Pesawat: Selalu Promo di Avoinex - PESAN SEKARANG!</span>
            </div>
        </a>

        <div class="container mt-2">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        Available Flights ({{ $flights->count() }} found)
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($flights as $flight)
                    <div class="flight-card ticket-card">
                        <div class="ticket-top p-3">
                            <div class="row">
                            <div class="col-md-2 text-center d-flex align-items-center justify-content-center">
                                @if(isset($flight->schedule->airline->logo_path) && $flight->schedule->airline->logo_path)
                                    <div class="airline-logo rounded-circle shadow-sm overflow-hidden" style="width: 90px; height: 90px; background-color: #fff; border: 2px solid #e0e0e0; display: flex; align-items: center; justify-content: center; padding: 0;">
                                        <img src="{{ asset('logo_maskapai/' . $flight->schedule->airline->logo_path) }}" alt="{{ $flight->airline_name ?? 'Airline' }} Logo" style="width: 100%; height: 100%; object-fit: contain; padding: 5px;">
                                    </div>
                                @else
                                    <div class="airline-logo bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; font-size: 1.5rem; font-weight: bold;">
                                        {{ $flight->airline_code ?? 'GA' }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <h5 class="mb-0 fw-bold">{{ $flight->airline_name ?? 'Garuda Indonesia' }}</h5>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <h4 class="mb-1">{{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}</h4>
                                        <p class="text-muted mb-0">{{ $flight->schedule->originAirport->city }} ({{ $flight->schedule->originAirport->iata_code }})</p>
                                        <small class="text-muted">{{ $flight->flight_date->format('d M') }}</small>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <p class="mb-1">{{ floor($flight->schedule->duration_minutes / 60) }}h {{ $flight->schedule->duration_minutes % 60 }}m</p>
                                        <div class="border-bottom"></div>
                                        <p class="text-muted small mb-0">Direct</p>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="mb-1">{{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}</h4>
                                        <p class="text-muted mb-0">{{ $flight->schedule->destinationAirport->city }} ({{ $flight->schedule->destinationAirport->iata_code }})</p>
                                        <small class="text-muted">{{ $flight->flight_date->format('d M') }}</small>
                                    </div>
                                    <div class="col-md-3 text-end" data-available-seats="{{ $flight->available_seats ?? 0 }}" data-flight-id="{{ $flight->flight_instance_id }}">
                                        @php
                                            $availableSeats = $flight->available_seats ?? 0;
                                            $basePrice = $flight->schedule->base_price_usd;
                                            $hasFlashSale = isset($flight->active_flash_sale);
                                            $displayPrice = $hasFlashSale 
                                                ? $flight->active_flash_sale->getDiscountedPrice($basePrice)
                                                : $basePrice;
                                            $flashSaleSeats = $hasFlashSale 
                                                ? $flight->active_flash_sale->getRemainingSeats()
                                                : null;
                                        @endphp

                                        @if($hasFlashSale)
                                            <div class="mb-1">
                                                <span class="badge bg-danger" style="font-size:10px; letter-spacing:0.5px;">⚡ PROMO</span>
                                            </div>
                                            <span class="text-decoration-line-through text-muted small d-block">${{ number_format($basePrice, 0) }}</span>
                                            <h4 class="text-danger mb-0 fw-bold">${{ number_format($displayPrice, 0) }}</h4>
                                        @else
                                            <h4 class="text-primary mb-1">${{ number_format($basePrice, 0) }}</h4>
                                        @endif
                                        <p class="text-muted small mb-2">per person</p>

                                        <a href="{{ route('flight.seats', $flight->flight_instance_id) }}?adults=1&children=0&infants=0" class="btn btn-primary avx-select-btn avx-seat-link" data-seats="{{ $availableSeats }}" data-base-url="{{ route('flight.seats', $flight->flight_instance_id) }}">Select</a>
                                        <button class="btn btn-secondary avx-limited-btn" style="display:none;" disabled title="Not enough seats available">
                                            <i class="bi bi-exclamation-circle"></i> Limited
                                        </button>
                                        <small class="text-danger d-block mt-1 avx-seats-warning" style="display:none;">Only {{ $hasFlashSale ? $flashSaleSeats : $availableSeats }} {{ $hasFlashSale ? 'promo seat' : 'seat' }}{{ ($hasFlashSale ? $flashSaleSeats : $availableSeats) != 1 ? 's' : '' }} left</small>
                                    </div>
                                </div>
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
                                <p class="mb-0">
                                    <i class="bi bi-suitcase"></i> 20kg baggage •
                                    <i class="bi bi-utensils"></i> Meal included •
                                    <i class="bi bi-wifi"></i> Free Wi-Fi •
                                    <span class="badge bg-success">{{ isset($flashSaleSeats) ? $flashSaleSeats . ' promo seats' : $availableSeats . ' seats' }} available</span>
                                </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif


<!-- ===== CSS BARU DENGAN LAPISAN YANG BENAR ===== -->
<style>
/* Variables */
/* Variables */
/* Variables */
/* Variables */
/* Variables */
:root{
    --avx-primary: #279ED6;
    --avx-primary-65: rgba(39,158,214,0.65);
    --avx-link: #11549D;
    --avx-muted: #787878;
    --rongga: rgba(1,0,0,0.5);
}

/* SI GAMBARNYA FULL NGGA DI CROP */
.avx-hero{ 
    position:relative; 
    min-height: 580px;
    max-height: 580px;
    overflow: hidden;
    font-family: 'Segoe UI', system-ui, -apple-system, 'Helvetica Neue', Arial;
    background-color: #f0f0f0;
}

/* FLASH SALE HERO STYLES */
.avx-flash-hero-container {
    display: flex;
    z-index: 25;
    position: relative;
    top: 0;
    width: 100%;
    height: 100%;
    align-items: flex-start; /* Align top so it's not hidden behind search form */
    justify-content: center;
    padding-top: 24px;
}

.avx-flash-card {
    -webkit-backdrop-filter: blur(10px);
    border-radius: 50px;
    padding: 16px 40px;
    display: flex;
    color: white;
    width: 100%;
    background: transparent;
    border: none;
    box-shadow: none;
}

.avx-flash-card:hover {
    transform: none;
    box-shadow: none;
}

.avx-flash-badge {
    background: #ff3b3b;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 800;
    align-self: flex-start;
    display: flex;
    align-items: center;
    gap: 6px;
    letter-spacing: 1px;
}

.pulse-dot {
    width: 8px;
    height: 8px;
    background-color: white;
    border-radius: 50%;
    display: inline-block;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(255, 255, 255, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
}

.avx-flash-route {
    font-size: 18px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.avx-flash-prices {
    display: flex;
    align-items: baseline;
    gap: 10px;
}

.avx-flash-original {
    font-size: 14px;
    text-decoration: line-through;
    color: rgba(255,255,255,0.6);
}

.avx-flash-discounted {
    font-size: 24px;
    font-weight: 800;
    color: #ffd700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.avx-flash-timer {
    font-family: monospace;
    font-size: 16px;
    font-weight: bold;
    letter-spacing: 2px;
    background: rgba(0,0,0,0.3);
    padding: 8px;
    border-radius: 8px;
    text-align: center;
}

.avx-flash-seats {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.avx-seat-text {
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}

.avx-progress-wrap {
    width: 100%;
    height: 6px;
    background: rgba(255,255,255,0.2);
    border-radius: 3px;
    overflow: hidden;
}

.avx-progress-bar {
    height: 100%;
    border-radius: 3px;
    transition: width 0.5s ease;
}

/* Deal Card CSS - REDESIGNED KUPON LAYOUT */
.avx-kupon-wrapper {
    background-color: #f0fdf4; /* Pale green requested directly from template */
    width: 100%;
}
.avx-kupon-title {
    color: #1f2937;
    font-size: 1.5rem;
    letter-spacing: -0.02em;
}
.avx-kupon-pills {
    display: flex;
    gap: 12px;
}
.avx-kupon-pill {
    background-color: #dbeafe; /* Light blue */
    color: #60a5fa; /* Primary light blue text */
    padding: 8px 24px;
    border-radius: 99px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.avx-kupon-pill:hover {
    background-color: #bfdbfe;
    color: #3b82f6;
}
.avx-kupon-scroll-container {
    position: relative;
    padding-right: 20px;
}
.avx-kupon-track::-webkit-scrollbar {
    display: none;
}
.avx-kupon-card {
    width: 320px;
    background: transparent;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
}
.avx-kupon-top {
    background: #ffffff;
    border-radius: 16px 16px 0 0;
}
.avx-kupon-divider {
    height: 30px;
    display: flex;
    align-items: center;
    position: relative;
    background: #ffffff;
}
.avx-kupon-line {
    flex-grow: 1;
    border-top: 2px dashed #e5e7eb;
    margin: 0 24px;
    z-index: 1;
}
.avx-kupon-cutout-left,
.avx-kupon-cutout-right {
    width: 15px;
    height: 30px;
    background-color: #f0fdf4; /* Match wrapper background */
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    box-shadow: none; /* remove shadow */
    z-index: 2;
}
.avx-kupon-cutout-left {
    left: 0;
    border-radius: 0 30px 30px 0;
}
.avx-kupon-cutout-right {
    right: 0;
    border-radius: 30px 0 0 30px;
}

.avx-kupon-bottom {
    background: #ffffff;
    border-radius: 0 0 16px 16px;
}
.avx-btn-light-blue {
    background-color: #dbeafe;
    color: #3b82f6;
    border: none;
    transition: all 0.2s;
}
.avx-btn-light-blue:hover {
    background-color: #bfdbfe;
    color: #2563eb;
}
.avx-kupon-nav-right {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: transform 0.2s;
}
.avx-kupon-nav-right:hover {
    transform: translateY(-50%) scale(1.05);
}

/* REVISI UDAH BENER BANGET BANGET POKONYAMAH YANG TERAKHIRRR */
.avx-hero-bg{ 
    position:absolute; 
    inset:0; 
    background-image: url('{{ asset('images/wallpaperalam_01.png') }}'); 
    background-size: 100%;
    background-position: center -250px;
    background-repeat: no-repeat;
    background-color: #f0f0f0;
    z-index:1;
}

/* POKOKNYAMAH YANG INI UDAH TRANSPARENT BANGET NGET NGETTTT */
.avx-hero-bg::after{ 
    content:''; 
    position:absolute; 
    inset:0; 
    background: rgba(120,120,120,0.20);
}

/* PERUBAHAN 2: Background putih diperbesar dan diturunkan ke bawah */
.avx-white-bg {
    position: absolute;
    width: 100%;
    height: 100%;
    background: #ffffff;
    border-radius: 0; 
    top: 60%;
    left: 0;
    z-index: 2;
}

/* Main center area */
.avx-main{ 
    position:relative; 
    z-index: 5;
    display:flex; 
    align-items:center; 
    justify-content:center; 
    padding: 40px 24px 40px;
}

/* PERUBAHAN: Card transparan dipusatkan */
.avx-rongga{ 
    position:absolute; 
    width:calc(100% - 100px);
    max-width:1400px; 
    height:380px;
    border-radius:50px; 
    background: var(--rongga); 
    z-index: 6;
    top: 25%;
    left: 50%;
    transform: translateX(-50%);
    filter: blur(0.2px); 
}

/* Search wrap - PERUBAHAN: Diubah menjadi center untuk semua konten */
.avx-search-wrap{ 
    position:relative; 
    z-index: 7;
    width:100%; 
    display:flex; 
    flex-direction: column;
    align-items: center;
    margin-top: 190px;
}

/* Search card - PERUBAHAN: Card dipusatkan */
.avx-search-card{ 
    width:100%; 
    max-width:1400px;
    background:#ffffff; 
    border-radius:30px; 
    padding:36px 40px 40px;
    box-shadow: 
        0 25px 50px rgba(10,20,30,0.2),
        0 10px 30px rgba(0,0,0,0.15),
        0 0 0 1px #000000;
    position: relative;
    z-index: 8;
    margin-bottom: 24px;
    /* PERUBAHAN: Tambahkan margin auto untuk pusat horizontal */
    margin-left: auto;
    margin-right: auto;
}

/* ===== BARIS ATAS ===== */
.avx-search-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(120,120,120,0.15);
}

/* Tabs */
.avx-tabs{ 
    display:flex; 
    gap:10px; 
    margin:0;
}
.avx-tab{ 
    padding:12px 28px; 
    border-radius:30px; 
    background: rgba(39,158,214,0.30); 
    color: var(--avx-link); 
    font-weight:600; 
    border:none; 
    cursor:pointer; 
    font-family:'Segoe UI Semibold'; 
    font-size: 16px;
    white-space: nowrap;
    transition: all 0.3s ease;
}
.avx-tab:hover {
    background: rgba(39,158,214,0.45);
}
.avx-tab.avx-tab-active{ 
    background: rgba(39,158,214,0.65); 
    color:#11549D; 
    box-shadow: 0 4px 12px rgba(39,158,214,0.3);
}

/* Header Options */
.avx-header-options {
    display: flex;
    align-items: center;
    gap: 28px;
    flex-wrap: wrap;
}

/* Checkbox */
.avx-checkbox-inline{ 
    display:flex; 
    align-items:center; 
    gap:10px; 
    white-space: nowrap;
}
.avx-checkbox-inline input[type='checkbox']{ 
    width:20px; 
    height:20px; 
    accent-color: var(--avx-primary); 
    border-radius:6px; 
    background: rgba(39,158,214,0.30); 
}
.avx-checkbox-inline span{ 
    color: var(--avx-primary); 
    font-weight:600; 
    font-family:'Segoe UI Semibold'; 
    font-size: 16px;
}

.avx-promo {
    background: #ffffff;
    border-radius: 8px;
    padding: 16px 20px;
    color: #222;
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 16px 0;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    transition: all 0.2s ease;
    border: 1px solid #e5e7eb;
}
.avx-hover-link:hover .avx-promo {
    border-color: var(--avx-primary);
    box-shadow: 0 4px 12px rgba(39, 158, 214, 0.1);
}
.avx-hover-link {
    display: block;
    width: 100%;
    transition: transform 0.2s ease;
}
.avx-hover-link:hover {
    transform: translateY(-2px);
}
.avx-promo-icon {
    transform: rotate(45deg); /* Slight angle for the tag icon to match screenshot */
    display: inline-block;
}

.avx-passenger-class { 
    display:flex; 
    gap:14px; 
    align-items:center; 
    flex-wrap: wrap;
    position: relative;
    z-index: 100;
}
.avx-passenger-toggle, .avx-class-toggle { 
    display:inline-flex; 
    align-items:center; 
    gap:10px; 
    padding:0 22px; 
    height: 48px;
    border-radius:24px; 
    background:rgba(255,255,255,0.98); 
    border:1px solid rgba(120,120,120,0.25); 
    cursor:pointer; 
    white-space: nowrap;
    transition: all 0.25s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.avx-passenger-toggle:hover, .avx-class-toggle:hover, .avx-class-toggle:focus-within {
    border-color: var(--avx-primary);
    background: #ffffff;
    box-shadow: 0 4px 16px rgba(39,158,214,0.15);
    transform: translateY(-1px);
}
.avx-passenger-toggle .avx-icon-user, 
.avx-passenger-toggle .avx-icon-arrow,
.avx-class-toggle .avx-icon-seat,
.avx-class-toggle .avx-icon-arrow { 
    width:18px; 
    height:18px; 
    color:var(--avx-primary); 
}
.avx-passenger-text, .avx-class-text { 
    color: #333; 
    font-weight:600; 
    font-family:'Segoe UI Semibold', sans-serif; 
    font-size: 15px;
}

/* ===== BARIS TENGAH: FORM ===== */
.avx-search-form {
    display: block;
}

.avx-search-main {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
    align-items: end;
}

.avx-field{ 
    display:flex; 
    flex-direction:column; 
    gap:10px; 
}
.avx-field-label{ 
    color: var(--avx-link); 
    font-weight:600; 
    font-family:'Segoe UI Semibold';
    font-size: 15px;
}
.avx-input-wrap{ 
    display:flex; 
    align-items:center; 
    gap:12px; 
    padding:0 18px; 
    height: 56px;
    border-radius:12px; 
    border:1px solid rgba(120,120,120,0.35); 
    background: rgba(255,255,255,0.95);
    transition: all 0.3s ease;
    box-sizing: border-box;
}
.avx-input-wrap:hover {
    border-color: var(--avx-primary);
    box-shadow: 0 4px 12px rgba(39,158,214,0.1);
}
.avx-input-wrap .avx-icon{ 
    width:20px; 
    height:20px; 
    color:var(--avx-primary); 
    flex-shrink: 0;
}
.avx-input-wrap input{ 
    border:0; 
    outline:none; 
    background:transparent; 
    width:100%; 
    font-size:16px; 
    font-family:'Segoe UI',sans-serif; 
    color: #333;
}
.avx-input-date input[type="date"]{ 
    padding:0; 
    height: 100%;
    width: 100%;
}

/* CTA Button */
.avx-cta{ 
    background:var(--avx-primary); 
    color:#fff; 
    padding:16px 36px; 
    border-radius:12px; 
    border:none; 
    font-weight:700; 
    font-family:'Segoe UI Bold'; 
    cursor:pointer; 
    font-size: 17px;
    height: 56px;
    transition: all 0.3s ease;
    white-space: nowrap;
    box-shadow: 0 8px 20px rgba(39,158,214,0.3);
    grid-column: 5;
}
.avx-cta:hover {
    background: #1e8bc8;
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(39,158,214,0.4);
}

/* ===== BARIS BAWAH: PROMO TEXT ===== */
/* PERUBAHAN: Promo text disejajarkan dengan card transparan */
.avx-promo{ 
    margin-top: 28px;
    font-family: 'Poppins', 'Segoe UI', sans-serif; 
    font-weight:600; 
    color:#000; 
    text-align: left; /* Tetap left */
    font-size: 18px;
    padding: 18px 28px;
    background: rgba(255,255,255,0.95);
    border-radius: 12px;
    position: relative;
    z-index: 7;
    /* PERUBAHAN: Gunakan width yang sama dengan card transparan */
    width: calc(100% - 100px);
    max-width: 1400px;
    /* PERUBAHAN: Tidak lagi auto margin, tapi menggunakan left offset yang sama dengan card transparan */
    margin-left: 50px;
    margin-right: 50px;
}

/* ===== MODIFIKASI UNTUK TANGGAL PULANG ===== */
.avx-return-field {
    display: flex !important;
}

/* ===== AUTOCOMPLETE STYLES ===== */
.avx-autocomplete-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: #fff;
    border: 1px solid rgba(120,120,120,0.25);
    border-radius: 12px;
    margin-top: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    z-index: 1000;
    max-height: 300px;
    overflow-y: auto;
}
.avx-autocomplete-item {
    padding: 12px 18px;
    cursor: pointer;
    border-bottom: 1px solid rgba(120,120,120,0.1);
    font-family: 'Segoe UI', system-ui, sans-serif;
    color: #333;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.avx-autocomplete-item:last-child {
    border-bottom: none;
}
.avx-autocomplete-item:hover {
    background: rgba(39,158,214,0.1);
}
.avx-autocomplete-item:hover .avx-autocomplete-item-city {
    color: var(--avx-link);
}
.avx-autocomplete-item-city {
    font-weight: 600;
    font-size: 15px;
    transition: color 0.2s;
}
.avx-autocomplete-item-airport {
    font-size: 13px;
    color: var(--avx-muted);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1400px) {
    .avx-search-card {
        max-width: calc(100% - 100px);
        padding: 32px 36px 36px;
        margin-left: 50px;
        margin-right: 50px;
    }
    
    .avx-rongga {
        width: calc(100% - 100px);
        max-width: 1400px;
        top: 35%;
    }
    
    /* PERUBAHAN: Promo text sama dengan card transparan */
    .avx-promo {
        width: calc(100% - 100px);
        max-width: 1400px;
        margin-left: 50px;
        margin-right: 50px;
    }
}

@media (max-width: 1200px) {
    .avx-search-main {
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    
    .avx-cta {
        grid-column: 3;
    }
    
    .avx-search-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .avx-header-options {
        width: 100%;
        justify-content: space-between;
    }
    
    .avx-white-bg {
        height: 75%;
    }
    
    .avx-rongga {
        top: 32%;
    }
}

@media (max-width: 992px) {
    .avx-search-main {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .avx-cta {
        grid-column: 2;
    }
    
    .avx-main {
        padding: 60px 20px 140px;
    }
    
    .avx-search-card {
        max-width: calc(100% - 80px);
        padding: 28px 32px 32px;
        margin-left: 40px;
        margin-right: 40px;
    }
    
    /* PERUBAHAN: Sesuaikan untuk tablet */
    .avx-rongga {
        top: 30%;
        height: 360px;
        width: calc(100% - 80px);
    }
    
    /* PERUBAHAN: Promo text untuk tablet */
    .avx-promo {
        width: calc(100% - 80px);
        margin-left: 40px;
        margin-right: 40px;
        font-size: 17px;
    }
    
    .avx-hero-bg {
        background-size: 120% auto;
    }
}

@media (max-width: 768px) {
    .avx-main {
        padding: 40px 16px 30px;
    }
    
    .avx-search-main {
        grid-template-columns: 1fr;
    }
    
    .avx-cta {
        grid-column: 1;
        width: 100%;
    }
    
    .avx-header-options {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .avx-passenger-class {
        width: 100%;
        justify-content: space-between;
    }
    
    .avx-tabs {
        width: 100%;
        justify-content: center;
    }
    
    .avx-tab {
        flex: 1;
        text-align: center;
        padding: 10px 16px;
        font-size: 14px;
    }
    
    /* PERUBAHAN: Card untuk mobile */
    .avx-search-card {
        max-width: calc(100% - 40px);
        padding: 24px 28px 28px;
        margin-left: 20px;
        margin-right: 20px;
    }
    
    .avx-promo {
        font-size: 16px;
        padding: 14px 20px;
        text-align: center;
        width: calc(100% - 40px);
        margin-left: 20px;
        margin-right: 20px;
    }
    
    .avx-white-bg {
        top: 30%;
        height: 70%;
    }
    
    .avx-rongga {
        height: 320px;
        top: 28%;
        width: calc(100% - 40px);
    }
    
    .avx-search-wrap {
        margin-top: 20px;
    }
    
    .avx-hero-bg {
        background-size: 150% auto;
    }
}

@media (max-width: 480px) {
    .avx-main {
        padding: 30px 12px 20px;
    }
    
    .avx-search-card {
        max-width: calc(100% - 24px);
        padding: 20px;
        border-radius: 24px;
        margin-left: 12px;
        margin-right: 12px;
    }
    
    .avx-tab {
        padding: 8px 12px;
        font-size: 13px;
    }
    
    .avx-checkbox-inline span,
    .avx-passenger-text,
    .avx-class-select select {
        font-size: 14px;
    }
    
    .avx-promo {
        font-size: 15px;
        padding: 12px 16px;
        width: calc(100% - 24px);
        margin-left: 12px;
        margin-right: 12px;
    }
    
    .avx-white-bg {
        top: 25%;
        height: 75%;
    }
    
    .avx-rongga {
        top: 25%;
        height: 300px;
        width: calc(100% - 24px);
    }
    
    .avx-hero-bg {
        background-size: 180% auto;
        background-position: center 20%;
    }
}

/* ===== AVAILABLE FLIGHTS STYLES ===== */
#available-flights {
    background-color: #f8f9fa;
    padding-bottom: 60px;
}
.flight-card:hover {
    background-color: #f8f9fa;
    border-color: #0d6efd;
    cursor: pointer;
}
.airline-logo {
    width: 70px;
    height: 70px;
    line-height: 1;
    font-weight: bold;
    font-size: 1.3rem;
}
.flight-list-container > .container {
    position: relative;
    z-index: 10;
    background: white;
    border-radius: 20px;
    padding: 30px;
    /* pull the flight list even higher so it's clearly visible under hero */
    margin-top: -250px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

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
    background-color: #ffffff; /* Matches container white bg */
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

.dotted-line {
    border-top: 2px dotted #ccc;
    margin: 5px 0;
    position: relative;
    width: 50px;
    display: inline-block;
}

.dotted-line::before {
    content: '➝';
    position: absolute;
    left: 50%;
    top: -10px;
    transform: translateX(-50%);
    background: white;
    padding: 0 5px;
    color: #279ED6;
}

.card:hover {
    transform: none;
    box-shadow: none !important;
}

.bi {
    margin-right: 5px;
}

/* Pastikan konten available flights responsive */
@media (max-width: 768px) {
    #available-flights {
        margin-top: 0;
        padding: 20px 15px;
        border-radius: 15px;
    }
    
    .dotted-line {
        width: 30px;
    }
}

/* flight result card styling (same as search page) */
.flight-card:hover {
    background-color: #f8f9fa;
    border-color: #0d6efd;
    cursor: pointer;
}
.airline-logo {
    width: 60px;
    height: 60px;
    line-height: 1;
    font-weight: bold;
    font-size: 1.2rem;
}

/* ===== PASSENGER STEPPER DROPDOWN ===== */
.avx-pax-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    margin-top: 12px;
    background: #fff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.12), 0 0 0 1px rgba(0,0,0,0.04);
    border: none;
    z-index: 200;
    min-width: 320px;
}
.avx-pax-row {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0;
    border-bottom: 1px solid #f0f0f0;
    flex-wrap: nowrap;
    gap: 24px;
}
.avx-pax-row:last-of-type {
    border-bottom: none;
    padding-bottom: 0;
}
.avx-pax-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1 1 auto;
    white-space: nowrap;
}
.avx-pax-label {
    font-weight: 700;
    font-size: 16px;
    color: #222;
    font-family: 'Segoe UI Semibold', sans-serif;
}
.avx-pax-desc {
    font-size: 13px;
    color: #777;
    font-family: 'Segoe UI', sans-serif;
}
.avx-pax-stepper {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-shrink: 0;
    background: #f8f9fa;
    padding: 6px 12px;
    border-radius: 12px;
}
.avx-pax-dropdown .avx-pax-btn {
    width: 32px !important;
    height: 32px !important;
    min-width: 32px;
    border-radius: 50% !important;
    border: none !important;
    background: #fff !important;
    color: var(--avx-primary) !important;
    font-size: 18px !important;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06) !important;
    line-height: 1;
    padding: 0 !important;
    margin: 0;
    -webkit-appearance: none;
    appearance: none;
    outline: none;
    text-decoration: none;
}
.avx-pax-dropdown .avx-pax-btn:hover:not(:disabled) {
    background: var(--avx-primary) !important;
    color: #fff !important;
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(39,158,214,0.3) !important;
}
.avx-pax-dropdown .avx-pax-btn:disabled {
    background: #f0f0f0 !important;
    color: #b0b0b0 !important;
    box-shadow: none !important;
    cursor: not-allowed;
    opacity: 0.7;
}
.avx-pax-count {
    font-size: 16px;
    font-weight: 700;
    color: #222;
    min-width: 24px;
    text-align: center;
    font-family: 'Segoe UI Semibold', sans-serif;
}
.avx-pax-done-row {
    padding-top: 16px;
    text-align: right;
    border-top: 1px solid #f0f0f0;
    margin-top: 8px;
}
.avx-pax-done-btn {
    background: var(--avx-primary);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-size: 15px;
    font-weight: 600;
    font-family: 'Segoe UI Semibold', sans-serif;
    cursor: pointer;
    transition: all 0.2s ease;
    width: 100%;
    box-shadow: 0 4px 12px rgba(39,158,214,0.25);
}
/* ===== CLASS DROPDOWN ===== */
.avx-class-select-container {
    position: relative;
}
.avx-class-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    margin-top: 12px;
    background: #fff;
    border-radius: 16px;
    padding: 12px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.12), 0 0 0 1px rgba(0,0,0,0.04);
    border: none;
    z-index: 200;
    min-width: 240px;
    flex-direction: column;
    gap: 4px;
}
.avx-class-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 12px;
    background: transparent;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: 'Segoe UI Semibold', sans-serif;
    font-size: 15px;
    color: #333;
    font-weight: 600;
}
.avx-class-option:hover {
    background: #f8f9fa;
}
.avx-class-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #ccc;
    transition: all 0.2s ease;
}
.avx-class-option.active {
    background: rgba(39,158,214,0.08);
    color: var(--avx-primary);
}
.avx-class-option.active .avx-class-indicator {
    border-color: var(--avx-primary);
    background: var(--avx-primary);
    box-shadow: inset 0 0 0 2px #fff;
}
</style>

<script>
(function() {
    // ===== PASSENGER STATE =====
    var pax = { adults: 1, children: 0, infants: 0 };

    // DOM references
    var adultsCountEl   = document.getElementById('adultsCount');
    var childrenCountEl = document.getElementById('childrenCount');
    var infantsCountEl  = document.getElementById('infantsCount');
    var summaryTextEl   = document.getElementById('passengerSummaryText');
    var hiddenAdults    = document.getElementById('hiddenAdults');
    var hiddenChildren  = document.getElementById('hiddenChildren');
    var hiddenInfants   = document.getElementById('hiddenInfants');
    var hiddenPassengers = document.getElementById('hiddenPassengers');
    var hiddenTravelClass = document.getElementById('hiddenTravelClass');
    
    // Passenger elements
    var toggle          = document.getElementById('passengerToggleBtn');
    var dropdown        = document.getElementById('passengerDropdown');
    var doneBtn         = document.getElementById('paxDoneBtn');

    // Class elements
    var classToggle     = document.getElementById('classToggleBtn');
    var classDropdown   = document.getElementById('classDropdown');
    var classSummaryText = document.getElementById('classSummaryText');
    var classOptions    = document.querySelectorAll('.avx-class-option');

    // Class label mapping
    var classLabels = { economy: 'Economy', premium: 'Premium Economy', business: 'Business' };

    // ===== CORE: updatePassengerText =====
    function updatePassengerText() {
        var total = pax.adults + pax.children + pax.infants;

        // Update summary text
        summaryTextEl.textContent = total + ' Penumpang';

        // Update counter displays
        adultsCountEl.textContent = pax.adults;
        childrenCountEl.textContent = pax.children;
        infantsCountEl.textContent = pax.infants;

        // Sync hidden form inputs
        hiddenAdults.value = pax.adults;
        hiddenChildren.value = pax.children;
        hiddenInfants.value = pax.infants;
        hiddenPassengers.value = total;

        // Update button disabled states
        updateStepperStates();

        // Update flight card Select/Limited buttons
        updateFlightCards(total);
    }
    // Expose globally so the (function(){ ... })() IIFE can call it
    window.updatePassengerText = updatePassengerText;

    // ===== STEPPER BUTTON STATES =====
    function updateStepperStates() {
        var total = pax.adults + pax.children + pax.infants;

        // Adults: min 1, also cannot go below infants count
        setBtn('adults', 'minus', pax.adults > 1 && pax.adults > pax.infants);
        setBtn('adults', 'plus',  total < 9);

        // Children: min 0
        setBtn('children', 'minus', pax.children > 0);
        setBtn('children', 'plus',  total < 9);

        // Infants: min 0, max = adults count, and total < 9
        setBtn('infants', 'minus', pax.infants > 0);
        setBtn('infants', 'plus',  pax.infants < pax.adults && total < 9);
    }

    function setBtn(target, direction, enabled) {
        var selector = '.avx-pax-btn.avx-pax-' + direction + '[data-target="' + target + '"]';
        var btn = document.querySelector(selector);
        if (btn) btn.disabled = !enabled;
    }

    // ===== FLIGHT CARD DYNAMIC FILTERING =====
    function updateFlightCards(totalPassengers) {
        // Seats needed = adults + children (infants don't occupy seats)
        var seatsNeeded = pax.adults + pax.children;

        document.querySelectorAll('.avx-select-btn').forEach(function(selectBtn) {
            var seats = parseInt(selectBtn.getAttribute('data-seats'), 10) || 0;
            var parent = selectBtn.parentElement;
            var limitedBtn = parent.querySelector('.avx-limited-btn');
            var warning = parent.querySelector('.avx-seats-warning');

            if (seats >= seatsNeeded) {
                selectBtn.style.display = '';
                if (limitedBtn) limitedBtn.style.display = 'none';
                if (warning) warning.style.display = 'none';
            } else {
                selectBtn.style.display = 'none';
                if (limitedBtn) limitedBtn.style.display = '';
                if (warning) warning.style.display = '';
            }
        });

        // Update seat selection links with current passenger counts
        document.querySelectorAll('.avx-seat-link').forEach(function(link) {
            var baseUrl = link.getAttribute('data-base-url');
            if (baseUrl) {
                link.href = baseUrl + '?adults=' + pax.adults + '&children=' + pax.children + '&infants=' + pax.infants;
            }
        });
    }

    // ===== STEPPER CLICK HANDLERS =====
    document.querySelectorAll('.avx-pax-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            var target = this.getAttribute('data-target');
            var isPlus = this.classList.contains('avx-pax-plus');
            var total = pax.adults + pax.children + pax.infants;

            if (isPlus) {
                if (total >= 9) return;
                if (target === 'infants' && pax.infants >= pax.adults) return;
                pax[target]++;
            } else {
                if (target === 'adults' && pax.adults <= 1) return;
                if (target === 'adults' && pax.adults <= pax.infants) return;
                if (pax[target] <= 0) return;
                pax[target]--;
                // If adults decreased, check infants constraint
                if (target === 'adults' && pax.infants > pax.adults) {
                    pax.infants = pax.adults;
                }
            }

            updatePassengerText();
        });
    });

    // ===== TRAVEL CLASS CHANGE =====
    classOptions.forEach(function(opt) {
        opt.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Remove active class from all options
            classOptions.forEach(function(o) { o.classList.remove('active'); });
            
            // Add active class to clicked option
            this.classList.add('active');
            
            // Update hidden input and summary text
            var value = this.getAttribute('data-value');
            hiddenTravelClass.value = value;
            classSummaryText.textContent = classLabels[value] || 'Economy';
            
            // Close dropdown
            classDropdown.style.display = 'none';
            classToggle.setAttribute('aria-expanded', 'false');
            classDropdown.setAttribute('aria-hidden', 'true');
        });
    });

    // ===== DROPDOWN TOGGLES =====
    // Passenger Dropdown
    if (toggle && dropdown) {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            var expanded = toggle.getAttribute('aria-expanded') === 'true';
            
            // Close class dropdown if open
            if (classDropdown && classDropdown.style.display === 'flex') {
                classDropdown.style.display = 'none';
                classToggle.setAttribute('aria-expanded', 'false');
            }
            
            toggle.setAttribute('aria-expanded', String(!expanded));
            dropdown.style.display = expanded ? 'none' : 'block';
            dropdown.setAttribute('aria-hidden', String(expanded));
        });
    }

    // Class Dropdown
    if (classToggle && classDropdown) {
        classToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            var expanded = classToggle.getAttribute('aria-expanded') === 'true';
            
            // Close passenger dropdown if open
            if (dropdown && dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                toggle.setAttribute('aria-expanded', 'false');
            }
            
            classToggle.setAttribute('aria-expanded', String(!expanded));
            classDropdown.style.display = expanded ? 'none' : 'flex';
            classDropdown.setAttribute('aria-hidden', String(expanded));
        });
    }

    // Click outside closes both dropdowns
    document.addEventListener('click', function(ev) {
        if (toggle && dropdown && !toggle.contains(ev.target) && !dropdown.contains(ev.target)) {
            dropdown.style.display = 'none';
            toggle.setAttribute('aria-expanded', 'false');
            dropdown.setAttribute('aria-hidden', 'true');
        }
        
        if (classToggle && classDropdown && !classToggle.contains(ev.target) && !classDropdown.contains(ev.target)) {
            classDropdown.style.display = 'none';
            classToggle.setAttribute('aria-expanded', 'false');
            classDropdown.setAttribute('aria-hidden', 'true');
        }
    });

    // Stop propagation inside dropdown
    if (dropdown) {
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Done button closes dropdown
    if (doneBtn) {
        doneBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.style.display = 'none';
            toggle.setAttribute('aria-expanded', 'false');
            dropdown.setAttribute('aria-hidden', 'true');
        });
    }

    // ===== TABS =====
    document.querySelectorAll('.avx-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.avx-tab').forEach(function(b) { b.classList.remove('avx-tab-active'); });
            btn.classList.add('avx-tab-active');

            var target = btn.getAttribute('data-tab');
            document.getElementById('hiddenSearchTab').value = target;

            if (target === 'oneway' || target === 'promo') {
                document.getElementById('return').required = false;
            } else {
                document.getElementById('return').required = true;
            }
        });
    });

    // ===== FLASH SALE COUNTDOWN =====
    var serverTimeStr = "{{ $serverTime ?? now()->toIso8601String() }}";
    var serverTime = new Date(serverTimeStr).getTime();
    var clientTimeAtLoad = new Date().getTime();
    
    function updateCountdowns() {
        var nowClient = new Date().getTime();
        var elapsed = nowClient - clientTimeAtLoad;
        var currentServerTime = serverTime + elapsed;
        
        document.querySelectorAll('.avx-countdown').forEach(function(el) {
            var endStr = el.getAttribute('data-endtime');
            if(!endStr) return;
            var endTime = new Date(endStr).getTime();
            var diff = endTime - currentServerTime;
            
            if (diff <= 0) {
                el.innerHTML = "EXPIRED";
                // possibly hide the card if it's in the hero section
                var card = el.closest('.avx-flash-card');
                if (card) card.style.display = 'none';
                return;
            }
            
            var h = Math.floor(diff / (1000 * 60 * 60));
            var m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var s = Math.floor((diff % (1000 * 60)) / 1000);
            
            el.innerHTML = (h < 10 ? "0"+h : h) + " : " + (m < 10 ? "0"+m : m) + " : " + (s < 10 ? "0"+s : s);
        });
    }
    
    if (document.querySelectorAll('.avx-countdown').length > 0) {
        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    }

    // ===== DATE VALIDATION =====
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('depart').min = today;
    document.getElementById('return').min = today;

    document.getElementById('depart').addEventListener('change', function() {
        var returnInput = document.getElementById('return');
        returnInput.min = this.value;
        if (returnInput.value && returnInput.value < this.value) {
            returnInput.value = this.value;
        }
    });

    // ===== AUTOCOMPLETE =====
    function setupAutocomplete(inputId, hiddenId, dropdownId) {
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
                fetch('/api/airports/autocomplete?q=' + encodeURIComponent(query))
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (data.length > 0) {
                            dropdown.innerHTML = '';
                            data.forEach(function(airport) {
                                var item = document.createElement('div');
                                item.className = 'avx-autocomplete-item';
                                item.innerHTML = 
                                    '<div class="avx-autocomplete-item-city">' + airport.city + ' (' + airport.iata_code + ')</div>' +
                                    '<div class="avx-autocomplete-item-airport">' + airport.airport_name + '</div>';
                                
                                item.addEventListener('click', function(e) {
                                    e.stopPropagation();
                                    input.value = airport.city + ' (' + airport.iata_code + ') - ' + airport.airport_name;
                                    hidden.value = airport.iata_code;
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

    setupAutocomplete('from_display', 'from', 'from_dropdown');
    setupAutocomplete('to_display', 'to', 'to_dropdown');

    // ===== INITIAL RENDER =====
    updatePassengerText();

    // ===== KUPON HORIZONTAL SCROLL =====
    var kuponNavBtn = document.querySelector('.avx-kupon-nav-right');
    var kuponTrack = document.querySelector('.avx-kupon-track');
    if(kuponNavBtn && kuponTrack) {
        kuponNavBtn.addEventListener('click', function() {
            // Scroll by roughly the width of one card + gap
            kuponTrack.scrollBy({ left: 340, behavior: 'smooth' });
        });
    }
})();
</script>

<!-- ===== MODAL JS ===== -->
<script>
(function(){
    // Helper function untuk mendapatkan element by ID
    function $(id){ return document.getElementById(id); }
    
    // Fungsi untuk menampilkan modal
    function showOverlay(id) {
        const el = $(id + 'Modal');
        if(!el) return;
        el.style.display = 'flex';
        el.setAttribute('aria-hidden','false');
        document.body.style.overflow = 'hidden';
        
        // Focus ke element pertama yang dapat difokus
        const focusable = el.querySelector('button, a, input, [tabindex]:not([tabindex="-1"])');
        if(focusable) focusable.focus();
    }
    
    // Fungsi untuk menyembunyikan modal
    function hideOverlay(id) {
        const el = $(id + 'Modal');
        if(!el) return;
        el.style.display = 'none';
        el.setAttribute('aria-hidden','true');
        document.body.style.overflow = '';
        
        // Reset form email
        const loginForm = $('emailLoginForm');
        const regForm = $('emailRegisterForm');
        if(loginForm) loginForm.style.display = 'none';
        if(regForm) regForm.style.display = 'none';
    }
    
    // Fungsi untuk toggle form email login
    window.toggleEmailLogin = function(){
        const f = $('emailLoginForm');
        if(!f) return;
        
        if (f.style.display === 'block' || f.style.display === '') {
            f.style.display = 'none';
        } else {
            f.style.display = 'block';
            // Focus ke input pertama
            const input = f.querySelector('input[name="identifier"]');
            if(input) input.focus();
        }
    };
    
    // Fungsi untuk toggle form email register
    window.toggleEmailRegister = function(){
        const f = $('emailRegisterForm');
        if(!f) return;
        
        if (f.style.display === 'block' || f.style.display === '') {
            f.style.display = 'none';
        } else {
            f.style.display = 'block';
            // Focus ke input pertama
            const input = f.querySelector('input[name="first_name"]');
            if(input) input.focus();
        }
    };

    // Expose functions ke window object
    window.showModal = function(type){ showOverlay(type); };
    window.closeModal = function(type){ hideOverlay(type); };
    
    window.switchModal = function(from, to){
        hideOverlay(from);
        setTimeout(function(){ showOverlay(to); }, 160);
    };
    
    // Placeholder untuk login sosial media
    window.handleFacebookLogin = function(){ 
        alert('Facebook login flow - akan diimplementasikan'); 
    };
    window.handleAppleLogin = function(){ 
        alert('Apple login flow - akan diimplementasikan'); 
    };
    window.handleFacebookRegister = function(){ 
        alert('Facebook register flow - akan diimplementasikan'); 
    };
    window.handleAppleRegister = function(){ 
        alert('Apple register flow - akan diimplementasikan'); 
    };
    
    // Close modal ketika klik di luar konten modal
    document.addEventListener('click', function(e){
        const overlays = document.querySelectorAll('.avx-modal-overlay');
        overlays.forEach(function(ov){
            if(ov.style.display !== 'none' && e.target === ov) {
                const id = ov.id.replace('Modal','');
                hideOverlay(id);
            }
        });
    });
    
    // Close modal dengan tombol Escape
    document.addEventListener('keydown', function(e){
        if(e.key === 'Escape' || e.key === 'Esc') {
            const open = document.querySelector('.avx-modal-overlay[style*="display: flex"]');
            if(open) {
                const id = open.id.replace('Modal','');
                hideOverlay(id);
            }
        }
    });
    
    // Auto-show modal jika ada error dari server
    document.addEventListener('DOMContentLoaded', function(){
        @if(session('error'))
            showOverlay('login');
            setTimeout(function(){ 
                toggleEmailLogin(); 
            }, 250);
        @endif

        @if($errors->any())
            showOverlay('register');
            setTimeout(function(){ 
                toggleEmailRegister(); 
            }, 250);
        @endif
    });
})();
</script>
@endsection