@extends('layouts.app')

@section('content')
@php
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
    $econStart = $prefEnabled ? ($prefEnd + 1) : ($businessRows + 1);
@endphp
<div class="container mt-4">
    <!-- Flight Info -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 class="text-primary">{{ $flight->schedule->flight_number }}</h5>
                    <p class="mb-0">
                        <strong>{{ $flight->schedule->originAirport->city }} ({{ $flight->schedule->originAirport->iata_code }})</strong>
                        →
                        <strong>{{ $flight->schedule->destinationAirport->city }} ({{ $flight->schedule->destinationAirport->iata_code }})</strong>
                    </p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><strong>Date:</strong> {{ $flight->flight_date->format('d M Y') }}</p>
                    <p class="mb-1"><strong>Departure:</strong> {{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}</p>
                    <p class="mb-1"><strong>Arrival:</strong> {{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}</p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><strong>Aircraft:</strong> {{ $flight->aircraftInstance->aircraft->aircraft_model }}</p>
                    <p class="mb-1"><strong>Duration:</strong> {{ floor($flight->schedule->duration_minutes/60) }}h {{ $flight->schedule->duration_minutes%60 }}m</p>
                </div>
                <div class="col-md-2 text-end">
                    <span class="badge bg-primary fs-6">{{ $flight->schedule->flight_number }}</span>
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
                        Select exactly <strong>{{ $requiredSeats }}</strong> seat{{ $requiredSeats > 1 ? 's' : '' }} for
                        <strong>{{ $adults }}</strong> Adult{{ $adults > 1 ? 's' : '' }}
                        @if($children > 0)
                            + <strong>{{ $children }}</strong> Child{{ $children > 1 ? 'ren' : '' }}
                        @endif
                        @if($infants > 0)
                            <span class="text-muted">(+ {{ $infants }} Infant{{ $infants > 1 ? 's' : '' }}, no seat needed)</span>
                        @endif
                    </p>
                </div>
                <div class="text-end">
                    <div class="seat-counter-badge">
                        <span id="seat-counter">0</span> / {{ $requiredSeats }}
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
            <img src="{{ asset('images/Avoinex_Plane_Front Plane.png') }}" 
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
                            @if($businessRows > 0)
                            <div class="d-flex align-items-center">
                                <div class="seat-legend business me-2"></div>
                                <span>Business Class</span>
                            </div>
                            @endif
                            @if($prefEnabled)
                            <div class="d-flex align-items-center">
                                <div class="seat-legend preferred me-2"></div>
                                <span>Preferred (Extra Legroom)</span>
                            </div>
                            @endif
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

                {{-- =============================== --}}
                {{-- BUSINESS CLASS SECTION           --}}
                {{-- =============================== --}}
                @if($businessRows > 0)
                <div class="business-section mb-5">
                    <h5 class="text-warning mb-3">
                        <i class="bi bi-star-fill"></i> Business Class
                        <small class="text-muted ms-2">Rows 1-{{ $businessRows }}</small>
                    </h5>
                    
                    <div class="seat-map">
                        @for($row = 1; $row <= $businessRows; $row++)
                            <div class="seat-row d-flex justify-content-center align-items-center mb-2">
                                <div class="row-number me-2 fw-bold text-warning">{{ $row }}</div>
                                
                                {{-- Left side --}}
                                @foreach($leftLetters as $letter)
                                    @php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatId = $seat ? $seat['seat_id'] : 'b_' . $row . $letter;
                                        $price = $seat ? $seat['price'] : 250.00;
                                    @endphp
                                    <div class="seat m-1">
                                        @if($isAvailable)
                                            <div class="seat-item" 
                                                 data-seat-id="{{ $seatId }}"
                                                 data-seat-number="{{ $seatNumber }}"
                                                 data-price="{{ $price }}"
                                                 data-class="business">
                                                <div class="seat-number">{{ $seatNumber }}</div>
                                                <div class="seat-price">${{ number_format($price, 2) }}</div>
                                            </div>
                                        @else
                                            <div class="seat-unavailable">
                                                {{ $seatNumber }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                <!-- AISLE -->
                                <div class="aisle mx-3 d-flex align-items-center justify-content-center">
                                    <div class="aisle-line"></div>
                                </div>
                                
                                {{-- Right side --}}
                                @foreach($rightLetters as $letter)
                                    @php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatId = $seat ? $seat['seat_id'] : 'b_' . $row . $letter;
                                        $price = $seat ? $seat['price'] : 250.00;
                                    @endphp
                                    <div class="seat m-1">
                                        @if($isAvailable)
                                            <div class="seat-item" 
                                                 data-seat-id="{{ $seatId }}"
                                                 data-seat-number="{{ $seatNumber }}"
                                                 data-price="{{ $price }}"
                                                 data-class="business">
                                                <div class="seat-number">{{ $seatNumber }}</div>
                                                <div class="seat-price">${{ number_format($price, 2) }}</div>
                                            </div>
                                        @else
                                            <div class="seat-unavailable">
                                                {{ $seatNumber }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                <div class="row-number ms-2 fw-bold text-warning">{{ $row }}</div>
                            </div>
                        @endfor
                    </div>
                </div>
                @endif

                {{-- =============================== --}}
                {{-- PREFERRED ZONE (Extra Legroom)   --}}
                {{-- =============================== --}}
                @if($prefEnabled)
                <div class="preferred-section mb-5">
                    {{-- Premium Header --}}
                    <div class="preferred-header mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="preferred-icon-badge">
                                <i class="bi bi-arrows-angle-expand"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 preferred-title">PREFERRED ZONE</h5>
                                <small class="preferred-subtitle">Rows {{ $prefStart }}-{{ $prefEnd }} • Extra legroom seats</small>
                            </div>
                            <span class="preferred-badge ms-auto">
                                <i class="bi bi-gem"></i> EXTRA LEGROOM
                            </span>
                        </div>
                    </div>

                    {{-- Legroom indicator --}}
                    <div class="legroom-indicator mb-3">
                        <div class="d-flex justify-content-center gap-4 align-items-center">
                            <div class="legroom-item">
                                <i class="bi bi-arrows-expand text-info"></i>
                                <span>+8cm legroom</span>
                            </div>
                            <div class="legroom-item">
                                <i class="bi bi-lightning-charge text-info"></i>
                                <span>Priority boarding</span>
                            </div>
                            <div class="legroom-item">
                                <i class="bi bi-headset text-info"></i>
                                <span>Premium amenities</span>
                            </div>
                        </div>
                    </div>

                    <div class="preferred-seat-area">
                        @for($row = $prefStart; $row <= $prefEnd; $row++)
                            <div class="seat-row d-flex justify-content-center align-items-center mb-2">
                                <div class="row-number me-2 fw-bold preferred-row-num">{{ $row }}</div>
                                
                                @foreach($leftLetters as $letter)
                                    @php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatId = $seat ? $seat['seat_id'] : 'p_' . $row . $letter;
                                        $price = $seat ? $seat['price'] : 180.00;
                                    @endphp
                                    <div class="seat m-1">
                                        @if($isAvailable)
                                            <div class="seat-item preferred-seat" 
                                                 data-seat-id="{{ $seatId }}"
                                                 data-seat-number="{{ $seatNumber }}"
                                                 data-price="{{ $price }}"
                                                 data-class="preferred">
                                                <div class="seat-number">{{ $seatNumber }}</div>
                                                <div class="seat-price">${{ number_format($price, 2) }}</div>
                                                <div class="legroom-icon"><i class="bi bi-arrows-expand"></i></div>
                                            </div>
                                        @else
                                            <div class="seat-unavailable">
                                                {{ $seatNumber }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                <!-- AISLE with premium styling -->
                                <div class="aisle mx-3 d-flex align-items-center justify-content-center">
                                    <div class="aisle-preferred">
                                        <div class="aisle-preferred-line"></div>
                                        <div class="aisle-preferred-dot"></div>
                                    </div>
                                </div>
                                
                                @foreach($rightLetters as $letter)
                                    @php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatId = $seat ? $seat['seat_id'] : 'p_' . $row . $letter;
                                        $price = $seat ? $seat['price'] : 180.00;
                                    @endphp
                                    <div class="seat m-1">
                                        @if($isAvailable)
                                            <div class="seat-item preferred-seat" 
                                                 data-seat-id="{{ $seatId }}"
                                                 data-seat-number="{{ $seatNumber }}"
                                                 data-price="{{ $price }}"
                                                 data-class="preferred">
                                                <div class="seat-number">{{ $seatNumber }}</div>
                                                <div class="seat-price">${{ number_format($price, 2) }}</div>
                                                <div class="legroom-icon"><i class="bi bi-arrows-expand"></i></div>
                                            </div>
                                        @else
                                            <div class="seat-unavailable">
                                                {{ $seatNumber }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                <div class="row-number ms-2 fw-bold preferred-row-num">{{ $row }}</div>
                            </div>
                        @endfor
                    </div>
                </div>
                @endif

                {{-- =============================== --}}
                {{-- ECONOMY CLASS SECTION            --}}
                {{-- =============================== --}}
                <div class="economy-section">
                    <h5 class="text-success mb-3">
                        <i class="bi bi-person-fill"></i> Economy Class
                        <small class="text-muted ms-2">Rows {{ $econStart }}-{{ $totalRows }}</small>
                    </h5>
                    
                    <div class="seat-map">
                        @for($row = $econStart; $row <= $totalRows; $row++)
                            <div class="seat-row d-flex justify-content-center align-items-center mb-2">
                                <div class="row-number me-2 fw-bold">{{ $row }}</div>
                                
                                {{-- Left side --}}
                                @foreach($leftLetters as $letter)
                                    @php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatId = $seat ? $seat['seat_id'] : 'e_' . $row . $letter;
                                        $price = $seat ? $seat['price'] : 150.00;
                                    @endphp
                                    <div class="seat m-1">
                                        @if($isAvailable)
                                            <div class="seat-item" 
                                                 data-seat-id="{{ $seatId }}"
                                                 data-seat-number="{{ $seatNumber }}"
                                                 data-price="{{ $price }}"
                                                 data-class="economy">
                                                <div class="seat-number">{{ $seatNumber }}</div>
                                                <div class="seat-price">${{ number_format($price, 2) }}</div>
                                            </div>
                                        @else
                                            <div class="seat-unavailable">
                                                {{ $seatNumber }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                <!-- AISLE -->
                                <div class="aisle mx-3 d-flex align-items-center justify-content-center">
                                    <div class="aisle-line"></div>
                                </div>
                                
                                {{-- Right side --}}
                                @foreach($rightLetters as $letter)
                                    @php
                                        $seatNumber = $row . $letter;
                                        $seat = $availableSeats[$seatNumber] ?? null;
                                        $isAvailable = $seat ? $seat['is_available'] : true;
                                        $seatId = $seat ? $seat['seat_id'] : 'e_' . $row . $letter;
                                        $price = $seat ? $seat['price'] : 150.00;
                                    @endphp
                                    <div class="seat m-1">
                                        @if($isAvailable)
                                            <div class="seat-item" 
                                                 data-seat-id="{{ $seatId }}"
                                                 data-seat-number="{{ $seatNumber }}"
                                                 data-price="{{ $price }}"
                                                 data-class="economy">
                                                <div class="seat-number">{{ $seatNumber }}</div>
                                                <div class="seat-price">${{ number_format($price, 2) }}</div>
                                            </div>
                                        @else
                                            <div class="seat-unavailable">
                                                {{ $seatNumber }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                <div class="row-number ms-2 fw-bold">{{ $row }}</div>
                            </div>
                        @endfor
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
            <img src="{{ asset('images/Avoinex_Plane_Back Plane.png') }}" 
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
        <h4>Total: <span id="total-price" class="text-primary fw-bold">$0.00</span></h4>
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

<form id="hidden-form" method="POST" action="{{ route('flight.book', ['id' => $flight->flight_instance_id]) }}" style="display: none;">
    @csrf
    <input type="hidden" name="selected_seats" id="selected-seats-hidden" value="">
    <input type="hidden" name="total_price" id="total-price-hidden" value="0">
</form>
        </div>
    </div>
</div>

<style>
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
    background: #007bff;
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

<script>
// SEAT SELECTION LOGIC WITH PASSENGER LIMIT ENFORCEMENT
console.log('=== SEAT SELECTION PAGE LOADING ===');

const REQUIRED_SEATS = {{ $requiredSeats ?? 1 }};
const ADULTS = {{ $adults ?? 1 }};
const CHILDREN = {{ $children ?? 0 }};
const INFANTS = {{ $infants ?? 0 }};

console.log(`📋 Required seats: ${REQUIRED_SEATS} (${ADULTS} adults + ${CHILDREN} children, ${INFANTS} infants)`);

let selectedSeats = [];
let totalPrice = 0;

function initializeSeatSelection() {
    console.log('🔄 Initializing seat selection...');
    selectedSeats = [];
    totalPrice = 0;
    updateUI();
    console.log('✅ Initialization complete');
}

document.addEventListener('click', function(event) {
    if (event.target.closest('.seat-item')) {
        const seatElement = event.target.closest('.seat-item');
        // Block clicks on disabled seats
        if (seatElement.classList.contains('seat-disabled')) {
            return;
        }
        handleSeatClick(seatElement);
    }
    if (event.target.closest('#clear-seats')) {
        handleClearSeats();
    }
    if (event.target.closest('#continue-btn')) {
        handleContinueBooking();
    }
});

function handleSeatClick(seatElement) {
    const seatId = seatElement.dataset.seatId;
    const seatNumber = seatElement.dataset.seatNumber;
    const price = parseFloat(seatElement.dataset.price);
    
    console.log(`🪑 Seat clicked: ${seatNumber} ($${price})`);
    
    if (seatElement.classList.contains('selected')) {
        // Deselect
        seatElement.classList.remove('selected');
        selectedSeats = selectedSeats.filter(s => s.id !== seatId);
        totalPrice -= price;
        console.log(`➖ Deselected: ${seatNumber}`);
    } else {
        // Check against required seats limit
        if (selectedSeats.length >= REQUIRED_SEATS) {
            alert(`You can only select ${REQUIRED_SEATS} seat${REQUIRED_SEATS > 1 ? 's' : ''} for your ${ADULTS + CHILDREN} passenger${(ADULTS + CHILDREN) > 1 ? 's' : ''} (${ADULTS} Adult${ADULTS > 1 ? 's' : ''}${CHILDREN > 0 ? ' + ' + CHILDREN + ' Child' + (CHILDREN > 1 ? 'ren' : '') : ''}).`);
            return;
        }
        seatElement.classList.add('selected');
        selectedSeats.push({
            id: seatId,
            number: seatNumber,
            price: price
        });
        totalPrice += price;
        console.log(`➕ Selected: ${seatNumber} (${selectedSeats.length}/${REQUIRED_SEATS})`);
    }
    
    updateUI();
}

function toggleSeatDisabledState() {
    const allSeatItems = document.querySelectorAll('.seat-item');
    if (selectedSeats.length >= REQUIRED_SEATS) {
        // Disable all unselected seats
        allSeatItems.forEach(seat => {
            if (!seat.classList.contains('selected')) {
                seat.classList.add('seat-disabled');
            }
        });
    } else {
        // Re-enable all disabled seats
        allSeatItems.forEach(seat => {
            seat.classList.remove('seat-disabled');
        });
    }
}

function handleClearSeats() {
    if (selectedSeats.length === 0) {
        alert('No seats to clear');
        return;
    }
    
    if (confirm('Clear all selected seats?')) {
        document.querySelectorAll('.seat-item.selected').forEach(seat => {
            seat.classList.remove('selected');
        });
        selectedSeats = [];
        totalPrice = 0;
        console.log('🗑️ All seats cleared');
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
    console.log('✈️ Flight ID:', {{ $flight->flight_instance_id }});
    
    continueBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Redirecting...';
    continueBtn.disabled = true;
    
    setTimeout(() => {
        try {
            localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
            localStorage.setItem('totalPrice', totalPrice);
            localStorage.setItem('flightId', {{ $flight->flight_instance_id }});
            
            sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
            sessionStorage.setItem('totalPrice', totalPrice);
            sessionStorage.setItem('flightId', {{ $flight->flight_instance_id }});
            
            console.log('💾 Data saved to storage');
        } catch (e) {
            console.log('⚠️ Could not save to storage:', e);
        }
        
        const params = new URLSearchParams();
        params.set('seats', JSON.stringify(selectedSeats));
        params.set('total', totalPrice);
        params.set('flight_id', {{ $flight->flight_instance_id }});
        params.set('adults', ADULTS);
        params.set('children', CHILDREN);
        params.set('infants', INFANTS);

        const redirectUrl = '{{ route("booking.form") }}?' + params.toString();
        console.log('🔗 Redirect URL:', redirectUrl);

        window.location.href = redirectUrl;
        
    }, 500);
}

function updateUI() {
    console.log('🎨 Updating UI...');
    
    // Update total price display
    const totalElement = document.getElementById('total-price');
    if (totalElement) {
        totalElement.textContent = '$' + totalPrice.toFixed(2);
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
        html += `
            <div class="col-md-4 mb-2">
                <div class="border rounded p-2 bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="fs-5">${seat.number}</strong>
                            <div class="small text-muted">Passenger ${index + 1}</div>
                        </div>
                        <div class="text-end">
                            <span class="text-primary fw-bold">$${seat.price.toFixed(2)}</span>
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
@endsection