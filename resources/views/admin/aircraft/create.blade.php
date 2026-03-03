@extends('admin.layouts.app')

@section('title', 'Create Aircraft')
@section('page-title', 'Create Aircraft')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Add New Aircraft</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.aircraft.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Registration Number</label>
                <input type="text" name="registration_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Model</label>
                <input type="text" name="model" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Manufacturer</label>
                <select name="manufacturer" class="form-control" required>
                    <option value="">-- Select Manufacturer --</option>
                    @foreach($manufacturers as $mfg)
                        <option value="{{ $mfg->aircraft_manufacturer_id }}">{{ $mfg->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Total Seats</label>
                <input type="number" name="total_seats" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('admin.aircraft.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
