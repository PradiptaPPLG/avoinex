@extends('admin.layouts.app')

@section('title', 'Create Schedule')
@section('page-title', 'Create Schedule')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Schedules → Create New</div>
</div>

<div class="card" style="max-width: 860px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-calendar-plus"></i>
            New Flight Schedule
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf

            {{-- Flight Identity --}}
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Flight Number</label>
                    <input type="text" name="flight_number" class="form-control" placeholder="e.g. GA-202" required>
                    @error('flight_number')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Airline</label>
                    <select name="airline_code" class="form-control" required>
                        <option value="">— Select Airline —</option>
                        @foreach($airlines as $airline)
                            <option value="{{ $airline->airline_code }}">{{ $airline->airline_code }} — {{ $airline->airline_name }}</option>
                        @endforeach
                    </select>
                    @error('airline_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Route --}}
            <div style="background: var(--surface-2); border: 1.5px solid var(--border); border-radius: 10px; padding: 20px; margin-bottom: 24px;">
                <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 16px;">Route</div>
                <div class="row g-4 align-items-center">
                    <div class="col-md-5">
                        <label class="form-label">Origin Airport</label>
                        <select name="origin_iata_code" class="form-control" required>
                            <option value="">— Select Airport —</option>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->iata_code }}">{{ $airport->iata_code }} — {{ $airport->city }}</option>
                            @endforeach
                        </select>
                        @error('origin_iata_code')
                            <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2 text-center" style="padding-top: 24px;">
                        <i class="bi bi-arrow-right" style="font-size: 22px; color: var(--primary);"></i>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Destination Airport</label>
                        <select name="destination_iata_code" class="form-control" required>
                            <option value="">— Select Airport —</option>
                            @foreach($airports as $airport)
                                <option value="{{ $airport->iata_code }}">{{ $airport->iata_code }} — {{ $airport->city }}</option>
                            @endforeach
                        </select>
                        @error('destination_iata_code')
                            <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Timing --}}
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Departure Time (GMT)</label>
                    <input type="time" name="departure_time_gmt" class="form-control" required>
                    @error('departure_time_gmt')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Arrival Time (GMT)</label>
                    <input type="time" name="arrival_time_gmt" class="form-control" required>
                    @error('arrival_time_gmt')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" class="form-control" placeholder="e.g. 150" required>
                    @error('duration_minutes')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Pricing & Validity --}}
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Base Price (USD)</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 600;">$</span>
                        <input type="number" step="0.01" name="base_price_usd" class="form-control" placeholder="0.00" style="padding-left: 28px;" required>
                    </div>
                    @error('base_price_usd')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Effective From</label>
                    <input type="date" name="effective_from" class="form-control" value="{{ date('Y-m-d') }}" required>
                    @error('effective_from')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Effective To <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <input type="date" name="effective_to" class="form-control">
                    @error('effective_to')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Create Schedule
                </button>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection