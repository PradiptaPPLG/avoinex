@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-ticket-perforated"></i> My Bookings</h4>
        </div>
        <div class="card-body">
            @if($bookings->isEmpty())
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> You have no bookings yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Booking Code</th>
                                <th>Booking Date</th>
                                <th>Flight Number</th>
                                <th>Route</th>
                                <th>Flight Date</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td><strong>{{ $booking->booking_code }}</strong></td>
                                <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $booking->flightInstance->schedule->flight_number }}</td>
                                <td>
                                    {{ $booking->flightInstance->schedule->originAirport->city }} ({{ $booking->flightInstance->schedule->originAirport->iata_code }})
                                    →
                                    {{ $booking->flightInstance->schedule->destinationAirport->city }} ({{ $booking->flightInstance->schedule->destinationAirport->iata_code }})
                                </td>
                                <td>{{ $booking->flightInstance->flight_date->format('d M Y') }}</td>
                                <td>
                                    <div>Rp {{ number_format($booking->total_price_usd, 0, ',', '.') }}</div>
                                    @if($booking->bookingSeats->sum('baggage_weight') > 0)
                                        <div class="small text-muted"><i class="bi bi-suitcase"></i> Includes Baggage</div>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->booking_status === 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @else
                                        <span class="badge bg-warning">{{ ucfirst($booking->booking_status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-2" style="min-width: 90px;">
                                        <a href="{{ route('booking.confirmation', $booking->booking_id) }}" class="btn btn-sm btn-primary w-100 mb-1">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        @if($booking->booking_status === 'confirmed')
                                            <a href="{{ route('booking.ticket', $booking->booking_id) }}" target="_blank" class="btn btn-sm btn-outline-success w-100 mb-1">
                                                <i class="bi bi-file-earmark-pdf"></i> E-Ticket
                                            </a>
                                        @endif
                                        @php
                                            // Kita longgarkan logic: Selama belum berganti hari dari flight date
                                            $canCancel = \Carbon\Carbon::parse($booking->flightInstance->flight_date)->endOfDay()->isFuture();
                                        @endphp
                                        @if($booking->booking_status === 'confirmed' && $canCancel)
                                            <form action="{{ route('booking.cancel', $booking->booking_id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Are you sure you want to cancel this booking? Refund applies according to T&C.')">
                                                    <i class="bi bi-x-circle"></i> Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
