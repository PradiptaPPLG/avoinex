@extends('admin.layouts.app')

@section('title', 'Edit Country')
@section('page-title', 'Edit Country')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Countries → Edit {{ $country->country_name }}</div>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-pencil-square"></i>
            Edit Country — {{ $country->country_name }}
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.countries.update', $country->country_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Country Code</label>
                    <input type="text" name="country_code" class="form-control" maxlength="2" style="text-transform: uppercase;" value="{{ old('country_code', $country->country_code) }}" required>
                    @error('country_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Country Name</label>
                    <input type="text" name="country_name" class="form-control" value="{{ old('country_name', $country->country_name) }}" required>
                    @error('country_name')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Phone Code <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <input type="text" name="phone_code" class="form-control" value="{{ old('phone_code', $country->phone_code) }}">
                    @error('phone_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Continent <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <select name="continent" class="form-control">
                        <option value="">— Select Continent —</option>
                        @foreach(['Asia', 'Europe', 'North America', 'South America', 'Africa', 'Oceania', 'Antarctica'] as $c)
                            <option value="{{ $c }}" {{ old('continent', $country->continent) == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                    @error('continent')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Country
                </button>
                <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
