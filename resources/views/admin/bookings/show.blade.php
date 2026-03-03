@extends('admin.layouts.app')

@section('title', 'Booking Details')
@section('page-title', 'Booking Details')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Bookings
    </a>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Booking Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">Booking Code:</th>
                        <td><strong>{{ $booking->booking_code }}</strong></td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($booking->booking_status == 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($booking->booking_status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Payment:</th>
                        <td>
                            @if($booking->payment_status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning">Unpaid</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Total Price:</th>
                        <td><h4 class="text-primary">${{ number_format($booking->total_price_usd, 2) }}</h4></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Client Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">Name:</th>
                        <td>{{ $booking->client->first_name }} {{ $booking->client->last_name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $booking->client->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td>{{ $booking->client->phone }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Flight Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150">Flight Number:</th>
                        <td>{{ $booking->flightInstance->schedule->flight_number }}</td>
                    </tr>
                    <tr>
                        <th>Route:</th>
                        <td>
                            {{ $booking->flightInstance->schedule->originAirport->city }}
                            ({{ $booking->flightInstance->schedule->originAirport->iata_code }})
                            →
                            {{ $booking->flightInstance->schedule->destinationAirport->city }}
                            ({{ $booking->flightInstance->schedule->destinationAirport->iata_code }})
                        </td>
                    </tr>
                    <tr>
                        <th>Flight Date:</th>
                        <td>{{ $booking->flightInstance->flight_date->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Passengers</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Passport</th>
                                <th>DOB</th>
                                <th>Seat</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->bookingSeats as $seat)
                            <tr>
                                <td>{{ $seat->passenger_first_name }} {{ $seat->passenger_last_name }}</td>
                                <td>{{ $seat->passenger_passport }}</td>
                                <td>{{ $seat->passenger_date_of_birth ?? 'N/A' }}</td>
                                <td>{{ $seat->seat_id ?? 'Released' }}</td>
                                <td>${{ number_format($seat->price_at_booking, 2) }}</td>
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
