@extends('admin.layouts.app')

@section('title', 'Booking Details')
@section('page-title', 'Booking Details')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Bookings
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Bookings → Details</div>
    <span style="font-family:'JetBrains Mono',monospace; font-size: 13px; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 4px 12px; border-radius: 6px; border: 1px solid rgba(0,102,204,0.2);">
        {{ $booking->booking_code }}
    </span>
    @if($booking->booking_status == 'confirmed')
        <span class="badge bg-success">Confirmed</span>
    @elseif($booking->booking_status == 'cancelled')
        <span class="badge bg-danger">Cancelled</span>
    @else
        <span class="badge bg-warning">Pending</span>
    @endif
</div>

<div class="row g-3">
    {{-- Booking Info --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-receipt text-primary"></i>
                <h5 class="mb-0">Booking Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 4px;">Booking Code</div>
                        <div style="font-family:'JetBrains Mono',monospace; font-size: 18px; font-weight: 700; color: var(--primary);">{{ $booking->booking_code }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 4px;">Booking Date</div>
                        <div style="font-size: 14px; font-weight: 500;">{{ $booking->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 4px;">Booking Status</div>
                        @if($booking->booking_status == 'confirmed')
                            <span class="badge bg-success">Confirmed</span>
                        @elseif($booking->booking_status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 4px;">Payment Status</div>
                        @if($booking->payment_status == 'paid')
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Paid</span>
                        @else
                            <span class="badge bg-warning"><i class="bi bi-clock me-1"></i>Unpaid</span>
                        @endif
                    </div>
                    <div style="border-top: 1px solid var(--border); padding-top: 16px; margin-top: 4px;">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 4px;">Total Amount</div>
                        <div style="font-size: 28px; font-weight: 800; color: var(--primary);">${{ number_format($booking->total_price_usd, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Client Info --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-person-fill text-primary"></i>
                <h5 class="mb-0">Client Information</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 52px; height: 52px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                            {{ substr($booking->client->first_name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-size: 16px; font-weight: 700;">{{ $booking->client->first_name }} {{ $booking->client->last_name }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);">Passenger</div>
                        </div>
                    </div>
                    <div style="border-top: 1px solid var(--border); padding-top: 16px;">
                        <div class="d-flex flex-column gap-3">
                            <div>
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 4px;">Email</div>
                                <div style="font-size: 13.5px;">{{ $booking->client->email }}</div>
                            </div>
                            <div>
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 4px;">Phone</div>
                                <div style="font-size: 13.5px; font-family:'JetBrains Mono',monospace;">{{ $booking->client->phone }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Flight Info --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-airplane-fill text-primary"></i>
                <h5 class="mb-0">Flight Information</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 4px;">Flight Number</div>
                        <div style="font-family:'JetBrains Mono',monospace; font-size: 20px; font-weight: 700; color: var(--text-primary);">{{ $booking->flightInstance->schedule->flight_number }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 8px;">Route</div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="text-align: center;">
                                <div style="font-family:'JetBrains Mono',monospace; font-size: 22px; font-weight: 800; color: var(--text-primary);">{{ $booking->flightInstance->schedule->originAirport->iata_code }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $booking->flightInstance->schedule->originAirport->city }}</div>
                            </div>
                            <div style="flex: 1; display: flex; align-items: center; gap: 6px;">
                                <div style="flex: 1; height: 1px; background: var(--border);"></div>
                                <i class="bi bi-airplane-fill" style="color: var(--primary); font-size: 14px;"></i>
                                <div style="flex: 1; height: 1px; background: var(--border);"></div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-family:'JetBrains Mono',monospace; font-size: 22px; font-weight: 800; color: var(--text-primary);">{{ $booking->flightInstance->schedule->destinationAirport->iata_code }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $booking->flightInstance->schedule->destinationAirport->city }}</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 4px;">Flight Date</div>
                        <div style="font-size: 14px; font-weight: 600;">{{ $booking->flightInstance->flight_date->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Passengers --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-people-fill text-primary"></i>
                <h5 class="mb-0">Passenger Details</h5>
                <span class="badge bg-primary ms-1">{{ $booking->bookingSeats->count() }} passenger(s)</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Passport No.</th>
                                <th>Date of Birth</th>
                                <th>Seat</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->bookingSeats as $i => $seat)
                            <tr>
                                <td style="color: var(--text-muted); font-size: 12px;">{{ $i + 1 }}</td>
                                <td style="font-weight: 600;">{{ $seat->passenger_first_name }} {{ $seat->passenger_last_name }}</td>
                                <td>
                                    <span style="font-family:'JetBrains Mono',monospace; font-size: 12.5px; background: var(--surface-2); padding: 3px 8px; border-radius: 5px; border: 1px solid var(--border);">
                                        {{ $seat->passenger_passport }}
                                    </span>
                                </td>
                                <td style="color: var(--text-secondary); font-size: 13px;">{{ $seat->passenger_date_of_birth ?? '—' }}</td>
                                <td>
                                    @if($seat->seat_id)
                                        <span style="font-family:'JetBrains Mono',monospace; font-weight: 700; font-size: 14px; color: var(--primary); background: var(--primary-light); padding: 3px 10px; border-radius: 6px; border: 1px solid rgba(0,102,204,0.2);">
                                            {{ $seat->seat->seat_number ?? $seat->seat_id }}
                                        </span>
                                    @else
                                        <span style="color: var(--text-muted); font-size: 13px;">Released</span>
                                    @endif
                                    
                                    @if($seat->baggage_weight > 0)
                                    <div class="mt-2 text-muted" style="font-size: 12px;">
                                        <i class="bi bi-suitcase"></i> {{ $seat->baggage_weight }} kg (+${{ number_format($seat->baggage_price, 2) }})
                                    </div>
                                    @endif
                                </td>
                                <td style="font-weight: 700; font-size: 14px;">${{ number_format($seat->price_at_booking + $seat->baggage_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection