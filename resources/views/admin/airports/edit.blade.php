@extends('admin.layouts.app')

@section('title', 'Edit Airport')
@section('page-title', 'Edit Airport')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.airports.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Airports → Edit {{ $airport->iata_code }}</div>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-pencil-square"></i>
            Edit Airport — {{ $airport->iata_code }}
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.airports.update', $airport->airport_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">IATA Code</label>
                    <input type="text" name="iata_code" class="form-control" maxlength="3" style="text-transform: uppercase;" value="{{ old('iata_code', $airport->iata_code) }}" required>
                    @error('iata_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Airport Name</label>
                    <input type="text" name="airport_name" class="form-control" value="{{ old('airport_name', $airport->airport_name) }}" required>
                    @error('airport_name')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $airport->city) }}" required>
                    @error('city')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <select name="country_code" class="form-control" required>
                        <option value="">— Select Country —</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->country_code }}" {{ old('country_code', $airport->country_code) == $country->country_code ? 'selected' : '' }}>{{ $country->country_code }} — {{ $country->country_name }}</option>
                        @endforeach
                    </select>
                    @error('country_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Airport
                </button>
                <a href="{{ route('admin.airports.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
