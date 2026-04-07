@extends('admin.layouts.app')

@section('title', 'Edit Schedule')
@section('page-title', 'Edit Schedule')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Schedules → Edit #{{ $schedule->schedule_id }}</div>
</div>

<div class="card" style="max-width: 860px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-pencil-square"></i>
            Modify Flight Schedule
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.schedules.update', $schedule->schedule_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Flight Identity --}}
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Flight Number</label>
                    <input type="text" name="flight_number" class="form-control" placeholder="e.g. GA-202" required value="{{ old('flight_number', $schedule->flight_number) }}">
                    @error('flight_number')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Airline</label>
                    <select name="airline_code" class="form-control" required>
                        <option value="">— Select Airline —</option>
                        @foreach($airlines as $airline)
                            <option value="{{ $airline->airline_code }}" {{ $schedule->airline_code == $airline->airline_code ? 'selected' : '' }}>
                                {{ $airline->airline_code }} — {{ $airline->airline_name }}
                            </option>
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
                                <option value="{{ $airport->iata_code }}" {{ $schedule->origin_iata_code == $airport->iata_code ? 'selected' : '' }}>
                                    {{ $airport->iata_code }} — {{ $airport->city }}
                                </option>
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
                                <option value="{{ $airport->iata_code }}" {{ $schedule->destination_iata_code == $airport->iata_code ? 'selected' : '' }}>
                                    {{ $airport->iata_code }} — {{ $airport->city }}
                                </option>
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
                    <input type="time" name="departure_time_gmt" class="form-control" required value="{{ old('departure_time_gmt', substr($schedule->departure_time_gmt, 0, 5)) }}">
                    @error('departure_time_gmt')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Arrival Time (GMT)</label>
                    <input type="time" name="arrival_time_gmt" class="form-control" required value="{{ old('arrival_time_gmt', substr($schedule->arrival_time_gmt, 0, 5)) }}">
                    @error('arrival_time_gmt')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" class="form-control" placeholder="e.g. 150" required value="{{ old('duration_minutes', $schedule->duration_minutes) }}">
                    @error('duration_minutes')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Pricing & Validity --}}
            <div class="row g-4 mb-4">
                @php
                    $exchangeRate = config('app.usd_to_idr', 15000);
                    $priceIdr = round($schedule->base_price_usd * $exchangeRate, 0);
                @endphp
                <div class="col-md-4">
                    <label class="form-label">Base Price (IDR)</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 600;">Rp</span>
                        <input type="number" name="base_price_idr" class="form-control rupiah-input" placeholder="0" style="padding-left: 36px;" required value="{{ old('base_price_idr', $priceIdr) }}">
                    </div>
                    @error('base_price_idr')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Effective From</label>
                    <input type="date" name="effective_from" class="form-control" required value="{{ old('effective_from', $schedule->effective_from) }}">
                    @error('effective_from')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Effective To <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <input type="date" name="effective_to" class="form-control" value="{{ old('effective_to', $schedule->effective_to) }}">
                    @error('effective_to')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Update Schedule
                </button>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
