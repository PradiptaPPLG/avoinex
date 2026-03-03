@extends('admin.layouts.app')

@section('title', 'Flight Management')
@section('page-title', 'Flight Instances Management')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Flight Instances</h5>
        <a href="{{ route('admin.flights.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Flight
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Flight Number</th>
                        <th>Aircraft</th>
                        <th>Date</th>
                        <th>Available Seats</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flights as $flight)
                    <tr>
                        <td>{{ $flight->flight_instance_id }}</td>
                        <td><strong>{{ $flight->schedule->flight_number ?? 'N/A' }}</strong></td>
                        <td>{{ $flight->aircraftInstance->registration_number ?? 'N/A' }}</td>
                        <td>{{ $flight->flight_date->format('d M Y') }}</td>
                        <td>
                            @php
                                $totalSeats = $flight->aircraftInstance->aircraft->total_seats ?? 0;
                                $bookedSeats = \App\Models\BookingSeat::whereHas('booking', function($query) use ($flight) {
                                    $query->where('flight_instance_id', $flight->flight_instance_id)
                                          ->whereIn('booking_status', ['confirmed', 'pending']);
                                })->count();
                                $availableSeats = $totalSeats - $bookedSeats;
                            @endphp
                            {{ $availableSeats }} / {{ $totalSeats }}
                        </td>
                        <td>
                            @if($availableSeats > 0)
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-danger">Full</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.flights.edit', $flight->flight_instance_id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.flights.destroy', $flight->flight_instance_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this flight?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No flights found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $flights->links() }}
    </div>
</div>
@endsection
