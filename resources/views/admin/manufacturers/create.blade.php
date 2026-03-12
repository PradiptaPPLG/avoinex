@extends('admin.layouts.app')

@section('title', 'Add Manufacturer')
@section('page-title', 'Add Manufacturer')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.manufacturers.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Manufacturers → Add New</div>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-building"></i>
            New Manufacturer
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.manufacturers.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label">Manufacturer Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Boeing" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <select name="country_code" class="form-control" required>
                        <option value="">— Select Country —</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->country_code }}" {{ old('country_code') == $country->country_code ? 'selected' : '' }}>{{ $country->country_code }} — {{ $country->country_name }}</option>
                        @endforeach
                    </select>
                    @error('country_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Founded Year <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <input type="number" name="founded_year" class="form-control" placeholder="e.g. 1916" min="1900" max="{{ date('Y') }}" value="{{ old('founded_year') }}">
                    @error('founded_year')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Create Manufacturer
                </button>
                <a href="{{ route('admin.manufacturers.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
