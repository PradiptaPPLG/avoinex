@extends('admin.layouts.app')

@section('title', 'Coupons & Deals')
@section('page-title', 'Coupons Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Coupons & Promo Codes</h4>
        <p class="text-muted small mb-0">Create and manage discount codes for your customers.</p>
    </div>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Coupon
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Coupon</th>
                        <th>Preview</th>
                        <th>Title & Type</th>
                        <th>Value</th>
                        <th>Validity</th>
                        <th>Usage</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                    <tr>
                        <td class="ps-4">
                            <code class="bg-light px-2 py-1 rounded text-primary fw-bold">{{ $coupon->code }}</code>
                        </td>
                        <td>
                            <div class="rounded-3 overflow-hidden" style="width: 120px; height: 60px; background: #f8f9fa; border: 1px solid #eee; display: flex; align-items: center; justify-content: center;">
                                @if($coupon->image_path)
                                    <img src="{{ asset('storage/' . $coupon->image_path) }}" class="w-100 h-100 object-fit-cover" alt="Preview">
                                @else
                                    <i class="bi bi-image text-muted fs-4"></i>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $coupon->title }}</div>
                            <div class="text-muted small">
                                @if($coupon->discount_type == 'percentage')
                                    Percentage Discount
                                @else
                                    Fixed Amount Discount
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fw-bold">
                                @if($coupon->discount_type == 'percentage')
                                    {{ number_format($coupon->discount_value, 0) }}%
                                @else
                                    Rp {{ number_format($coupon->discount_value, 0, ',', '.') }}
                                @endif
                            </div>
                            <div class="text-muted small">Min: Rp {{ number_format($coupon->min_spend, 0, ',', '.') }}</div>
                        </td>
                        <td>
                            <div class="small">
                                <span class="text-muted">From:</span> {{ $coupon->start_date->format('d M Y') }}<br>
                                <span class="text-muted">To:</span> {{ $coupon->end_date->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            <div class="progress mb-1" style="height: 4px; width: 100px;">
                                @php 
                                    $percent = $coupon->usage_limit ? ($coupon->used_count / $coupon->usage_limit) * 100 : 0;
                                @endphp
                                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%"></div>
                            </div>
                            <div class="small text-muted">{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}</div>
                        </td>
                        <td>
                            @php
                                $now = now();
                                $isActive = $coupon->is_active && $now->between($coupon->start_date, $coupon->end_date);
                            @endphp
                            @if($isActive)
                                <span class="badge bg-success">Active</span>
                            @elseif(!$coupon->is_active)
                                <span class="badge bg-danger">Disabled</span>
                            @elseif($now->lt($coupon->start_date))
                                <span class="badge bg-warning text-dark">Upcoming</span>
                            @else
                                <span class="badge bg-secondary">Expired</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid #ddd; box-shadow: none;">
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('admin.coupons.edit', $coupon->id) }}">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit Coupon
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" id="delete-form-{{ $coupon->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item py-2 text-danger" onclick="confirmDelete('{{ $coupon->id }}')">
                                                <i class="bi bi-trash me-2"></i> Delete Coupon
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-ticket-perforated display-4 mb-3 d-block"></i>
                                <p>No coupons found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this coupon? This action cannot be undone.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush

@push('styles')
<style>
    .avx-banner-thumb {
        background-color: #f8f9fa;
        border: 1px solid #eee;
    }
    .dropdown-item {
        font-size: 0.9rem;
    }
    .dropdown-item:active {
        background-color: #f8f9fa;
        color: inherit;
    }
</style>
@endpush
@endsection
