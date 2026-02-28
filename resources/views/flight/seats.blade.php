@extends('layouts.app')

@section('content')
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
                            <div class="d-flex align-items-center">
                                <div class="seat-legend business me-2"></div>
                                <span>Business Class</span>
                            </div>
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

                <!-- BUSINESS CLASS SECTION -->
                <div class="business-section mb-5">
                    <h5 class="text-warning mb-3">
                        <i class="bi bi-star-fill"></i> Business Class
                        <small class="text-muted ms-2">Rows 1-2</small>
                    </h5>
                    
                    <div class="seat-map">
                        @for($row = 1; $row <= 2; $row++)
                            <div class="seat-row d-flex justify-content-center align-items-center mb-2">
                                <div class="row-number me-2 fw-bold text-warning">{{ $row }}</div>
                                
                                <!-- A, B, C -->
                                @foreach(['A', 'B', 'C'] as $letter)
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
                                
                                <!-- D, E, F -->
                                @foreach(['D', 'E', 'F'] as $letter)
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

                <!-- PREFERRED ZONE (Extra Legroom) -->
                <div class="preferred-section mb-4 p-3 bg-light-blue rounded">
                    <div class="section-header mb-3">
                        <h6 class="text-primary mb-0">
                            <i class="bi bi-arrows-angle-expand"></i> PREFERRED ZONE
                            <small class="text-muted ms-2">Rows 3-5 • Extra legroom seats</small>
                        </h6>
                    </div>
                    
                    @for($row = 3; $row <= 5; $row++)
                        <div class="seat-row d-flex justify-content-center align-items-center mb-2">
                            <div class="row-number me-2 fw-bold text-primary">{{ $row }}</div>
                            
                            @foreach(['A', 'B', 'C'] as $letter)
                                @php
                                    $seatNumber = $row . $letter;
                                    $seat = $availableSeats[$seatNumber] ?? null;
                                    $isAvailable = $seat ? $seat['is_available'] : true;
                                    $seatId = $seat ? $seat['seat_id'] : 'p_' . $row . $letter;
                                    $price = $seat ? $seat['price'] : 180.00;
                                @endphp
                                <div class="seat m-1">
                                    @if($isAvailable)
                                        <div class="seat-item" 
                                             data-seat-id="{{ $seatId }}"
                                             data-seat-number="{{ $seatNumber }}"
                                             data-price="{{ $price }}"
                                             data-class="preferred">
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
                            <div class="aisle mx-3 d-flex align-items-center">
                                <div class="aisle-mark">↔<br><small>AISLE</small></div>
                            </div>
                            
                            @foreach(['D', 'E', 'F'] as $letter)
                                @php
                                    $seatNumber = $row . $letter;
                                    $seat = $availableSeats[$seatNumber] ?? null;
                                    $isAvailable = $seat ? $seat['is_available'] : true;
                                    $seatId = $seat ? $seat['seat_id'] : 'p_' . $row . $letter;
                                    $price = $seat ? $seat['price'] : 180.00;
                                @endphp
                                <div class="seat m-1">
                                    @if($isAvailable)
                                        <div class="seat-item" 
                                             data-seat-id="{{ $seatId }}"
                                             data-seat-number="{{ $seatNumber }}"
                                             data-price="{{ $price }}"
                                             data-class="preferred">
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
                            
                            <div class="row-number ms-2 fw-bold text-primary">{{ $row }}</div>
                        </div>
                    @endfor
                </div>

                <!-- ECONOMY CLASS SECTION -->
                <div class="economy-section">
                    <h5 class="text-success mb-3">
                        <i class="bi bi-person-fill"></i> Economy Class
                        <small class="text-muted ms-2">Rows 6-30</small>
                    </h5>
                    
                    <div class="seat-map">
                        @for($row = 6; $row <= 30; $row++)
                            <div class="seat-row d-flex justify-content-center align-items-center mb-2">
                                <div class="row-number me-2 fw-bold">{{ $row }}</div>
                                
                                <!-- A, B, C -->
                                @foreach(['A', 'B', 'C'] as $letter)
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
                                
                                <!-- D, E, F -->
                                @foreach(['D', 'E', 'F'] as $letter)
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
            <!-- GANTI BAGIAN INI: -->
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4>Total: <span id="total-price" class="text-primary fw-bold">$0.00</span></h4>
        <p class="text-muted mb-0"><small>Prices include all taxes and fees</small></p>
    </div>
    <div>
        <button class="btn btn-outline-danger me-2" id="clear-seats">
            <i class="bi bi-x-circle"></i> Clear All
        </button>
        
        <!-- HAPUS FORM INI DAN GANTI DENGAN: -->
        <button type="button" class="btn btn-success btn-lg" id="continue-btn" disabled>
            <i class="bi bi-arrow-right"></i> Continue to Booking
        </button>
    </div>
</div>

<!-- TAMBAHKAN HIDDEN FORM UNTUK CSRF -->
<form id="hidden-form" method="POST" action="{{ route('flight.book', ['id' => $flight->flight_instance_id]) }}" style="display: none;">
    @csrf
    <input type="hidden" name="selected_seats" id="selected-seats-hidden" value="">
    <input type="hidden" name="total_price" id="total-price-hidden" value="0">
</form>
                </div>
            </div>
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

.preferred-section .seat-item {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border-color: #90caf9;
}

