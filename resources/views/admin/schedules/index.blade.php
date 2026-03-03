@extends('admin.layouts.app')

@section('title', 'Schedule Management')
@section('page-title', 'Schedule Management')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Schedules List</h5>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Schedule
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Flight Number</th>
                        <th>Route</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->schedule_id }}</td>
                        <td><strong>{{ $schedule->flight_number }}</strong></td>
                        <td>{{ $schedule->originAirport->iata_code }} → {{ $schedule->destinationAirport->iata_code }}</td>
                        <td>{{ $schedule->departure_time_gmt }}</td>
                        <td>{{ $schedule->arrival_time_gmt }}</td>
                        <td>{{ $schedule->duration_minutes }} min</td>
                        <td>${{ number_format($schedule->base_price_usd, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.schedules.edit', $schedule->schedule_id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.schedules.destroy', $schedule->schedule_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this schedule?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No schedules found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $schedules->links() }}
    </div>
</div>
@endsection
