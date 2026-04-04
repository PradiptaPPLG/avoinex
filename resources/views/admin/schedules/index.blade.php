@extends('admin.layouts.app')

@section('title', 'Schedule Management')
@section('page-title', 'Flight Schedules')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-calendar3 text-primary"></i>
            <h5 class="mb-0">Schedule Registry</h5>
        </div>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Schedule
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Flight No.</th>
                        <th>Route</th>
                        <th>Departure (GMT)</th>
                        <th>Arrival (GMT)</th>
                        <th>Duration</th>
                        <th>Base Price</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                    <tr>
                        <td>
                            <span style="font-family:'JetBrains Mono',monospace; font-size: 14px; font-weight: 700; color: var(--text-primary);">
                                {{ $schedule->flight_number }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-family:'JetBrains Mono',monospace; font-weight: 700; font-size: 13px; background: var(--surface-2); padding: 3px 8px; border-radius: 5px; border: 1px solid var(--border);">{{ $schedule->originAirport->iata_code }}</span>
                                <i class="bi bi-arrow-right" style="color: var(--text-muted); font-size: 12px;"></i>
                                <span style="font-family:'JetBrains Mono',monospace; font-weight: 700; font-size: 13px; background: var(--surface-2); padding: 3px 8px; border-radius: 5px; border: 1px solid var(--border);">{{ $schedule->destinationAirport->iata_code }}</span>
                            </div>
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-size: 13px; font-weight: 500;">{{ $schedule->departure_time_gmt }}</td>
                        <td style="font-family:'JetBrains Mono',monospace; font-size: 13px; font-weight: 500;">{{ $schedule->arrival_time_gmt }}</td>
                        <td>
                            <span style="font-size: 13px; color: var(--text-secondary); font-weight: 500;">
                                <i class="bi bi-clock me-1" style="font-size: 11px;"></i>{{ $schedule->duration_minutes }} min
                            </span>
                        </td>
                        <td>
                            <span style="font-weight: 700; font-size: 14px; color: var(--success);">Rp {{ number_format($schedule->base_price_usd, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.schedules.edit', $schedule->schedule_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.schedules.destroy', $schedule->schedule_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="confirmDelete(event, this.closest('form'), 'Delete this schedule?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-calendar3" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No schedules found</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            {{ $schedules->links() }}
        </div>
        @endif
    </div>
</div>

@endsection