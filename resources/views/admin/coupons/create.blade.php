@extends('admin.layouts.app')

@section('title', 'Create Coupon')
@section('page-title', 'New Coupon')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.coupons.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Back to List
    </a>
    <h4 class="mt-2">Create New Coupon</h4>
</div>

<div class="row">
    <div class="col-lg-9">
        <form action="{{ route('admin.coupons.store') }}" method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm">
            @csrf
            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="form-label">Coupon Image <span class="text-muted small">(Optional, will be displayed in deals)</span></label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <div class="form-text small">Recommended size: 1200x400px. Max 2MB.</div>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="code" id="couponCode" class="form-control text-uppercase fw-bold @error('code') is-invalid @enderror" placeholder="SUMMER20" value="{{ old('code') }}" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="generateCode()">Generate</button>
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Coupon Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Summer Vacation Promo" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Description (Visible to users)</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2">{{ old('description') }}</textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Discount Type</label>
                        <select name="discount_type" class="form-select">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount (Rp)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                        <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Max Discount (for % type)</label>
                        <input type="number" name="max_discount" class="form-control" placeholder="Optional" value="{{ old('max_discount') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Minimum Spend (Rp)</label>
                        <input type="number" name="min_spend" class="form-control" value="{{ old('min_spend', 0) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Usage Limit (Per Code)</label>
                        <input type="number" name="usage_limit" class="form-control" placeholder="Leave empty for unlimited" value="{{ old('usage_limit') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Start Date & Time</label>
                        <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', now()->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End Date & Time</label>
                        <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', now()->addMonth()->format('Y-m-d\TH:i')) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" checked>
                        <label class="form-check-label" for="isActive">Enable this coupon</label>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Create Coupon</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 8; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('couponCode').value = code;
}
</script>
@endsection
