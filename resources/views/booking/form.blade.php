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
                        
                        <!-- Contact Person -->
                        <h6 class="border-bottom pb-2">Contact Person</h6>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">First Name *</label>
                                <input type="text" class="form-control" name="contact_first_name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name *</label>
                                <input type="text" class="form-control" name="contact_last_name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="contact_email" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" name="contact_phone" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <select class="form-select" name="contact_country">
                                    <option value="ID">Indonesia</option>
                                    <option value="SG">Singapore</option>
                                    <option value="MY">Malaysia</option>
                                </select>
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
            <div class="card sticky-top" style="top: 20px;">
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
                                    <th class="text-end">${{ number_format($totalPrice ?? 0, 2) }}</th>
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
});
</script>
@endsection