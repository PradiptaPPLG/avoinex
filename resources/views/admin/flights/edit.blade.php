@extends('admin.layouts.app')

@section('title', 'Edit Flight')
@section('page-title', 'Edit Flight Instance')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Flight Instance — #{{ $flight->flight_instance_id }}</h5>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.flights.update', $flight->flight_instance_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Schedule</label>
                <select name="schedule_id" class="form-select" required>
                    <option value="">Select Schedule</option>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->schedule_id }}" {{ old('schedule_id', $flight->schedule_id) == $schedule->schedule_id ? 'selected' : '' }}>
                            {{ $schedule->flight_number }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Aircraft Instance</label>
                <select name="aircraft_instance_id" class="form-select" required>
                    <option value="">Select Aircraft Instance</option>
                    @foreach($aircraftInstances as $instance)
                        <option value="{{ $instance->aircraft_instance_id }}" {{ old('aircraft_instance_id', $flight->aircraft_instance_id) == $instance->aircraft_instance_id ? 'selected' : '' }}>
                            {{ $instance->registration_number ?? 'N/A' }} - {{ $instance->aircraft->aircraft_model ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Flight Date</label>
                <input type="date" name="flight_date" class="form-control" value="{{ old('flight_date', $flight->flight_date->format('Y-m-d')) }}" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Update Flight</button>
            <a href="{{ route('admin.flights.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
