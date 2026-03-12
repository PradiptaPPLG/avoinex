@extends('layouts.app')

@push('styles')
<style>
    @media print {
        .btn, .alert-success, .card-header.bg-success {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .container {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .row {
            display: block !important;
        }
        .col-md-8, .col-md-4 {
            width: 100% !important;
            margin-bottom: 20px;
        }
        .boarding-pass-card {
            border: 2px solid #000 !important;
            padding: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="container mt-4 mb-4">
    <!-- Booking Steps -->
    <div class="mb-4 position-relative d-print-none">
        <div class="progress" style="height: 3px; position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); z-index: 1;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
            <div class="text-center" style="width: 32%;">
                <div class="bg-success text-white rounded-pill py-2 border border-2 border-success shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> 1. Passenger Details
                </div>
            </div>
            <div class="text-center" style="width: 32%;">
                <div class="bg-success text-white rounded-pill py-2 border border-2 border-success shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> 2. Payment
                </div>
            </div>
            <div class="text-center" style="width: 32%;">
                <div class="bg-success text-white rounded-pill py-2 border border-2 border-success fw-bold shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> 3. Confirmation
                </div>
            </div>
        </div>
    </div>
    <div class="card border-success">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="bi bi-check-circle"></i> Booking Confirmed!</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-success">
                        <h5>Thank you for your booking!</h5>
                        <p class="mb-0">Your e-ticket has been sent to <strong>{{ $booking->client->email }}</strong></p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Booking Details</h6>
                            <p><strong>Booking Code:</strong> {{ $booking->booking_code }}</p>
                            <p><strong>Booking Date:</strong> {{ $booking->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-success">Confirmed</span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Flight Details</h6>
                            <p><strong>Flight:</strong> {{ $booking->flightInstance->schedule->flight_number }}</p>
                            <p><strong>Route:</strong> 
                                {{ $booking->flightInstance->schedule->originAirport->city }} ({{ $booking->flightInstance->schedule->originAirport->iata_code }}) 
                                → 
                                {{ $booking->flightInstance->schedule->destinationAirport->city }} ({{ $booking->flightInstance->schedule->destinationAirport->iata_code }})
                            </p>
                            <p><strong>Date:</strong> {{ $booking->flightInstance->flight_date->format('d M Y') }}</p>
                        </div>
                    </div>
                    
                    <h6 class="mt-4">Passengers</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Passport</th>
                                <th>Seat & Baggage</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->bookingSeats as $seat)
                            <tr>
                                <td>{{ $seat->passenger_first_name }} {{ $seat->passenger_last_name }}</td>
                                <td>{{ $seat->passenger_passport }}</td>
                                <td>
                                    <div>{{ $seat->seat->seat_number ?? 'N/A' }}</div>
                                    @if($seat->baggage_weight > 0)
                                    <div class="small text-muted"><i class="bi bi-suitcase"></i> {{ $seat->baggage_weight }} kg</div>
                                    @endif
                                </td>
                                <td>
                                    <div>${{ number_format($seat->price_at_booking, 2) }}</div>
                                    @if($seat->baggage_price > 0)
                                    <div class="small text-muted">+${{ number_format($seat->baggage_price, 2) }}</div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th>${{ number_format($booking->total_price_usd, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <div class="mt-4">
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print Ticket
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="bi bi-house"></i> Back to Home
                        </a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card boarding-pass-card">
                        <div class="card-header">
                            <h6 class="mb-0">Boarding Pass</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="border p-4 mb-3">
                                <h5 class="text-primary">{{ $booking->booking_code }}</h5>
                                <h3>{{ $booking->flightInstance->schedule->flight_number }}</h3>
                                <p class="mb-1">{{ $booking->flightInstance->schedule->originAirport->iata_code }} → {{ $booking->flightInstance->schedule->destinationAirport->iata_code }}</p>
                                <p class="mb-1">{{ $booking->flightInstance->flight_date->format('d M Y') }}</p>
                                <p class="mb-0">Departure: {{ $booking->flightInstance->schedule->departure_time_gmt }}</p>
                            </div>
                            <div class="alert alert-info small">
                                <i class="bi bi-info-circle"></i> Present this code at check-in counter
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection