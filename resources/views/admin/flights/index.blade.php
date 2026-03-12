@extends('admin.layouts.app')

@section('title', 'Flight Management')
@section('page-title', 'Flight Instances')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-airplane-engines-fill text-primary"></i>
            <h5 class="mb-0">Flight Instances</h5>
        </div>
        <a href="{{ route('admin.flights.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New Flight
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Flight No.</th>
                        <th>Aircraft</th>
                        <th>Date</th>
                        <th>Seat Availability</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flights as $flight)
                    <tr>
                        <td>
                            <span style="font-family:'JetBrains Mono',monospace; font-size: 14px; font-weight: 700; color: var(--text-primary);">
                                {{ $flight->schedule->flight_number ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; background: var(--surface-2); border: 1px solid var(--border); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 14px;">
                                    <i class="bi bi-airplane"></i>
                                </div>
                                <span style="font-family:'JetBrains Mono',monospace; font-size: 13px; font-weight: 600;">{{ $flight->aircraftInstance->registration_number ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td style="font-weight: 600; font-size: 13.5px;">{{ $flight->flight_date->format('d M Y') }}</td>
                        <td>
                            @php
                                $totalSeats = $flight->aircraftInstance->aircraft->total_seats ?? 0;
                                $bookedSeats = \App\Models\BookingSeat::whereHas('booking', function($query) use ($flight) {
                                    $query->where('flight_instance_id', $flight->flight_instance_id)
                                          ->whereIn('booking_status', ['confirmed', 'pending']);
                                })->count();
                                $availableSeats = $totalSeats - $bookedSeats;
                                $pct = $totalSeats > 0 ? round(($bookedSeats / $totalSeats) * 100) : 0;
                            @endphp
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1; max-width: 120px; height: 6px; background: var(--surface-3); border-radius: 4px; overflow: hidden;">
                                    <div style="height: 100%; width: {{ $pct }}%; background: {{ $pct >= 90 ? 'var(--danger)' : ($pct >= 70 ? 'var(--warning)' : 'var(--success)') }}; border-radius: 4px; transition: width 0.3s;"></div>
                                </div>
                                <span style="font-family:'JetBrains Mono',monospace; font-size: 12px; color: var(--text-secondary);">{{ $availableSeats }}/{{ $totalSeats }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.flights.edit', $flight->flight_instance_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.flights.destroy', $flight->flight_instance_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Delete this flight instance?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-airplane-engines" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No flight instances found</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($flights->hasPages())
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            {{ $flights->links() }}
        </div>
        @endif
    </div>
</div>

@endsection