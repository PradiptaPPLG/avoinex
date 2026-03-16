@extends('layouts.app')

@section('title', 'Continue Booking - Avoinex')

@section('content')
<div class="avx-auth-gate-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <!-- Flight Summary Mini Card -->
                @if(isset($flight))
                <div class="avx-auth-flight-summary mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="avx-auth-label">Flight</span>
                            <h5 class="mb-0 fw-bold">
                                {{ $flight->schedule->originAirport->iata_code ?? '---' }}
                                <span class="mx-2" style="color:#279ED6;">→</span>
                                {{ $flight->schedule->destinationAirport->iata_code ?? '---' }}
                            </h5>
                        </div>
                        <div class="text-end">
                            <span class="avx-auth-label">Date</span>
                            <h6 class="mb-0 fw-bold">{{ $flight->flight_date->format('d M Y') }}</h6>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Main Auth Card -->
                <div class="avx-auth-card">
                    <div class="avx-auth-header">
                        <div class="avx-auth-icon-circle">
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                        <h3 class="avx-auth-title">How would you like to continue?</h3>
                        <p class="avx-auth-subtitle">Sign in for a faster experience or continue as a guest</p>
                    </div>

                    <div class="avx-auth-body">
                        <!-- Option 1: Login -->
                        <a href="javascript:void(0)" onclick="showModal('login')" class="avx-auth-option avx-auth-login">
                            <div class="avx-auth-option-icon" style="background:linear-gradient(135deg,#279ED6,#1a7ab5);">
                                <i class="bi bi-box-arrow-in-right"></i>
                            </div>
                            <div class="avx-auth-option-text">
                                <h6 class="mb-1 fw-bold">Login</h6>
                                <p class="mb-0 text-muted small">Sign in with your existing account</p>
                            </div>
                            <i class="bi bi-chevron-right avx-auth-chevron"></i>
                        </a>

                        <!-- Option 2: Register -->
                        <a href="javascript:void(0)" onclick="showModal('register')" class="avx-auth-option avx-auth-register">
                            <div class="avx-auth-option-icon" style="background:linear-gradient(135deg,#28a745,#20c997);">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div class="avx-auth-option-text">
                                <h6 class="mb-1 fw-bold">Create Account</h6>
                                <p class="mb-0 text-muted small">Register to manage your bookings easily</p>
                            </div>
                            <i class="bi bi-chevron-right avx-auth-chevron"></i>
                        </a>

                        <!-- Divider -->
                        <div class="avx-auth-divider">
                            <span>or</span>
                        </div>

                        <!-- Option 3: Guest -->
                        <form action="{{ route('booking.guest') }}" method="POST">
                            @csrf
                            @if(request('seats'))
                                <input type="hidden" name="seats" value="{{ request('seats') }}">
                            @endif
                            @if(request('total'))
                                <input type="hidden" name="total" value="{{ request('total') }}">
                            @endif
                            @if(request('flight_id'))
                                <input type="hidden" name="flight_id" value="{{ request('flight_id') }}">
                            @endif
                            @if(request('adults'))
                                <input type="hidden" name="adults" value="{{ request('adults') }}">
                            @endif
                            @if(request('children'))
                                <input type="hidden" name="children" value="{{ request('children') }}">
                            @endif
                            @if(request('infants'))
                                <input type="hidden" name="infants" value="{{ request('infants') }}">
                            @endif
                            <button type="submit" class="avx-auth-option avx-auth-guest w-100" style="border:none; cursor:pointer; text-align:left;">
                                <div class="avx-auth-option-icon" style="background:linear-gradient(135deg,#6c757d,#495057);">
                                    <i class="bi bi-incognito"></i>
                                </div>
                                <div class="avx-auth-option-text">
                                    <h6 class="mb-1 fw-bold">Continue as Guest</h6>
                                    <p class="mb-0 text-muted small">No account needed — just provide your email</p>
                                </div>
                                <i class="bi bi-chevron-right avx-auth-chevron"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Footer note -->
                    <div class="avx-auth-footer">
                        <p class="mb-0"><i class="bi bi-shield-check me-1"></i> Your data is protected and secure</p>
                    </div>
                </div>

                <!-- Back Link -->
                <div class="text-center mt-3">
                    <a href="javascript:history.back()" class="text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i> Back to Seat Selection
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.avx-auth-gate-bg {
    min-height: 80vh;
    background: linear-gradient(135deg, #f0f7fc 0%, #e8f4fd 50%, #f5f5f5 100%);
    padding: 60px 0;
}

.avx-auth-flight-summary {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px 28px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid rgba(39,158,214,0.15);
}
.avx-auth-label {
    font-size: 11px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: block;
    margin-bottom: 2px;
}

.avx-auth-card {
    background: #ffffff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.04);
}

.avx-auth-header {
    text-align: center;
    padding: 36px 32px 24px;
    background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
}

.avx-auth-icon-circle {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #279ED6, #1a7ab5);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    margin-bottom: 16px;
    box-shadow: 0 6px 20px rgba(39,158,214,0.3);
}

.avx-auth-title {
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 8px;
    font-size: 22px;
}

.avx-auth-subtitle {
    color: #777;
    font-size: 14px;
    margin-bottom: 0;
}

.avx-auth-body {
    padding: 8px 32px 32px;
}

.avx-auth-option {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    border-radius: 14px;
    text-decoration: none;
    color: #333;
    background: #f8f9fa;
    border: 1px solid transparent;
    transition: all 0.25s ease;
    margin-bottom: 12px;
}

.avx-auth-option:hover {
    background: #eef7fc;
    border-color: #279ED6;
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(39,158,214,0.1);
    color: #333;
    text-decoration: none;
}

.avx-auth-option-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    flex-shrink: 0;
}

.avx-auth-option-text {
    flex: 1;
}

.avx-auth-chevron {
    color: #ccc;
    font-size: 16px;
    transition: color 0.2s;
}

.avx-auth-option:hover .avx-auth-chevron {
    color: #279ED6;
}

.avx-auth-divider {
    display: flex;
    align-items: center;
    gap: 16px;
    margin: 20px 0;
    color: #bbb;
    font-size: 13px;
    font-weight: 600;
}
.avx-auth-divider::before,
.avx-auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
}

.avx-auth-footer {
    background: #f8f9fa;
    padding: 14px 32px;
    text-align: center;
    border-top: 1px solid #eee;
}
.avx-auth-footer p {
    font-size: 12px;
    color: #999;
}
</style>
@endsection
