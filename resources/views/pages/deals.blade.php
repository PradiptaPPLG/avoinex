@extends('layouts.app')

@section('title', 'Promosi & Kupon Spesial — Avoinex')

@section('content')
<div class="avx-deals-hero py-5" style="background: linear-gradient(135deg, #0066CC 0%, #00C2A8 100%);">
    <div class="container py-4 text-center text-white">
        <h1 class="display-4 fw-bold mb-3">Today's Deals</h1>
        <p class="lead opacity-75">Spontan hemat. Penawaran terbaik yang tidak ada di tempat lain.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-4">Applicable Products</h5>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" checked id="flightsCheck">
                    <label class="form-check-label d-flex justify-content-between w-100" for="flightsCheck">
                        <span>Flights</span>
                        <span class="text-muted small">({{ $coupons->count() }})</span>
                    </label>
                </div>
                
                <hr class="my-4">
                
                <h5 class="fw-bold mb-4">Deals Type</h5>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" checked id="couponsCheck">
                    <label class="form-check-label" for="couponsCheck">Coupons</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" checked id="bannersCheck">
                    <label class="form-check-label" for="bannersCheck">Promotions</label>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Coupons Grid -->
            <h3 class="fw-bold mb-4">Claim Your Coupons</h3>
            <div class="row g-4 mb-5">
                @forelse($coupons as $coupon)
                <div class="col-md-6 col-xl-4">
                    <div class="avx-coupon-item card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        @if($coupon->image_path)
                        <div class="avx-coupon-image position-relative" style="height: 160px;">
                            <img src="{{ asset('storage/' . $coupon->image_path) }}" class="w-100 h-100 object-fit-cover" alt="{{ $coupon->title }}">
                            <div class="avx-coupon-badge position-absolute top-0 end-0 m-3">
                                <span class="badge bg-white text-primary shadow-sm py-2 px-3 fw-bold rounded-pill">
                                    @if($coupon->discount_type == 'percentage')
                                        {{ number_format($coupon->discount_value, 0) }}% OFF
                                    @else
                                        Rp{{ number_format($coupon->discount_value / 1000, 0) }}rb OFF
                                    @endif
                                </span>
                            </div>
                        </div>
                        @else
                        <div class="avx-coupon-header p-4 text-center" style="background: {{ $coupon->discount_type == 'percentage' ? '#EBF5FF' : '#F0FDF4' }};">
                            <div class="avx-coupon-value display-6 fw-bold mb-0" style="color: {{ $coupon->discount_type == 'percentage' ? '#0066CC' : '#059669' }};">
                                @if($coupon->discount_type == 'percentage')
                                    UP TO {{ number_format($coupon->discount_value, 0) }}%
                                @else
                                    Rp {{ number_format($coupon->discount_value / 1000, 0) }}rb
                                @endif
                            </div>
                            <div class="small fw-bold opacity-75">OFF FLIGHTS</div>
                        </div>
                        @endif
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="fw-bold mb-2">{{ $coupon->title }}</h5>
                            <p class="text-muted small mb-3">{{ $coupon->description }}</p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-light text-muted fw-normal">Expires in {{ $coupon->end_date->diffForHumans() }}</span>
                                    <span class="text-primary fw-bold small">Min. spend Rp {{ number_format($coupon->min_spend / 1000, 0) }}rb</span>
                                </div>
                                <button class="btn btn-primary w-100 rounded-pill fw-bold avx-claim-btn" data-code="{{ $coupon->code }}">
                                    CLAIM COUPON
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No active coupons available at the moment.</p>
                </div>
                @endforelse
            </div>

            <!-- Promotion Banners -->
            <h3 class="fw-bold mb-4">Ongoing Promotions</h3>
            <div class="row g-4">
                @foreach($banners as $banner)
                <div class="col-12">
                    <a href="{{ $banner->link_url ?? '#' }}" class="avx-promo-wide card border-0 shadow-sm rounded-4 overflow-hidden text-decoration-none">
                        <div class="row g-0">
                            <div class="col-md-5">
                                <img src="{{ asset('storage/' . $banner->image_path) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $banner->title }}" style="min-height: 200px;">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-4 h-100 d-flex flex-column justify-content-center">
                                    <span class="badge bg-warning text-dark mb-2 align-self-start">LIMITED TIME</span>
                                    <h4 class="fw-bold text-dark mb-2">{{ $banner->title }}</h4>
                                    <p class="text-muted mb-4">{{ $banner->subtitle }}</p>
                                    <span class="text-primary fw-bold">Explore Now <i class="bi bi-arrow-right ms-2"></i></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
.avx-coupon-item {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.avx-coupon-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
}
.avx-promo-wide {
    transition: all 0.3s ease;
}
.avx-promo-wide:hover {
    transform: scale(1.01);
}
.avx-claim-btn {
    transition: all 0.2s;
}
.avx-claim-btn.claimed {
    background-color: #059669 !important;
    border-color: #059669 !important;
}
</style>

<script>
document.querySelectorAll('.avx-claim-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const code = this.getAttribute('data-code');
        navigator.clipboard.writeText(code).then(() => {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check2 me-2"></i> COPIED!';
            this.classList.add('claimed');
            
            setTimeout(() => {
                this.innerHTML = originalText;
                this.classList.remove('claimed');
            }, 3000);
        });
    });
});
</script>
@endsection
