@extends('layouts.app')

@section('content')
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
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Please fix the following issues:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="bookingForm" action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        
                        <!-- Countdown Timer -->
                        <div class="alert alert-danger d-flex align-items-center justify-content-between p-3 mb-4 shadow-sm" style="border-radius: 10px; border-left: 5px solid #dc3545;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock-history fs-3 me-3 text-danger"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold" style="color: #c82333;">Selesaikan Pemesanan Anda!</h6>
                                    <small class="mb-0" style="color: #6c757d;">Waktu Anda untuk menyelesaikan data penumpang dan pembayaran.</small>
                                </div>
                            </div>
                            <div class="text-center rounded px-3 py-1 bg-white border border-danger shadow-sm">
                                <span class="fs-4 fw-bold text-danger" id="booking-timer" style="font-variant-numeric: tabular-nums;">15:00</span>
                            </div>
                        </div>
                        
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
                            @if(!empty($selectedSeats))
                                @foreach($selectedSeats as $index => $seat)
                                <div class="passenger-form border rounded p-3 mb-3" data-index="{{ $index }}">
                                    <h6>Passenger {{ $index + 1 }} - Seat {{ $seat['number'] ?? 'N/A' }} 
                                        @if(!empty($seat['isVipSelected']))
                                            <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> VIP Selection (+Rp 150.000)</span>
                                        @else
                                            <span class="text-muted">({{ ucfirst($seat['class'] ?? 'economy') }})</span>
                                        @endif
                                    </h6>
                                    <input type="hidden" name="seat_ids[]" value="{{ $seat['id'] ?? '' }}">
                                    <input type="hidden" name="seat_numbers[]" value="{{ $seat['number'] ?? '' }}">
                                    <input type="hidden" name="seat_prices[]" value="{{ $seat['totalSeatPrice'] ?? ($seat['price'] ?? 150) }}">
                                    <input type="hidden" name="seat_is_vip[]" value="{{ !empty($seat['isVipSelected']) ? '1' : '0' }}">
                                    
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
                                    
                                    <div class="row g-2 mt-2 baggage-options" data-passenger-index="{{ $index }}">
                                        @php
                                            $baggageOptions = [
                                                ['weight' => 0, 'price' => 0, 'label' => 'No Extra', 'sub' => 'Included'],
                                                ['weight' => 20, 'price' => 20, 'label' => '20 kg', 'sub' => '+Rp ' . number_format(20, 0, ',', '.')],
                                                ['weight' => 25, 'price' => 25, 'label' => '25 kg', 'sub' => '+Rp ' . number_format(25, 0, ',', '.')],
                                                ['weight' => 30, 'price' => 30, 'label' => '30 kg', 'sub' => '+Rp ' . number_format(30, 0, ',', '.')],
                                                ['weight' => 40, 'price' => 40, 'label' => '40 kg', 'sub' => '+Rp ' . number_format(40, 0, ',', '.')],
                                                ['weight' => 50, 'price' => 50, 'label' => '50 kg', 'sub' => '+Rp ' . number_format(50, 0, ',', '.')],
                                                ['weight' => 60, 'price' => 60, 'label' => '60 kg', 'sub' => '+Rp ' . number_format(60, 0, ',', '.')],
                                            ];
                                        @endphp
                                        @foreach($baggageOptions as $bgIdx => $bg)
                                        <div class="col-6 col-md-3">
                                            <input type="radio" class="btn-check baggage-radio" name="baggage_selection_{{ $index }}" id="baggage_{{ $index }}_{{ $bg['weight'] }}" value="{{ $bg['weight'] }}" data-price="{{ $bg['price'] }}" autocomplete="off" {{ $bg['weight'] == 0 ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary w-100 text-start p-2 rounded-3 h-100" for="baggage_{{ $index }}_{{ $bg['weight'] }}">
                                                <div class="fw-bold">{{ $bg['label'] }}</div>
                                                <div class="small">{{ $bg['sub'] }}</div>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>

                                    <!-- Catering / Meals Section -->
                                    @if(isset($flight->meals) && $flight->meals->count() > 0)
                                    <hr class="mt-4 mb-3">
                                    <h6><i class="bi bi-cup-hot text-primary"></i> In-Flight Meals</h6>
                                    <input type="hidden" name="meal_ids[]" value="" class="meal-id-input">
                                    <input type="hidden" name="meal_prices[]" value="0" class="meal-price-input">
                                    
                                    <div class="row g-2 mt-2 meal-options" data-passenger-index="{{ $index }}">
                                        <!-- No Meal Option -->
                                        <div class="col-6 col-md-3">
                                            <input type="radio" class="btn-check meal-radio" name="meal_selection_{{ $index }}" id="meal_{{ $index }}_none" value="" data-price="0" data-name="No Meal" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary w-100 text-start p-2 rounded-3 h-100 d-flex flex-column align-items-center justify-content-center text-center" for="meal_{{ $index }}_none">
                                                <i class="bi bi-x-circle text-muted mb-2" style="font-size: 2rem;"></i>
                                                <div class="fw-bold">No Meal</div>
                                                <div class="small text-muted">Included</div>
                                            </label>
                                        </div>
                                        @foreach($flight->meals as $meal)
                                        <div class="col-6 col-md-3">
                                            <input type="radio" class="btn-check meal-radio" name="meal_selection_{{ $index }}" id="meal_{{ $index }}_{{ $meal->id }}" value="{{ $meal->id }}" data-price="{{ $meal->price_usd * 15000 }}" data-name="{{ $meal->name }}" autocomplete="off">
                                            <label class="btn btn-outline-primary w-100 text-start p-2 rounded-3 h-100 d-flex flex-column" for="meal_{{ $index }}_{{ $meal->id }}">
                                                <div class="rounded mb-2 overflow-hidden bg-light d-flex align-items-center justify-content-center" style="height: 60px;">
                                                    @if($meal->image_path)
                                                        <img src="{{ asset('storage/' . $meal->image_path) }}" alt="{{ $meal->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @endif
                                                </div>
                                                <div class="fw-bold lh-sm text-truncate w-100" title="{{ $meal->name }}" style="font-size: 0.85rem;">{{ $meal->name }}</div>
                                                <div class="small text-muted mt-auto" style="font-size: 0.8rem;">+Rp {{ number_format($meal->price_usd * 15000, 0, ',', '.') }}</div>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif

                                    <!-- Travel Insurance Section -->
                                    <hr class="mt-4 mb-3">
                                    <div class="card bg-light border-info border-opacity-50">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-switch fs-5 flex-shrink-0 me-3">
                                                    <input class="form-check-input insurance-toggle" type="checkbox" role="switch" id="insurance_{{ $index }}" data-passenger-index="{{ $index }}" data-price="45000">
                                                    <input type="hidden" name="has_insurances[]" value="false" class="insurance-hidden-input">
                                                </div>
                                                <div>
                                                    <label class="form-check-label fw-bold mb-1" for="insurance_{{ $index }}" style="cursor: pointer;">Avoinex Travel Protection (+Rp 45.000)</label>
                                                    <p class="mb-0 small text-muted">Protect your trip from unexpected cancellations, flight delays, and baggage loss.</p>
                                                </div>
                                                <i class="bi bi-shield-check text-info ms-auto d-none d-sm-block" style="font-size: 2rem;"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i> No seat data available. Please go back and select seats.
                                </div>
                            @endif
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
                        <p class="mb-1"><strong>{{ $flight->schedule->flight_number ?? 'GA-201' }}</strong></p>
                        <p class="mb-1">{{ $flight->schedule->originAirport->city ?? 'Jakarta' }} ({{ $flight->schedule->originAirport->iata_code ?? 'CGK' }}) 
                            → {{ $flight->schedule->destinationAirport->city ?? 'Denpasar' }} ({{ $flight->schedule->destinationAirport->iata_code ?? 'DPS' }})</p>
                        <p class="mb-1">{{ $flight->flight_date->format('d M Y') ?? '1 Feb 2026' }}, 
                            {{ date('H:i', strtotime($flight->schedule->departure_time_gmt ?? '08:00')) }} - 
                            {{ date('H:i', strtotime($flight->schedule->arrival_time_gmt ?? '10:30')) }}</p>
                    </div>

                    <!-- Selected Seats -->
                    <div class="mb-3">
                        <h6>Selected Seats</h6>
                        <div id="summary-seats">
                            @if(!empty($selectedSeats))
                                @foreach($selectedSeats as $seat)
                                    <span class="badge bg-secondary me-1 mb-1">{{ $seat['number'] ?? 'N/A' }}</span>
                                @endforeach
                            @else
                                <p class="text-muted small">No seats selected</p>
                            @endif
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div>
                        <h6 class="mb-2" style="font-weight: 700; font-size: 14px;">Price Breakdown</h6>
                        <table class="table table-sm mb-0" style="font-size: 13px;">
                            <tbody id="summary-prices">
                                @php
                                    $seatSubtotal = 0;
                                @endphp
                                @if(!empty($selectedSeats))
                                    @foreach($selectedSeats as $seat)
                                    @php $seatSubtotal += floatval($seat['totalSeatPrice'] ?? ($seat['price'] ?? 150)); @endphp
                                    <tr>
                                        <td class="border-0 py-1">
                                            <i class="bi bi-person-fill text-muted" style="font-size: 11px;"></i>
                                            Seat {{ $seat['number'] ?? 'N/A' }} 
                                            @if(!empty($seat['isVipSelected']))
                                                <span class="text-warning fw-bold small">(VIP)</span>
                                            @endif
                                        </td>
                                        <td class="text-end border-0 py-1" data-base-seat="{{ floatval($seat['totalSeatPrice'] ?? ($seat['price'] ?? 150)) }}">
                                            Rp {{ number_format($seat['totalSeatPrice'] ?? ($seat['price'] ?? 150), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <!-- Dynamic Rows for Add-ons will be appended here by JS -->
                                    <tr id="addon-row-{{ $index }}" style="display: none;">
                                        <td class="border-0 py-0 pb-2 ps-3 small text-muted addon-list-{{ $index }}"></td>
                                        <td class="border-0 py-0 pb-2 text-end small addon-price-{{ $index }}"></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <!-- Fee breakdown -->
                            <tbody id="summary-fees">
                                @php
                                    $taxRate = 0.10;
                                    $serviceFee = 5.00;
                                    $taxAmount = $seatSubtotal * $taxRate;
                                    $baseTotal = $seatSubtotal + $taxAmount + $serviceFee;
                                @endphp
                                <tr>
                                    <td class="border-0 py-1 text-muted" style="font-size: 12px;">
                                        <i class="bi bi-receipt" style="font-size: 10px;"></i> Tax (10%)
                                    </td>
                                    <td class="text-end border-0 py-1 text-muted" style="font-size: 12px;" id="summary-tax">
                                        Rp {{ number_format($taxAmount, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0 py-1 text-muted" style="font-size: 12px;">
                                        <i class="bi bi-gear" style="font-size: 10px;"></i> Service Fee
                                    </td>
                                    <td class="text-end border-0 py-1 text-muted" style="font-size: 12px;">
                                        Rp {{ number_format($serviceFee, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr style="border-top: 2px solid #dee2e6;">
                                    <th class="py-2" style="font-size: 14px;">Total</th>
                                    <th class="text-end py-2" id="summary-grand-total" style="font-size: 14px; color: #0066CC;">
                                        Rp {{ number_format($baseTotal, 0, ',', '.') }}
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

    // --- Countdown Timer Logic ---
    let timeRemaining = 15 * 60; // 15 menit
    const timerDisplay = document.getElementById('booking-timer');
    
    if (timerDisplay) {
        const timerInterval = setInterval(() => {
            timeRemaining--;
            
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeRemaining <= 60) {
                // Tambahkan efek kelap-kelip merah pada menit terakhir jika menggunakan animate.css, atau ganti style manual
                timerDisplay.parentElement.style.backgroundColor = '#ffe5e5';
            }
            
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                alert('Waktu pemesanan Anda telah habis. Silakan ulangi pencarian penerbangan untuk mengunci harga dan ketersediaan kursi.');
                window.location.href = '/'; 
            }
        }, 1000);
    }

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

    // --- Add-ons Selection & Price Breakdown ---
    const seatSubtotal = {{ $seatSubtotal ?? 0 }};
    const TAX_RATE = 0.10;
    const SERVICE_FEE = 5.00;
    const addonsData = {}; // structure: addonsData[passengerIndex] = { baggage: 0, baggageLabel: '', meal: 0, mealLabel: '', insurance: 0 }
    
    const summaryPrices = document.getElementById('summary-prices'); // We'll append UI elements directly under each seat row!
    const summaryTax = document.getElementById('summary-tax');
    const summaryGrandTotal = document.getElementById('summary-grand-total');

    // Initialize addonsData
    document.querySelectorAll('.passenger-form').forEach(form => {
        const idx = form.dataset.index;
        addonsData[idx] = { baggage: 0, baggageLabel: '', meal: 0, mealLabel: '', insurance: 0 };
    });

    // 1. Baggage Observer
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

                addonsData[passengerIndex].baggage = price;
                addonsData[passengerIndex].baggageLabel = weight > 0 ? \`+\${weight}kg Bag.\` : '';
                updateSummary();
            }
        });
    });

    // 2. Meal Observer
    document.querySelectorAll('.meal-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const container = this.closest('.meal-options');
                const passengerIndex = container.dataset.passengerIndex;
                const price = parseFloat(this.dataset.price);
                const mealId = this.value;
                const mealName = this.dataset.name;

                const formContainer = this.closest('.passenger-form');
                formContainer.querySelector('.meal-id-input').value = mealId;
                formContainer.querySelector('.meal-price-input').value = price;

                addonsData[passengerIndex].meal = price;
                addonsData[passengerIndex].mealLabel = mealId ? mealName : '';
                updateSummary();
            }
        });
    });

    // 3. Insurance Observer
    document.querySelectorAll('.insurance-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const passengerIndex = this.dataset.passengerIndex;
            const price = parseFloat(this.dataset.price);
            
            const formContainer = this.closest('.passenger-form');
            formContainer.querySelector('.insurance-hidden-input').value = this.checked ? 'true' : 'false';

            addonsData[passengerIndex].insurance = this.checked ? price : 0;
            updateSummary();
        });
    });

    function updateSummary() {
        let totalAddonsCost = 0;

        Object.keys(addonsData).forEach(index => {
            const rowListUi = document.querySelector(\`.addon-list-\${index}\`);
            const rowPriceUi = document.querySelector(\`.addon-price-\${index}\`);
            const rowContainer = document.getElementById(\`addon-row-\${index}\`);
            
            if(!rowListUi) return;

            const item = addonsData[index];
            let listHtml = [];
            let rowAddonCost = 0;

            if (item.baggage > 0) { listHtml.push(\`<i class="bi bi-suitcase me-1"></i> \${item.baggageLabel}\`); rowAddonCost += item.baggage; }
            if (item.meal > 0) { listHtml.push(\`<i class="bi bi-cup-hot me-1"></i> \${item.mealLabel}\`); rowAddonCost += item.meal; }
            if (item.insurance > 0) { listHtml.push(\`<i class="bi bi-shield-check me-1"></i> Travel Ins.\`); rowAddonCost += item.insurance; }

            totalAddonsCost += rowAddonCost;

            if (listHtml.length > 0) {
                rowListUi.innerHTML = listHtml.join('<br>');
                rowPriceUi.innerHTML = '+Rp ' + rowAddonCost.toLocaleString('id-ID');
                rowContainer.style.display = 'table-row';
            } else {
                rowContainer.style.display = 'none';
                rowListUi.innerHTML = '';
                rowPriceUi.innerHTML = '';
            }
        });

        // Recalculate with tax
        const subtotalWithAddons = seatSubtotal + totalAddonsCost;
        const tax = subtotalWithAddons * TAX_RATE;
        const grandTotal = subtotalWithAddons + tax + SERVICE_FEE;

        if (summaryTax) summaryTax.textContent = 'Rp ' + tax.toLocaleString('id-ID');
        if (summaryGrandTotal) summaryGrandTotal.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }
});
</script>
@endsection