@extends('layouts.app')

@section('title', 'Available Flights - Avoinex')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-primary">Available Flights</h2>
            <p class="text-muted">Showing flights from {{ now()->format('d M Y') }}</p>
        </div>
    </div>

    @if($flights->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-airplane text-muted" style="font-size: 3rem;"></i>
            <h4 class="mt-3">No flights available</h4>
            <p class="text-muted">Try searching with different dates or routes.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Back to Search</a>
        </div>
    </div>
    @else
    @foreach($flights as $flight)
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <div class="airline-logo">
                        <strong>{{ $flight->airline_code ?? 'GA' }}</strong>
                    </div>
                   <small class="text-muted">
    @php
        $airlineCode = substr($flight->schedule->flight_number ?? 'GA-201', 0, 2);
        $airlineNames = [
            'GA' => 'Garuda Indonesia',
            'QZ' => 'AirAsia',
            'SQ' => 'Singapore Airlines',
            'MH' => 'Malaysia Airlines'
        ];
    @endphp
    {{ $airlineNames[$airlineCode] ?? 'Airlines' }}
</small>
                </div>
                
                <div class="col-md-3">
                    <h5 class="mb-1">{{ date('H:i', strtotime($flight->schedule->departure_time_gmt)) }}</h5>
                    <p class="mb-0 text-muted">{{ $flight->schedule->originAirport->city }} ({{ $flight->schedule->originAirport->iata_code }})</p>
                    <small class="text-muted">{{ $flight->flight_date->format('d M Y') }}</small>
                </div>
                
                <div class="col-md-2 text-center">
                    <div class="flight-duration">
                        <i class="bi bi-clock"></i>
                        <span>{{ floor($flight->schedule->duration_minutes / 60) }}h {{ $flight->schedule->duration_minutes % 60 }}m</span>
                    </div>
                    <div class="flight-route">
                        <div class="dotted-line"></div>
                        <span class="badge bg-success">Direct</span>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <h5 class="mb-1">{{ date('H:i', strtotime($flight->schedule->arrival_time_gmt)) }}</h5>
                    <p class="mb-0 text-muted">{{ $flight->schedule->destinationAirport->city }} ({{ $flight->schedule->destinationAirport->iata_code }})</p>
                    <small class="text-muted">{{ $flight->flight_date->format('d M Y') }}</small>
                </div>
                
                <div class="col-md-2 text-end">
                    <h4 class="text-primary mb-1">${{ number_format($flight->schedule->base_price_usd, 0) }}</h4>
                    <p class="text-muted small mb-2">per person</p>
                    
                    @php
                        $availableSeats = $flight->available_seats ?? 0;
                        $totalSeats = $flight->aircraftInstance->aircraft->total_seats ?? 180;
                        $isFull = $availableSeats <= 0;
                    @endphp
                    
                    @if($isFull)
                        <span class="badge bg-danger mb-2">Fully Booked</span>
                    @else
                        <span class="badge bg-success mb-2">{{ $availableSeats }} seats left</span>
                        <a href="{{ route('flight.seats', $flight->flight_instance_id) }}" 
                           class="btn btn-primary btn-sm">Select</a>
                    @endif
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <div class="flight-info">
                        <span class="badge bg-light text-dark me-2">
                            <i class="bi bi-suitcase"></i> 20kg
                        </span>
                        <span class="badge bg-light text-dark me-2">
                            <i class="bi bi-cup-straw"></i> Meal
                        </span>
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-wifi"></i> Wi-Fi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    <div class="mt-4">
        {{ $flights->links() }}
    </div>
    @endif
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
    margin: 0 auto 10px;
    font-size: 1.5rem;
    font-weight: bold;
}

.flight-duration {
    color: #666;
    margin-bottom: 10px;
}

.dotted-line {
    border-top: 2px dotted #ccc;
    margin: 5px 0;
    position: relative;
}

.dotted-line::before {
    content: '➝';
    position: absolute;
    left: 50%;
    top: -10px;
    transform: translateX(-50%);
    background: white;
    padding: 0 5px;
}

.flight-info {
    border-top: 1px solid #eee;
    padding-top: 10px;
}

.card:hover {
    transform: translateY(-2px);
    transition: transform 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}
</style>
@endsection