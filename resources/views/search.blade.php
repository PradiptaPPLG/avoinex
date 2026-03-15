@extends('layouts.app')

@section('title', 'Search Results - Avoinex')

@section('content')
<div class="container mt-4">
    <!-- Back to Search -->
    <a href="{{ route('home') }}" class="btn btn-outline-primary mb-3">
        <i class="bi bi-arrow-left"></i> Modify Search
    </a>

    <!-- Search Summary -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <small class="text-muted">FROM</small>
                    <h5 class="mb-0">{{ $origin->city ?? 'Jakarta' }} ({{ $origin->iata_code ?? 'CGK' }})</h5>
                    <p class="text-muted mb-0">{{ $origin->airport_name ?? 'Soekarno-Hatta Intl' }}</p>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">TO</small>
                    <h5 class="mb-0">{{ $destination->city ?? 'Denpasar' }} ({{ $destination->iata_code ?? 'DPS' }})</h5>
                    <p class="text-muted mb-0">{{ $destination->airport_name ?? 'Ngurah Rai Intl' }}</p>
                </div>
                <div class="col-md-2">
                    <small class="text-muted">DEPARTURE</small>
                    <h5 class="mb-0">{{ date('d M Y', strtotime($searchParams['depart'] ?? now())) }}</h5>
                </div>
                <div class="col-md-2">
                    <small class="text-muted">PASSENGERS</small>
                    <h5 class="mb-0">
                        @php
                            $totalPax = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0) + ($searchParams['infants'] ?? 0);
                        @endphp
                        {{ $totalPax }} Passenger{{ $totalPax > 1 ? 's' : '' }}
                    </h5>
                </div>
                <div class="col-md-2">
                    <small class="text-muted">CLASS</small>
                    <h5 class="mb-0">Economy</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Flight Results -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                Available Flights ({{ $flights->count() }} found)
                <small class="text-muted">Sorted by Price</small>
            </h5>
        </div>
        <div class="card-body">
            @if($flights->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">No flights found</h4>
                    <p class="text-muted">Try adjusting your search criteria</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">New Search</a>
                </div>
            @else
                @foreach($flights as $flight)
                <div class="flight-card ticket-card">
                    <div class="ticket-top p-3">
                        <div class="row align-items-center">
                        <div class="col-md-2 d-flex flex-column align-items-center gap-2">
                            @if(isset($flight->schedule->airline->logo_path) && $flight->schedule->airline->logo_path)
                                <div class="airline-logo rounded-circle shadow-sm overflow-hidden flex-shrink-0" style="background-color: #fff; border: 2px solid #e0e0e0; display: flex; align-items: center; justify-content: center; padding: 0;">
                                    <img src="{{ asset('logo_maskapai/' . $flight->schedule->airline->logo_path) }}" alt="{{ $flight->airline_name ?? 'Airline' }} Logo" style="width: 100%; height: 100%; object-fit: contain; padding: 5px;">
                                </div>
                            @else
                                <div class="airline-logo bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                    {{ $flight->airline_code ?? 'GA' }}
                                </div>
                            @endif
                            <p class="mb-0 fw-bold text-center">{{ $flight->airline_name ?? 'Garuda Indonesia' }}</p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="mb-1">{{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}</h4>
                            <p class="text-muted mb-0">{{ $flight->schedule->originAirport->city }} ({{ $flight->schedule->originAirport->iata_code }})</p>
                            <small class="text-muted">{{ $flight->flight_date->format('d M') }}</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <p class="mb-1">{{ floor($flight->schedule->duration_minutes / 60) }}h {{ $flight->schedule->duration_minutes % 60 }}m</p>
                            <div class="border-bottom"></div>
                            <p class="text-muted small mb-0">Direct</p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="mb-1">{{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}</h4>
                            <p class="text-muted mb-0">{{ $flight->schedule->destinationAirport->city }} ({{ $flight->schedule->destinationAirport->iata_code }})</p>
                            <small class="text-muted">{{ $flight->flight_date->format('d M') }}</small>
                        </div>
                        <div class="col-md-3 text-end">
                            <h4 class="text-primary mb-1">${{ number_format($flight->schedule->base_price_usd, 0) }}</h4>
                            <p class="text-muted small mb-2">per person</p>
                            
                            @php
                                $availableSeats = $flight->available_seats ?? 0;
                                $passengerCount = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0);
                                $hasEnoughSeats = $availableSeats >= $passengerCount;
                            @endphp
                            
                            @if($hasEnoughSeats)
                                <a href="{{ route('flight.seats', $flight->flight_instance_id) }}?adults={{ $searchParams['adults'] ?? 1 }}&children={{ $searchParams['children'] ?? 0 }}&infants={{ $searchParams['infants'] ?? 0 }}" class="btn btn-primary px-4">Select</a>
                            @else
                                <button class="btn btn-secondary" disabled title="Not enough seats available">
                                    <i class="bi bi-exclamation-circle"></i> Limited
                                </button>
                                <small class="text-danger d-block mt-1">Only {{ $availableSeats }} seat{{ $availableSeats != 1 ? 's' : '' }} left</small>
                            @endif
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
                            <p class="mb-0 text-muted small">
                                <i class="bi bi-suitcase me-1"></i> 20kg baggage &bull;
                                <i class="bi bi-utensils ms-2 me-1"></i> Meal included &bull;
                                <i class="bi bi-wifi ms-2 me-1"></i> Free Wi-Fi 
                                <span class="badge bg-success ms-3">{{ $availableSeats }} seats available</span>
                            </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<style>
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
    background-color: #ffffff;
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
.airline-logo {
    width: 70px;
    height: 70px;
    line-height: 1;
    font-weight: bold;
    font-size: 1.3rem;
}
</style>
@endsection