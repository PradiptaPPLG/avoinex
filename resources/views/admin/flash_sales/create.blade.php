@extends('admin.layouts.app')

@section('page-title', 'Create Flash Sale')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle text-primary me-2"></i>New Flash Sale</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.flash_sales.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                <!-- Flight Selection -->
                <div class="col-12">
                    <label for="flight_id" class="form-label">Select Flight Instance <span class="text-danger">*</span></label>
                    <select name="flight_id" id="flight_id" class="form-select @error('flight_id') is-invalid @enderror" required>
                        <option value="">-- Choose an active flight --</option>
                        @foreach($flights as $flight)
                            <option value="{{ $flight->id }}" {{ old('flight_id') == $flight->id ? 'selected' : '' }}>
                                {{ $flight->text }}
                            </option>
                        @endforeach
                    </select>
                    @error('flight_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Discount Settings -->
                <div class="col-md-6">
                    <label for="discount_type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                    <select name="discount_type" id="discount_type" class="form-select @error('discount_type') is-invalid @enderror" required>
                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                    </select>
                    @error('discount_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                    <input type="number" name="discount_value" id="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value') }}" required min="1">
                    @error('discount_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Time Settings -->
                <div class="col-md-6">
                    <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', now()->format('Y-m-d\TH:i')) }}" required>
                    @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', now()->addDays(2)->format('Y-m-d\TH:i')) }}" required>
                    @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Configuration -->
                <div class="col-md-4">
                    <label for="max_seats" class="form-label">Max Promo Seats <span class="text-danger">*</span></label>
                    <input type="number" name="max_seats" id="max_seats" class="form-control @error('max_seats') is-invalid @enderror" value="{{ old('max_seats', 10) }}" required min="1">
                    @error('max_seats')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="priority" class="form-label">Display Priority <small class="text-muted">(Higher = Top)</small> <span class="text-danger">*</span></label>
                    <input type="number" name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror" value="{{ old('priority', 0) }}" required min="0">
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="is_active" id="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.flash_sales.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i> Save Flash Sale</button>
            </div>
        </form>
    </div>
</div>
@endsection
