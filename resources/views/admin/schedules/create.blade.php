@extends('admin.layouts.app')

@section('title', 'Create Schedule')
@section('page-title', 'Create Schedule')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Add New Schedule</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Flight Number</label>
                    <input type="text" name="flight_number" class="form-control" placeholder="e.g. GA-202" required>
                    @error('flight_number')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Airline</label>
                    <select name="airline_code" class="form-select" required>
                        <option value="">Select Airline</option>
                        @foreach($airlines as $airline)
                            <option value="{{ $airline->airline_code }}">{{ $airline->airline_code }} - {{ $airline->airline_name }}</option>
                        @endforeach
                    </select>
                    @error('airline_code')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Origin Airport</label>
                    <select name="origin_iata_code" class="form-select" required>
                        <option value="">Select Airport</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->iata_code }}">{{ $airport->iata_code }} - {{ $airport->city }}</option>
                        @endforeach
                    </select>
                    @error('origin_iata_code')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Destination Airport</label>
                    <select name="destination_iata_code" class="form-select" required>
                        <option value="">Select Airport</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->iata_code }}">{{ $airport->iata_code }} - {{ $airport->city }}</option>
                        @endforeach
                    </select>
                    @error('destination_iata_code')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Departure Time (GMT)</label>
                    <input type="time" name="departure_time_gmt" class="form-control" required>
                    @error('departure_time_gmt')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Arrival Time (GMT)</label>
                    <input type="time" name="arrival_time_gmt" class="form-control" required>
                    @error('arrival_time_gmt')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" class="form-control" placeholder="e.g. 150" required>
                    @error('duration_minutes')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Base Price (USD)</label>
                    <input type="number" step="0.01" name="base_price_usd" class="form-control" placeholder="e.g. 150.00" required>
                    @error('base_price_usd')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Effective From</label>
                    <input type="date" name="effective_from" class="form-control" value="{{ date('Y-m-d') }}" required>
                    @error('effective_from')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Effective To (Optional)</label>
                    <input type="date" name="effective_to" class="form-control">
                    @error('effective_to')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Create Schedule
                </button>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
