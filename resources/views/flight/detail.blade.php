@extends('layouts.app')

@section('title', 'Flight Details - Avoinex')

@section('content')
<div class="container mt-4">
    <!-- Back button -->
    <a href="{{ route('home') }}" class="btn btn-outline-primary mb-4">
        <i class="bi bi-arrow-left"></i> Back to Flights
    </a>
    
    <!-- Flight Details Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Flight Details</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <!-- Flight Info -->
                    <div class="flight-header mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="airline-logo me-3">
                                <h3 class="mb-0">{{ $flight->airline_code ?? 'GA' }}</h3>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ $flight->schedule->flight_number }}</h4>
                                <p class="text-muted mb-0">{{ $flight->airline_name ?? 'Garuda Indonesia' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Route Details -->
                    <div class="flight-route mb-4">
                        <div class="row">
                            <div class="col-md-5">
                                <h5>{{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}</h5>
                                <p class="mb-1"><strong>{{ $flight->schedule->originAirport->city }}</strong></p>
                                <p class="text-muted mb-0">{{ $flight->schedule->originAirport->airport_name }} ({{ $flight->schedule->originAirport->iata_code }})</p>
                            </div>
                            
                            <div class="col-md-2 text-center">
                                <div class="flight-duration">
                                    <i class="bi bi-clock"></i>
                                    <span>{{ floor($flight->schedule->duration_minutes / 60) }}h {{ $flight->schedule->duration_minutes % 60 }}m</span>
                                </div>
                                <div class="flight-line">
                                    <div class="line"></div>
                                    <i class="bi bi-airplane"></i>
                                </div>
                            </div>
                            
                            <div class="col-md-5 text-end">
                                <h5>{{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}</h5>
                                <p class="mb-1"><strong>{{ $flight->schedule->destinationAirport->city }}</strong></p>
                                <p class="text-muted mb-0">{{ $flight->schedule->destinationAirport->airport_name }} ({{ $flight->schedule->destinationAirport->iata_code }})</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Flight Date & Status -->
                    <div class="flight-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p><i class="bi bi-calendar"></i> <strong>Date:</strong> {{ $flight->flight_date->format('l, d F Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="bi bi-info-circle"></i> <strong>Status:</strong> 
                                    <span class="badge bg-success">{{ $flight->flightStatus->name ?? 'Scheduled' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Aircraft Info -->
                    <div class="aircraft-info mb-4">
                        <h5><i class="bi bi-airplane-engines"></i> Aircraft Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Model:</strong> {{ $flight->aircraftInstance->aircraft->aircraft_model ?? 'Boeing 737-800' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Registration:</strong> {{ $flight->aircraftInstance->registration_number ?? 'PK-GAA' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Panel -->
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Book This Flight</h5>
                        </div>
                        <div class="card-body">
                            <!-- Available Seats -->
                            <div class="mb-3">
                                <h6>Available Seats</h6>
                                @if($flight->is_full)
                                    <div class="alert alert-danger">
                                        <i class="bi bi-exclamation-triangle"></i> Fully Booked
                                    </div>
                                @else
                                    <div class="alert alert-success">
                                        <i class="bi bi-check-circle"></i> {{ $flight->available_seats }} seats available
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Price -->
                            <div class="mb-3">
                                <h6>Price</h6>
                                <h3 class="text-primary">Rp {{ number_format($flight->schedule->base_price_usd, 0, ',', '.') }}</h3>
                                <small class="text-muted">per person • Economy class</small>
                            </div>
                            
                            <!-- Action Button -->
                            <div class="d-grid gap-2">
                                @if($flight->is_full)
                                    <button class="btn btn-secondary" disabled>
                                        <i class="bi bi-x-circle"></i> No Seats Available
                                    </button>
                                @else
                                    <a href="{{ route('flight.seats', $flight->flight_instance_id) }}" 
                                       class="btn btn-primary btn-lg">
                                        <i class="bi bi-ticket"></i> Select Seats
                                    </a>
                                @endif
                                
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-heart"></i> Save for Later
                                </button>
                            </div>
                            
                            <!-- Flight Features -->
                            <div class="mt-4">
                                <h6>Included:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-check text-success"></i> 20kg baggage allowance</li>
                                    <li><i class="bi bi-check text-success"></i> In-flight meal</li>
                                    <li><i class="bi bi-check text-success"></i> Free Wi-Fi</li>
                                    <li><i class="bi bi-check text-success"></i> Seat selection</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.airline-logo {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #279ED6, #11549D);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.flight-duration {
    color: #666;
    margin-bottom: 10px;
}

.flight-line {
    position: relative;
    height: 2px;
    background: #279ED6;
    margin: 15px 0;
}

.flight-line .line {
    width: 100%;
    height: 2px;
    background: #279ED6;
}

.flight-line i {
    position: absolute;
    left: 50%;
    top: -12px;
    transform: translateX(-50%);
    background: white;
    padding: 0 10px;
    color: #279ED6;
    font-size: 1.5rem;
}

.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
}
</style>
@endsection