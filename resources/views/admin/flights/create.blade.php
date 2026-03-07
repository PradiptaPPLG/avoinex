@extends('admin.layouts.app')

@section('title', 'Create Flight')
@section('page-title', 'Create Flight Instance')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Add New Flight Instance</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.flights.store') }}" method="POST">
            @csrf

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Schedule</label>
                <select name="schedule_id" class="form-select" required>
                    <option value="">Select Schedule</option>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->schedule_id }}">{{ $schedule->flight_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Aircraft Instance</label>
                <select name="aircraft_instance_id" class="form-select" required>
                    <option value="">Select Aircraft Instance</option>
                    @foreach($aircraftInstances as $instance)
                        <option value="{{ $instance->aircraft_instance_id }}">{{ $instance->aircraft->registration_number ?? 'N/A' }} - {{ $instance->aircraft->aircraft_model ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Flight Date</label>
                <input type="date" name="flight_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('admin.flights.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
