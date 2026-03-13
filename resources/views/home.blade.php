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
        <div class="avx-rongga" aria-hidden="true"></div>

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
                    <input type="hidden" name="adults" id="hiddenAdults" value="1">
                    <input type="hidden" name="children" id="hiddenChildren" value="0">
                    <input type="hidden" name="infants" id="hiddenInfants" value="0">
                    <input type="hidden" name="passengers" id="hiddenPassengers" value="1">
                    <input type="hidden" name="travel_class" id="hiddenTravelClass" value="economy">
                    <div class="avx-search-main">
                        <!-- Dari -->
                        <label class="avx-field" for="from">
                            <span class="avx-field-label">Dari</span>
                            <div class="avx-input-wrap">
                                <svg class="avx-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M2 21l21-9L2 3v7l15 2-15 2z"/></svg>
                                <input id="from" name="from" placeholder="Kota atau Bandara" required>
                            </div>
                        </label>

                        <!-- Ke -->
                        <label class="avx-field" for="to">
                            <span class="avx-field-label">Ke</span>
                            <div class="avx-input-wrap">
                                <svg class="avx-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M2 21l21-9L2 3v7l15 2-15 2z"/></svg>
                                <input id="to" name="to" placeholder="Kota atau Bandara" required>
                            </div>
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
            
            <!-- BARIS BAWAH: Promo Text (di luar card) -->
            <h3 class="avx-promo"><i class="bi bi-tags-fill me-2" style="color: var(--avx-primary);"></i>Harga tiket Pesawat: Selalu Promo di Avoinex - PESAN SEKARANG!</h3>
        </section>

    {{-- flight results card list below hero --}}

    </main>
</div>

@if(isset($flights) && $flights->count())
    <section id="available-flights" class="flight-list-container">
        <div class="container mt-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        Available Flights ({{ $flights->count() }} found)
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($flights as $flight)
                    <div class="flight-card border rounded p-3 mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="airline-logo bg-primary text-white rounded-circle p-3 d-inline-block">
                                    {{ $flight->airline_code ?? 'GA' }}
                                </div>
                                <p class="mt-2 mb-0 fw-bold">{{ $flight->airline_name ?? 'Garuda Indonesia' }}</p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="mb-1">{{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}</h4>
                                <p class="text-muted mb-0">{{ $flight->schedule->originAirport->city }} ({{ $flight->schedule->originAirport->iata_code }})</p>
                                <small class="text-muted">{{ $flight->flight_date->format('d M') }}</small>
                            </div>
                            <div class="col-md-2 text-center">
                                <p class="mb-1">{{ floor($flight->schedule->duration_minutes / 60) }}h {{ $flight->schedule->duration_minutes % 60 }}m</p>
                                <div class="border-bottom"></div>
                                <p class="text-muted small mb-0">Direct</p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="mb-1">{{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}</h4>
                                <p class="text-muted mb-0">{{ $flight->schedule->destinationAirport->city }} ({{ $flight->schedule->destinationAirport->iata_code }})</p>
                                <small class="text-muted">{{ $flight->flight_date->format('d M') }}</small>
                            </div>
                            <div class="col-md-2 text-end" data-available-seats="{{ $flight->available_seats ?? 0 }}" data-flight-id="{{ $flight->flight_instance_id }}">
                                <h4 class="text-primary mb-1">${{ number_format($flight->schedule->base_price_usd, 0) }}</h4>
                                <p class="text-muted small mb-2">per person</p>

                                @php
                                    $availableSeats = $flight->available_seats ?? 0;
                                @endphp

                                <a href="{{ route('flight.seats', $flight->flight_instance_id) }}?adults=1&children=0&infants=0" class="btn btn-primary avx-select-btn avx-seat-link" data-seats="{{ $availableSeats }}" data-base-url="{{ route('flight.seats', $flight->flight_instance_id) }}">Select</a>
                                <button class="btn btn-secondary avx-limited-btn" style="display:none;" disabled title="Not enough seats available">
                                    <i class="bi bi-exclamation-circle"></i> Limited
                                </button>
                                <small class="text-danger d-block mt-1 avx-seats-warning" style="display:none;">Only {{ $availableSeats }} seat{{ $availableSeats != 1 ? 's' : '' }} left</small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p class="mb-0">
                                    <i class="bi bi-suitcase"></i> 20kg baggage •
                                    <i class="bi bi-utensils"></i> Meal included •
                                    <i class="bi bi-wifi"></i> Free Wi-Fi •
                                    <span class="badge bg-success">{{ $availableSeats }} seats available</span>
                                </p>
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
    min-height:100vh; 
    font-family: 'Segoe UI', system-ui, -apple-system, 'Helvetica Neue', Arial;
    background-color: #f0f0f0;
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
    /* cut the white background shorter so flight cards aren't pushed so far down */
    height: 60%;
    background: #ffffff;
    border-radius: 0; 
    /* move up slightly so the white area begins earlier */
    top: 40%;
    left: 0;
    z-index: 2;
    box-shadow: 0 -10px 40px rgba(0,0,0,0.05);
}

/* Main center area */
.avx-main{ 
    position:relative; 
    z-index: 5;
    display:flex; 
    align-items:center; 
    justify-content:center; 
    padding: 80px 24px 160px;
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
    /* PERUBAHAN: Dipusatkan secara horizontal dan vertikal */
    top: 29%;
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
    align-items: center; /* PERUBAHAN: Semua konten di tengah */
    margin-top: 300px;
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
        padding: 40px 16px 120px;
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
        /* Di mobile, text bisa center untuk readability yang lebih baik */
        text-align: center;
        width: calc(100% - 40px);
        margin-left: 20px;
        margin-right: 20px;
    }
    
    .avx-white-bg {
        top: 30%;
        height: 70%;
    }
    
    /* PERUBAHAN: Card transparan untuk mobile */
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
        padding: 30px 12px 100px;
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
    
    /* PERUBAHAN: Card transparan untuk mobile kecil */
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
    position: relative;
    z-index: 10;
    background: white;
    border-radius: 20px;
    padding: 30px;
    /* pull the flight list even higher so it's clearly visible under hero */
    margin-top: -250px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
    transform: translateY(-5px);
    transition: transform 0.3s ease;
    box-shadow: 0 10px 20px rgba(39, 158, 214, 0.15) !important;
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
            if (target === 'oneway') {
                document.getElementById('return').required = false;
            } else {
                document.getElementById('return').required = true;
            }
        });
    });

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

    // ===== INITIAL RENDER =====
    updatePassengerText();
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