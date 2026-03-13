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
                        <div class="col-md-2 text-end">
                            <h4 class="text-primary mb-1">${{ number_format($flight->schedule->base_price_usd, 0) }}</h4>
                            <p class="text-muted small mb-2">per person</p>
                            
                            @php
                                $availableSeats = $flight->available_seats ?? 0;
                                $passengerCount = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0);
                                $hasEnoughSeats = $availableSeats >= $passengerCount;
                            @endphp
                            
                            @if($hasEnoughSeats)
                                <a href="{{ route('flight.seats', $flight->flight_instance_id) }}?adults={{ $searchParams['adults'] ?? 1 }}&children={{ $searchParams['children'] ?? 0 }}&infants={{ $searchParams['infants'] ?? 0 }}" class="btn btn-primary">Select</a>
                            @else
                                <button class="btn btn-secondary" disabled title="Not enough seats available">
                                    <i class="bi bi-exclamation-circle"></i> Limited
                                </button>
                                <small class="text-danger d-block mt-1">Only {{ $availableSeats }} seat{{ $availableSeats != 1 ? 's' : '' }} left</small>
                            @endif
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
            @endif
        </div>
    </div>
</div>

<style>
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
</style>
@endsection