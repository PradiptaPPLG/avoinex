@extends('admin.layouts.app')

@section('title', 'Edit Aircraft')
@section('page-title', 'Edit Aircraft')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Aircraft — {{ $aircraft->registration_number }}</h5>
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

        <form action="{{ route('admin.aircraft.update', $aircraft->aircraft_id) }}" method="POST" id="aircraft-form">
            @csrf
            @method('PUT')

            {{-- Basic Info --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Registration Number</label>
                    <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $aircraft->registration_number) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Model</label>
                    <input type="text" name="model" class="form-control" value="{{ old('model', $aircraft->aircraft_model) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Manufacturer</label>
                    <select name="manufacturer" class="form-control" required>
                        <option value="">-- Select Manufacturer --</option>
                        @foreach($manufacturers as $mfg)
                            <option value="{{ $mfg->aircraft_manufacturer_id }}" {{ old('manufacturer', $aircraft->manufacturer_id) == $mfg->aircraft_manufacturer_id ? 'selected' : '' }}>
                                {{ $mfg->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr>

            {{-- Seat Configuration --}}
            <h6 class="fw-bold mb-3"><i class="bi bi-grid-3x3"></i> Seat Configuration</h6>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Seats per Row (Width)</label>
                    <input type="number" name="seat_columns" id="seat_columns" class="form-control" min="2" max="12" value="{{ old('seat_columns', $aircraft->seat_columns ?? 6) }}" required>
                    <small class="text-muted">e.g. 6 = A B C | D E F</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Rows (Length)</label>
                    <input type="number" name="seat_rows" id="seat_rows" class="form-control" min="5" max="80" value="{{ old('seat_rows', $aircraft->seat_rows ?? 30) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Seats</label>
                    <div class="form-control bg-light fw-bold text-primary" id="total_seats_display">{{ ($aircraft->seat_columns ?? 6) * ($aircraft->seat_rows ?? 30) }}</div>
                    <small class="text-muted">Auto-calculated</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Seat Letters Preview</label>
                    <div class="form-control bg-light" id="seat_letters_preview">A B C | D E F</div>
                </div>
            </div>

            <hr>

            {{-- Class Configuration --}}
            <h6 class="fw-bold mb-3"><i class="bi bi-stars"></i> Class Configuration</h6>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Business Class Rows</label>
                    <input type="number" name="business_rows" id="business_rows" class="form-control" min="0" max="20" value="{{ old('business_rows', $aircraft->business_rows ?? 2) }}" required>
                    <small class="text-muted">Starting from row 1</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Business Seats</label>
                    <div class="form-control bg-light" id="business_seats_display">{{ ($aircraft->seat_columns ?? 6) * ($aircraft->business_rows ?? 2) }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Economy Seats</label>
                    <div class="form-control bg-light" id="economy_seats_display">{{ $aircraft->economy_seats ?? 168 }}</div>
                </div>
            </div>

            <hr>

            {{-- Preferred Zone --}}
            <h6 class="fw-bold mb-3"><i class="bi bi-arrows-angle-expand"></i> Preferred Zone (Extra Legroom)</h6>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="preferred_zone_enabled" id="preferred_zone_enabled" value="1" {{ old('preferred_zone_enabled', $aircraft->preferred_zone_enabled) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="preferred_zone_enabled">
                        Enable Preferred Zone (Extra Legroom Seats)
                    </label>
                </div>
            </div>

            <div id="preferred_zone_fields" style="display: none;">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Start Row</label>
                        <input type="number" name="preferred_zone_start_row" id="preferred_zone_start_row" class="form-control" min="1" value="{{ old('preferred_zone_start_row', $aircraft->preferred_zone_start_row ?? 3) }}">
                        <small class="text-muted">Auto-filled: after business rows</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">End Row</label>
                        <input type="number" name="preferred_zone_end_row" id="preferred_zone_end_row" class="form-control" min="1" value="{{ old('preferred_zone_end_row', $aircraft->preferred_zone_end_row ?? 5) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Preferred Zone Seats</label>
                        <div class="form-control bg-light" id="preferred_seats_display">0</div>
                    </div>
                </div>
            </div>

            <hr>

            {{-- Layout Summary --}}
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <h6 class="fw-bold"><i class="bi bi-layout-text-window-reverse"></i> Layout Summary</h6>
                    <div id="layout_summary" class="d-flex flex-wrap gap-2 align-items-center">
                        <!-- filled by JS -->
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Update Aircraft</button>
            <a href="{{ route('admin.aircraft.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cols = document.getElementById('seat_columns');
    const rows = document.getElementById('seat_rows');
    const bizRows = document.getElementById('business_rows');
    const prefEnabled = document.getElementById('preferred_zone_enabled');
    const prefStart = document.getElementById('preferred_zone_start_row');
    const prefEnd = document.getElementById('preferred_zone_end_row');
    const prefFields = document.getElementById('preferred_zone_fields');

    function getLetters(n) {
        let letters = [];
        for (let i = 0; i < n; i++) letters.push(String.fromCharCode(65 + i));
        return letters;
    }

    function update() {
        const c = parseInt(cols.value) || 6;
        const r = parseInt(rows.value) || 30;
        const b = parseInt(bizRows.value) || 0;
        const total = c * r;
        const letters = getLetters(c);
        const half = Math.ceil(c / 2);
        const leftSide = letters.slice(0, half).join(' ');
        const rightSide = letters.slice(half).join(' ');

        document.getElementById('total_seats_display').textContent = total;
        document.getElementById('seat_letters_preview').textContent = leftSide + ' | ' + rightSide;
        document.getElementById('business_seats_display').textContent = c * b;

        let econStart = b + 1;
        let prefSeats = 0;

        if (prefEnabled.checked) {
            prefFields.style.display = 'block';
            const ps = parseInt(prefStart.value) || (b + 1);
            const pe = parseInt(prefEnd.value) || (b + 3);
            prefSeats = c * (pe - ps + 1);
            econStart = pe + 1;
            document.getElementById('preferred_seats_display').textContent = prefSeats;
        } else {
            prefFields.style.display = 'none';
        }

        const econRows = Math.max(0, r - econStart + 1);
        document.getElementById('economy_seats_display').textContent = c * econRows;

        // Layout summary
        let summary = '';
        if (b > 0) summary += `<span class="badge bg-warning text-dark">Business: Rows 1-${b} (${c * b} seats)</span>`;
        if (prefEnabled.checked) {
            const ps = parseInt(prefStart.value) || (b + 1);
            const pe = parseInt(prefEnd.value) || (b + 3);
            summary += `<span class="badge bg-info">Preferred: Rows ${ps}-${pe} (${prefSeats} seats)</span>`;
        }
        if (econRows > 0) summary += `<span class="badge bg-success">Economy: Rows ${econStart}-${r} (${c * econRows} seats)</span>`;
        summary += `<span class="badge bg-primary">Total: ${total} seats</span>`;
        document.getElementById('layout_summary').innerHTML = summary;
    }

    cols.addEventListener('input', update);
    rows.addEventListener('input', update);
    bizRows.addEventListener('input', update);
    prefEnabled.addEventListener('change', update);
    prefStart.addEventListener('input', update);
    prefEnd.addEventListener('input', update);

    update();
});
</script>
@endpush
@endsection
