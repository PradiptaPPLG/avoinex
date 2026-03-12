@extends('admin.layouts.app')

@section('title', 'Add Country')
@section('page-title', 'Add Country')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Countries → Add New</div>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-globe-americas"></i>
            New Country
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.countries.store') }}" method="POST">
            @csrf

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Country Code</label>
                    <input type="text" name="country_code" class="form-control" placeholder="e.g. ID" maxlength="2" style="text-transform: uppercase;" value="{{ old('country_code') }}" required>
                    @error('country_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Country Name</label>
                    <input type="text" name="country_name" class="form-control" placeholder="e.g. Indonesia" value="{{ old('country_name') }}" required>
                    @error('country_name')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Phone Code <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <input type="text" name="phone_code" class="form-control" placeholder="e.g. +62" value="{{ old('phone_code') }}">
                    @error('phone_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Continent <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <select name="continent" class="form-control">
                        <option value="">— Select Continent —</option>
                        @foreach(['Asia', 'Europe', 'North America', 'South America', 'Africa', 'Oceania', 'Antarctica'] as $c)
                            <option value="{{ $c }}" {{ old('continent') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                    @error('continent')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Create Country
                </button>
                <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
