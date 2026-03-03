@extends('admin.layouts.app')

@section('title', 'Booking Management')
@section('page-title', 'Booking Management')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Bookings</h5>
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Booking Code</th>
                        <th>Client</th>
                        <th>Flight</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td><strong>{{ $booking->booking_code }}</strong></td>
                        <td>{{ $booking->client->first_name }} {{ $booking->client->last_name }}</td>
                        <td>{{ $booking->flightInstance->schedule->flight_number }}</td>
                        <td>{{ $booking->created_at->format('d M Y') }}</td>
                        <td>${{ number_format($booking->total_price_usd, 2) }}</td>
                        <td>
                            @if($booking->booking_status == 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($booking->booking_status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($booking->payment_status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $booking->booking_id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No bookings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $bookings->links() }}
    </div>
</div>
@endsection
