@extends('admin.layouts.app')

@section('title', 'Edit Airline')
@section('page-title', 'Edit Airline')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.airlines.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Airlines → Edit {{ $airline->airline_name }}</div>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-pencil-square"></i>
            Edit Airline — {{ $airline->airline_name }}
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.airlines.update', $airline->airline_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Airline Code</label>
                    <input type="text" name="airline_code" class="form-control" maxlength="10" style="text-transform: uppercase;" value="{{ old('airline_code', $airline->airline_code) }}" required>
                    @error('airline_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Airline Name</label>
                    <input type="text" name="airline_name" class="form-control" value="{{ old('airline_name', $airline->airline_name) }}" required>
                    @error('airline_name')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <select name="country_code" class="form-control" required>
                        <option value="">— Select Country —</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->country_code }}" {{ old('country_code', $airline->country_code) == $country->country_code ? 'selected' : '' }}>{{ $country->country_code }} — {{ $country->country_name }}</option>
                        @endforeach
                    </select>
                    @error('country_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Phone <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $airline->contact_phone) }}">
                    @error('contact_phone')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Website <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                <input type="url" name="website" class="form-control" value="{{ old('website', $airline->website) }}">
                @error('website')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Airline
                </button>
                <a href="{{ route('admin.airlines.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