.economy-section .seat-item {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-color: #ced4da;
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

.bg-light-blue {
    background-color: #e3f2fd;
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
</style>

<script>
// ULTRA SIMPLE VERSION - GUARANTEED TO WORK
console.log('=== SEAT SELECTION PAGE LOADING ===');

// Global variables
let selectedSeats = [];
let totalPrice = 0;

// 1. INITIALIZE - Dipanggil saat DOM siap
function initializeSeatSelection() {
    console.log('🔄 Initializing seat selection...');
    
    // Reset state
    selectedSeats = [];
    totalPrice = 0;
    
    // Update UI awal
    updateUI();
    
    console.log('✅ Initialization complete');
}

// 2. SEAT CLICK HANDLER - Gunakan event delegation
document.addEventListener('click', function(event) {
    // Cek jika klik adalah seat item
    if (event.target.closest('.seat-item')) {
        const seatElement = event.target.closest('.seat-item');
        handleSeatClick(seatElement);
    }
    
    // Cek jika klik adalah clear button
    if (event.target.closest('#clear-seats')) {
        handleClearSeats();
    }
    
    // Cek jika klik adalah continue button
    if (event.target.closest('#continue-btn')) {
        handleContinueBooking();
    }
});

// 3. HANDLE SEAT CLICK
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
        // Select
        if (selectedSeats.length >= 9) {
            alert('Maximum 9 seats allowed');
            return;
        }
        seatElement.classList.add('selected');
        selectedSeats.push({
            id: seatId,
            number: seatNumber,
            price: price
        });
        totalPrice += price;
        console.log(`➕ Selected: ${seatNumber}`);
    }
    
    updateUI();
}

// 4. HANDLE CLEAR SEATS
function handleClearSeats() {
    if (selectedSeats.length === 0) {
        alert('No seats to clear');
        return;
    }
    
    if (confirm('Clear all selected seats?')) {
        // Clear visual
        document.querySelectorAll('.seat-item.selected').forEach(seat => {
            seat.classList.remove('selected');
        });
        
        // Clear data
        selectedSeats = [];
        totalPrice = 0;
        
        console.log('🗑️ All seats cleared');
        updateUI();
    }
}

// 5. HANDLE CONTINUE BOOKING - INI YANG PENTING!
function handleContinueBooking() {
    console.log('🚀 CONTINUE TO BOOKING CLICKED!');
    
    // Cek apakah button disabled
    const continueBtn = document.getElementById('continue-btn');
    if (continueBtn.disabled) {
        alert('Please select seats first');
        return;
    }
    
    if (selectedSeats.length === 0) {
        alert('Please select at least one seat');
        return;
    }
    
    console.log('📊 Selected seats:', selectedSeats);
    console.log('💰 Total price:', totalPrice);
    console.log('✈️ Flight ID:', {{ $flight->flight_instance_id }});
    
    // Tampilkan loading
    continueBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Redirecting...';
    continueBtn.disabled = true;
    
    // SIMPLE REDIRECT - PASTI BEKERJA!
    setTimeout(() => {
        // Simpan data di localStorage/sessionStorage
        try {
            localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
            localStorage.setItem('totalPrice', totalPrice);
            localStorage.setItem('flightId', {{ $flight->flight_instance_id }});
            
            // Juga simpan di sessionStorage
            sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
            sessionStorage.setItem('totalPrice', totalPrice);
            sessionStorage.setItem('flightId', {{ $flight->flight_instance_id }});
            
            console.log('💾 Data saved to storage');
        } catch (e) {
            console.log('⚠️ Could not save to storage:', e);
        }
        
        // METHOD 1: Redirect dengan data di URL (paling reliable)
        const params = new URLSearchParams();
        params.set('seats', JSON.stringify(selectedSeats));
        params.set('total', totalPrice);
        params.set('flight_id', {{ $flight->flight_instance_id }});

        const redirectUrl = '{{ route("booking.form") }}?' + params.toString();
        console.log('🔗 Redirect URL:', redirectUrl);

        // DO THE REDIRECT
        window.location.href = redirectUrl;
        
    }, 500); // Delay kecil untuk efek visual
}

// 6. UPDATE UI
function updateUI() {
    console.log('🎨 Updating UI...');
    
    // Update total price display
    const totalElement = document.getElementById('total-price');
    if (totalElement) {
        totalElement.textContent = '$' + totalPrice.toFixed(2);
    }
    
    // Update continue button
    const continueBtn = document.getElementById('continue-btn');
    if (continueBtn) {
        if (selectedSeats.length > 0) {
            continueBtn.disabled = false;
            continueBtn.classList.remove('btn-secondary');
            continueBtn.classList.add('btn-success');
            continueBtn.innerHTML = '<i class="bi bi-arrow-right"></i> Continue to Booking';
        } else {
            continueBtn.disabled = true;
            continueBtn.classList.remove('btn-success');
            continueBtn.classList.add('btn-secondary');
            continueBtn.innerHTML = '<i class="bi bi-arrow-right"></i> Continue to Booking';
        }
    }
    
    // Update seat list display
    updateSeatList();
}

// 7. UPDATE SEAT LIST DISPLAY
function updateSeatList() {
    const container = document.getElementById('selected-seats-list');
    if (!container) return;
    
    if (selectedSeats.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-3">
                <i class="bi bi-emoji-frown display-4"></i>
                <p class="mt-2">No seats selected yet</p>
            </div>
        `;
        return;
    }
    
    let html = '<div class="row">';
    selectedSeats.forEach(seat => {
        html += `
            <div class="col-md-4 mb-2">
                <div class="border rounded p-2 bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="fs-5">${seat.number}</strong>
                            <div class="small text-muted">Seat</div>
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

console.log('✅ Seat selection script loaded');
</script>
@endsection