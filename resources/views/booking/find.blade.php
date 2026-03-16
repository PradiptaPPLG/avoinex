@extends('layouts.app')

@section('title', 'Find Your Booking - Avoinex')

@section('content')
<div class="avx-find-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <!-- Search Card -->
                <div class="avx-find-card">
                    <div class="avx-find-header">
                        <div class="avx-find-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h2 class="avx-find-title">Retrieve Your Booking</h2>
                        <p class="avx-find-subtitle">Enter your booking code and email to view your e-ticket</p>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger mx-4 mt-3 mb-0 d-flex align-items-center" style="border-radius:12px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('booking.find') }}" method="POST" class="avx-find-form">
                        @csrf
                        <div class="mb-3">
                            <label for="booking_code" class="form-label fw-bold">
                                <i class="bi bi-ticket-perforated me-1"></i> Booking Code
                            </label>
                            <input type="text" class="form-control avx-find-input" id="booking_code" name="booking_code"
                                   placeholder="e.g. AVX-A1B2C3D4" value="{{ old('booking_code') }}" required
                                   style="text-transform:uppercase;">
                            @error('booking_code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope me-1"></i> Email Address
                            </label>
                            <input type="email" class="form-control avx-find-input" id="email" name="email"
                                   placeholder="The email used during booking" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn avx-find-btn w-100">
                            <i class="bi bi-search me-2"></i> Find Booking
                        </button>
                    </form>

                    <div class="avx-find-footer">
                        <p class="mb-0"><i class="bi bi-info-circle me-1"></i> Use the same email where your e-ticket was sent</p>
                    </div>
                </div>

                <!-- Results Card (shown when booking is found) -->
                @if(isset($booking))
                <div class="avx-result-card mt-4">
                    <!-- Header -->
                    <div class="avx-result-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="avx-result-label">Booking Code</span>
                                <h3 class="mb-0 fw-800" style="letter-spacing:2px; color:#279ED6;">{{ $booking->booking_code }}</h3>
                            </div>
                            <div>
                                @php
                                    $statusColor = match($booking->booking_status) {
                                        'confirmed' => '#198754',
                                        'pending' => '#ffc107',
                                        'cancelled' => '#dc3545',
                                        default => '#6c757d'
                                    };
                                @endphp
                                <span class="badge rounded-pill px-3 py-2" style="background:{{ $statusColor }}; font-size:13px;">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Flight Route -->
                    <div class="avx-result-section">
                        <div class="row text-center align-items-center">
                            <div class="col-5">
                                <span class="avx-result-label">From</span>
                                <h4 class="fw-800 mb-0">{{ $booking->flightInstance->schedule->originAirport->iata_code }}</h4>
                                <small class="text-muted">{{ $booking->flightInstance->schedule->originAirport->city }}</small>
                            </div>
                            <div class="col-2">
                                <span style="font-size:24px; color:#279ED6;">✈</span>
                            </div>
                            <div class="col-5">
                                <span class="avx-result-label">To</span>
                                <h4 class="fw-800 mb-0">{{ $booking->flightInstance->schedule->destinationAirport->iata_code }}</h4>
                                <small class="text-muted">{{ $booking->flightInstance->schedule->destinationAirport->city }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Flight Details -->
                    <div class="avx-result-section">
                        <div class="row">
                            <div class="col-4">
                                <span class="avx-result-label">Flight</span>
                                <p class="fw-bold mb-0">{{ $booking->flightInstance->schedule->flight_number }}</p>
                            </div>
                            <div class="col-4">
                                <span class="avx-result-label">Date</span>
                                <p class="fw-bold mb-0">{{ $booking->flightInstance->flight_date->format('d M Y') }}</p>
                            </div>
                            <div class="col-4">
                                <span class="avx-result-label">Departure</span>
                                <p class="fw-bold mb-0">{{ date('H:i', strtotime($booking->flightInstance->schedule->departure_time_gmt)) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Passengers -->
                    <div class="avx-result-section">
                        <h6 class="fw-bold mb-3"><i class="bi bi-people me-1"></i> Passengers</h6>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0" style="font-size:14px;">
                                <thead style="background:#f0f7fc;">
                                    <tr>
                                        <th style="border:none; padding:10px 12px;">Name</th>
                                        <th style="border:none; padding:10px 12px; text-align:center;">Seat</th>
                                        <th style="border:none; padding:10px 12px; text-align:center;">Baggage</th>
                                        <th style="border:none; padding:10px 12px; text-align:right;">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->bookingSeats as $bSeat)
                                    <tr>
                                        <td style="padding:10px 12px;">{{ $bSeat->passenger_first_name }} {{ $bSeat->passenger_last_name }}</td>
                                        <td style="padding:10px 12px; text-align:center;"><strong>{{ $bSeat->seat->seat_number ?? 'N/A' }}</strong></td>
                                        <td style="padding:10px 12px; text-align:center;">{{ $bSeat->baggage_weight ?? 0 }}kg</td>
                                        <td style="padding:10px 12px; text-align:right;">${{ number_format($bSeat->price_at_booking + ($bSeat->baggage_price ?? 0), 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="avx-result-total">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Price</span>
                            <span class="avx-result-price">${{ number_format($booking->total_price_usd, 2) }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Back Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('landing') }}" class="text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avx-find-bg {
    min-height: 80vh;
    background: linear-gradient(135deg, #f0f7fc 0%, #e8f4fd 50%, #f5f5f5 100%);
    padding: 60px 0;
}

.avx-find-card {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
}

.avx-find-header {
    text-align: center;
    padding: 36px 32px 16px;
    background: linear-gradient(180deg, #f8fbff 0%, #fff 100%);
}

.avx-find-icon {
    width: 64px; height: 64px;
    background: linear-gradient(135deg, #279ED6, #1a7ab5);
    border-radius: 50%;
    display: inline-flex;
    align-items: center; justify-content: center;
    color: #fff; font-size: 28px;
    margin-bottom: 16px;
    box-shadow: 0 6px 20px rgba(39,158,214,0.3);
}

.avx-find-title {
    font-weight: 800; color: #1a1a2e; font-size: 22px; margin-bottom: 8px;
}

.avx-find-subtitle {
    color: #777; font-size: 14px; margin-bottom: 0;
}

.avx-find-form {
    padding: 24px 32px 32px;
}

.avx-find-input {
    border-radius: 12px; padding: 12px 16px; border: 1.5px solid #e0e0e0;
    font-size: 15px; transition: border-color 0.2s;
}
.avx-find-input:focus {
    border-color: #279ED6; box-shadow: 0 0 0 3px rgba(39,158,214,0.12);
}

.avx-find-btn {
    background: linear-gradient(135deg, #279ED6, #1a7ab5);
    color: #fff; border: none; border-radius: 14px;
    padding: 14px; font-size: 16px; font-weight: 700;
    transition: all 0.25s;
}
.avx-find-btn:hover {
    background: linear-gradient(135deg, #1a7ab5, #15668e);
    color: #fff; transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(39,158,214,0.3);
}

.avx-find-footer {
    background: #f8f9fa; padding: 14px 32px;
    text-align: center; border-top: 1px solid #eee;
}
.avx-find-footer p { font-size: 12px; color: #999; }

/* Result Card */
.avx-result-card {
    background: #fff; border-radius: 20px;
    overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.08);
}

.avx-result-header {
    padding: 24px 28px; border-bottom: 1px dashed #e0e0e0;
}

.avx-result-label {
    font-size: 11px; color: #999; text-transform: uppercase;
    letter-spacing: 1px; display: block; margin-bottom: 2px;
}

.avx-result-section {
    padding: 20px 28px; border-bottom: 1px solid #f0f0f0;
}

.avx-result-total {
    padding: 20px 28px; background: #eef7fc;
}

.avx-result-price {
    font-size: 24px; font-weight: 800; color: #279ED6;
}
</style>
@endsection
