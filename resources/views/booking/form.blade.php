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
                                <div class="passenger-form border rounded p-3 mb-3">
                                    <h6>Passenger {{ $index + 1 }} - Seat {{ $seat['number'] ?? 'N/A' }} ({{ $seat['class'] ?? 'economy' }})</h6>
                                    <input type="hidden" name="seat_ids[]" value="{{ $seat['id'] ?? '' }}">
                                    <input type="hidden" name="seat_numbers[]" value="{{ $seat['number'] ?? '' }}">
                                    <input type="hidden" name="seat_prices[]" value="{{ $seat['price'] ?? 150 }}">
                                    
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
                                                ['weight' => 20, 'price' => 20, 'label' => '20 kg', 'sub' => '+$20.00'],
                                                ['weight' => 25, 'price' => 25, 'label' => '25 kg', 'sub' => '+$25.00'],
                                                ['weight' => 30, 'price' => 30, 'label' => '30 kg', 'sub' => '+$30.00'],
                                                ['weight' => 40, 'price' => 40, 'label' => '40 kg', 'sub' => '+$40.00'],
                                                ['weight' => 50, 'price' => 50, 'label' => '50 kg', 'sub' => '+$50.00'],
                                                ['weight' => 60, 'price' => 60, 'label' => '60 kg', 'sub' => '+$60.00'],
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
                        <h6>Price Breakdown</h6>
                        <table class="table table-sm">
                            <tbody id="summary-prices">
                                @if(!empty($selectedSeats))
                                    @foreach($selectedSeats as $seat)
                                    <tr>
                                        <td>Seat {{ $seat['number'] ?? 'N/A' }} ({{ $seat['class'] ?? 'economy' }})</td>
                                        <td class="text-end">${{ number_format($seat['price'] ?? 150, 2) }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class="text-end" id="summary-grand-total">${{ number_format($totalPrice ?? 0, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
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

        // Don't prevent default - let browser handle HTML5 validation first
        if (!form.checkValidity()) {
            console.log('❌ Form has HTML5 validation errors');
            // Let browser show native validation messages
            return true; // Don't prevent default, browser will handle it
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

        // Check passenger data
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

        // Check if we have seat data
        const seatIds = document.querySelectorAll('input[name="seat_ids[]"]');
        if (seatIds.length === 0) {
            e.preventDefault();
            alert('No seat data found. Please go back and select seats.');
            console.log('❌ No seat data');
            return false;
        }

        // Show loading - disable button to prevent double submit
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing Booking...';
            submitBtn.disabled = true;
        }

        console.log('✅ Form validation passed, submitting...');
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);

        // Form will submit normally
        return true;
    });

    // --- NEW CODE: Baggage Selection Handling ---
    const baseTotalPrice = {{ $totalPrice ?? 0 }};
    const baggageTotals = {};
    const summaryPrices = document.getElementById('summary-prices');
    const summaryGrandTotal = document.getElementById('summary-grand-total');

    document.querySelectorAll('.baggage-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const container = this.closest('.baggage-options');
                const passengerIndex = container.dataset.passengerIndex;
                const price = parseFloat(this.dataset.price);
                const weight = this.value;

                // update hidden inputs
                const formContainer = this.closest('.passenger-form');
                formContainer.querySelector('.baggage-weight-input').value = weight;
                formContainer.querySelector('.baggage-price-input').value = price;

                // update totals object
                baggageTotals[passengerIndex] = {
                    weight: weight,
                    price: price
                };

                updateSummary();
            }
        });
    });

    function updateSummary() {
        // Remove old baggage rows
        document.querySelectorAll('.baggage-summary-row').forEach(el => el.remove());

        let totalBaggageCost = 0;

        Object.keys(baggageTotals).forEach(index => {
            const item = baggageTotals[index];
            if (item.price > 0) {
                totalBaggageCost += item.price;
                
                const tr = document.createElement('tr');
                tr.className = 'baggage-summary-row';
                tr.innerHTML = `
                    <td><small class="text-muted">&#8627; Pass ${parseInt(index) + 1} Baggage (${item.weight}kg)</small></td>
                    <td class="text-end"><small class="text-muted">+$${item.price.toFixed(2)}</small></td>
                `;
                summaryPrices.appendChild(tr);
            }
        });

        const grandTotal = baseTotalPrice + totalBaggageCost;
        if (summaryGrandTotal) {
            summaryGrandTotal.innerHTML = '$' + grandTotal.toFixed(2);
        }
    }
});
</script>
@endsection