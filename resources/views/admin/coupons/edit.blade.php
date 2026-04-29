@extends('admin.layouts.app')

@section('title', 'Edit Coupon')
@section('page-title', 'Edit Coupon')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.coupons.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Back to List
    </a>
    <h4 class="mt-2">Edit Coupon: {{ $coupon->code }}</h4>
</div>

<div class="row">
    <div class="col-lg-9">
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm">
            @csrf
            @method('PUT')
            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="form-label">Coupon Image</label>
                    @if($coupon->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $coupon->image_path) }}" class="rounded shadow-sm" style="max-height: 150px;" alt="Current Image">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <div class="form-text small">Upload a new image to replace the current one. Max 2MB.</div>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control text-uppercase fw-bold @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" required>
                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Coupon Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $coupon->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2">{{ old('description', $coupon->description) }}</textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Discount Type</label>
                        <select name="discount_type" class="form-select">
                            <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                            <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rp)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                        <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value', $coupon->discount_value) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Max Discount (for % type)</label>
                        <input type="number" name="max_discount" class="form-control" value="{{ old('max_discount', $coupon->max_discount) }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Minimum Spend (Rp)</label>
                        <input type="number" name="min_spend" class="form-control" value="{{ old('min_spend', $coupon->min_spend) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Usage Limit (Per Code)</label>
                        <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Start Date & Time</label>
                        <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $coupon->start_date->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End Date & Time</label>
                        <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $coupon->end_date->format('Y-m-d\TH:i')) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $coupon->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Enable this coupon</label>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Update Coupon</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
