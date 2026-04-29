@extends('layouts.app')

@section('title', 'Find Your Booking - Avoinex')

@section('content')
<div class="avx-find-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <!-- Search Card -->
                <div class="avx-find-card">
                    <div class="avx-find-header">
                        <div class="avx-find-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h2 class="avx-find-title">Retrieve Your Booking</h2>
                        <p class="avx-find-subtitle">Enter your booking code and email to view your e-ticket</p>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger mx-4 mt-3 mb-0 d-flex align-items-center" style="border-radius:12px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success mx-4 mt-3 mb-0 d-flex align-items-center" style="border-radius:12px;">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('booking.find') }}" method="POST" class="avx-find-form">
                        @csrf
                        <div class="mb-3">
                            <label for="booking_code" class="form-label fw-bold">
                                <i class="bi bi-ticket-perforated me-1"></i> Booking Code
                            </label>
                            <input type="text" class="form-control avx-find-input" id="booking_code" name="booking_code"
                                   placeholder="e.g. AVX-A1B2C3D4" value="{{ old('booking_code') }}" required
                                   style="text-transform:uppercase;">
                            @error('booking_code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope me-1"></i> Email Address
                            </label>
                            <input type="email" class="form-control avx-find-input" id="email" name="email"
                                   placeholder="The email used during booking" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn avx-find-btn w-100">
                            <i class="bi bi-search me-2"></i> Find Booking
                        </button>
                    </form>

                    <div class="avx-find-footer">
                        <p class="mb-0"><i class="bi bi-info-circle me-1"></i> Use the same email where your e-ticket was sent</p>
                    </div>
                </div>

                <!-- Results Card (shown when booking is found) -->
                @if(isset($booking))
                @php
                    $statusColor = match($booking->booking_status) {
                        'confirmed'        => ['bg' => '#d4edda', 'color' => '#155724', 'icon' => 'bi-check-circle-fill'],
                        'pending'          => ['bg' => '#fff3cd', 'color' => '#856404', 'icon' => 'bi-hourglass-split'],
                        'refund_requested' => ['bg' => '#fff3cd', 'color' => '#856404', 'icon' => 'bi-arrow-counterclockwise'],
                        'cancelled'        => ['bg' => '#f8d7da', 'color' => '#721c24', 'icon' => 'bi-x-circle-fill'],
                        default            => ['bg' => '#e2e3e5', 'color' => '#383d41', 'icon' => 'bi-question-circle'],
                    };
                    $isFlightFuture = \Carbon\Carbon::parse($booking->flightInstance->flight_date)->endOfDay()->isFuture();
                    $canCancel  = $booking->canCancel();
                    $canRefund  = $booking->canRequestRefund();
                    $foundEmail = request()->input('email', $booking->client->email);
                    $exchangeRate = config('app.usd_to_idr', 15500);
                @endphp

                <div class="avx-result-card mt-4">
                    <!-- Header -->
                    <div class="avx-result-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="avx-result-label">Booking Code</span>
                                <h3 class="mb-1 fw-800" style="letter-spacing:2px; color:#279ED6;">{{ $booking->booking_code }}</h3>
                                <small class="text-muted">Booked on {{ $booking->created_at->format('d M Y, H:i') }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge px-3 py-2 rounded-pill" style="background:{{ $statusColor['bg'] }}; color:{{ $statusColor['color'] }}; font-size:13px;">
                                    <i class="bi {{ $statusColor['icon'] }} me-1"></i>
                                    {{ ucwords(str_replace('_', ' ', $booking->booking_status)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Flight Route -->
                    <div class="avx-result-section">
                        <div class="row text-center align-items-center">
                            <div class="col-5">
                                <span class="avx-result-label">From</span>
                                <h4 class="fw-800 mb-0">{{ $booking->flightInstance->schedule->originAirport->iata_code }}</h4>
                                <small class="text-muted">{{ $booking->flightInstance->schedule->originAirport->city }}</small>
                            </div>
                            <div class="col-2">
                                <span style="font-size:26px; color:#279ED6;">✈</span>
                            </div>
                            <div class="col-5">
                                <span class="avx-result-label">To</span>
                                <h4 class="fw-800 mb-0">{{ $booking->flightInstance->schedule->destinationAirport->iata_code }}</h4>
                                <small class="text-muted">{{ $booking->flightInstance->schedule->destinationAirport->city }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Flight Details -->
                    <div class="avx-result-section">
                        <div class="row">
                            <div class="col-4">
                                <span class="avx-result-label">Flight</span>
                                <p class="fw-bold mb-0">{{ $booking->flightInstance->schedule->flight_number }}</p>
                            </div>
                            <div class="col-4">
                                <span class="avx-result-label">Date</span>
                                <p class="fw-bold mb-0">{{ $booking->flightInstance->flight_date->format('d M Y') }}</p>
                            </div>
                            <div class="col-4">
                                <span class="avx-result-label">Departure</span>
                                <p class="fw-bold mb-0">{{ date('H:i', strtotime($booking->flightInstance->schedule->departure_time_gmt)) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="avx-result-section">
                        <span class="avx-result-label">Contact</span>
                        <p class="fw-bold mb-0">{{ $booking->client->first_name }} {{ $booking->client->last_name }}</p>
                        <small class="text-muted">{{ $booking->client->email }}</small>
                    </div>

                    <!-- Passengers -->
                    <div class="avx-result-section">
                        <h6 class="fw-bold mb-3"><i class="bi bi-people me-1"></i> Passengers</h6>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0" style="font-size:14px;">
                                <thead style="background:#f0f7fc;">
                                    <tr>
                                        <th style="border:none; padding:10px 12px;">Name</th>
                                        <th style="border:none; padding:10px 12px; text-align:center;">Seat</th>
                                        <th style="border:none; padding:10px 12px; text-align:center;">Baggage</th>
                                        <th style="border:none; padding:10px 12px; text-align:right;">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->bookingSeats as $bSeat)
                                    <tr>
                                        <td style="padding:10px 12px;">{{ $bSeat->passenger_first_name }} {{ $bSeat->passenger_last_name }}</td>
                                        <td style="padding:10px 12px; text-align:center;"><strong>{{ $bSeat->seat->seat_number ?? 'N/A' }}</strong></td>
                                        <td style="padding:10px 12px; text-align:center;">{{ $bSeat->baggage_weight ?? 0 }}kg</td>
                                        <td style="padding:10px 12px; text-align:right;">Rp {{ number_format(($bSeat->price_at_booking + ($bSeat->baggage_price ?? 0)) * $exchangeRate, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="avx-result-total">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Price</span>
                            <span class="avx-result-price">Rp {{ number_format($booking->total_price_usd * $exchangeRate, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons Area -->
                    <div class="avx-result-actions">
                        @if($canRefund)
                            {{-- Booking sudah dibayar → Ajukan Refund (seperti user login) --}}
                            <div class="avx-action-info">
                                <i class="bi bi-info-circle text-primary" style="font-size:16px; flex-shrink:0;"></i>
                                <span>Pesanan Anda sudah terkonfirmasi. Jika ingin membatalkan, Anda dapat mengajukan refund di bawah ini.</span>
                            </div>
                            <button type="button" class="avx-action-btn avx-action-refund" data-bs-toggle="modal" data-bs-target="#guestRefundModal">
                                <i class="bi bi-arrow-counterclockwise me-2"></i> Ajukan Refund
                            </button>
                        @elseif($canCancel)
                            {{-- Belum bayar → Cancel langsung --}}
                            <div class="avx-action-info avx-action-warn">
                                <i class="bi bi-exclamation-triangle text-warning" style="font-size:16px; flex-shrink:0;"></i>
                                <span>Pesanan ini belum dibayar. Anda dapat membatalkannya sekarang tanpa biaya.</span>
                            </div>
                            <form action="{{ route('booking.guest.cancel', $booking->booking_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="email" value="{{ $foundEmail }}">
                                <button type="submit" class="avx-action-btn avx-action-cancel"
                                    onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    <i class="bi bi-x-circle me-2"></i> Batalkan Pesanan
                                </button>
                            </form>
                        @elseif($booking->booking_status === 'refund_requested')
                            <div class="avx-action-info avx-action-pending">
                                <i class="bi bi-hourglass-split text-warning" style="font-size:16px; flex-shrink:0;"></i>
                                <span>Permintaan refund Anda sedang diproses oleh tim kami. Estimasi <strong>1–3 hari kerja</strong>.</span>
                            </div>
                        @elseif($booking->booking_status === 'cancelled' && $booking->payment_status === 'refunded')
                            <div class="avx-action-info avx-action-success">
                                <i class="bi bi-check-circle-fill text-success" style="font-size:16px; flex-shrink:0;"></i>
                                <span>
                                    Refund sebesar <strong>Rp {{ number_format(($booking->refund_amount_usd ?? 0) * $exchangeRate, 0, ',', '.') }}</strong>
                                    telah diproses. Silakan cek email Anda.
                                </span>
                            </div>
                        @else
                            <div class="avx-action-info">
                                <i class="bi bi-calendar-x text-muted" style="font-size:16px; flex-shrink:0;"></i>
                                <span>Tidak ada aksi yang tersedia untuk pesanan ini saat ini.</span>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Back Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('landing') }}" class="text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- GUEST REFUND MODAL — sama seperti user login --}}
{{-- ============================================================ --}}
@if(isset($booking) && $booking->canRequestRefund())
<div class="modal fade" id="guestRefundModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px; overflow:hidden; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <form action="{{ route('booking.guest.cancel', $booking->booking_id) }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $foundEmail ?? $booking->client->email }}">

                <!-- Modal Header -->
                <div class="modal-header" style="background:linear-gradient(135deg,#fff8e1,#ffeaa7); border-bottom:none; padding:24px 28px 16px;">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" style="color:#856404;">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Ajukan Permintaan Refund
                        </h5>
                        <p class="mb-0 small text-muted">Booking: <strong class="text-dark">{{ $booking->booking_code }}</strong></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="padding:20px 28px;">

                    <!-- Refund Policy Info -->
                    <div class="mb-3 p-3" style="background:#eef7fc; border:1px solid #b8dff0; border-radius:12px;">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="bi bi-shield-check text-primary mt-1" style="font-size:18px;"></i>
                            <div>
                                <p class="fw-bold mb-1" style="font-size:13px; color:#1a7ab5;">Kebijakan Refund Avoinex</p>
                                <ul class="mb-0 small text-muted ps-3">
                                    <li>Dibatalkan &gt; 24 jam sebelum penerbangan: <strong>Refund 75%</strong></li>
                                    <li>Dibatalkan &lt; 24 jam sebelum penerbangan: <strong>Refund 50%</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Total Info -->
                    <div class="d-flex justify-content-between align-items-center p-3 mb-3" style="background:#f8f9fa; border-radius:12px;">
                        <span class="text-muted small fw-bold">Total yang Anda bayar</span>
                        <span class="fw-bold" style="color:#279ED6;">
                            Rp {{ number_format($booking->total_price_usd * config('app.usd_to_idr', 15500), 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Alasan Refund -->
                    <div class="mb-3">
                        <label for="guestRefundReason" class="form-label fw-bold" style="font-size:14px;">
                            Alasan Refund <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" name="refund_reason" id="guestRefundReason"
                            rows="4" required
                            style="border-radius:12px; border:1.5px solid #e0e0e0; font-size:14px; resize:none; padding:12px;"
                            placeholder="Contoh: Perubahan jadwal mendadak, keadaan darurat keluarga, dll."></textarea>
                        <div class="form-text small mt-1">
                            <i class="bi bi-info-circle me-1"></i> Tim kami akan meninjau dalam <strong>1–3 hari kerja</strong>.
                        </div>
                    </div>

                    <!-- Warning -->
                    <div class="alert alert-warning d-flex align-items-start gap-2 mb-0" style="border-radius:12px; font-size:13px;">
                        <i class="bi bi-exclamation-triangle-fill mt-1" style="flex-shrink:0;"></i>
                        <span>Setelah permintaan dikirim, status pesanan berubah menjadi <strong>Pending Refund</strong> dan tidak dapat dibatalkan.</span>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer" style="border-top:1px solid #f0f0f0; padding:16px 28px;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px; padding:10px 20px; font-weight:600;">
                        Batal
                    </button>
                    <button type="submit" class="btn" style="background:linear-gradient(135deg,#f0a500,#e08c00); color:#fff; border-radius:10px; padding:10px 24px; font-weight:700; border:none; box-shadow:0 4px 14px rgba(240,165,0,0.3);">
                        <i class="bi bi-send me-2"></i> Kirim Permintaan Refund
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
.avx-find-bg {
    min-height: 90vh;
    background: linear-gradient(135deg, #f0f7fc 0%, #e8f4fd 50%, #f5f5f5 100%);
    padding: 60px 0;
}
.avx-find-card { background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.08); }
.avx-find-header { text-align: center; padding: 36px 32px 16px; background: linear-gradient(180deg, #f8fbff 0%, #fff 100%); }
.avx-find-icon {
    width: 64px; height: 64px;
    background: linear-gradient(135deg, #279ED6, #1a7ab5);
    border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
    color: #fff; font-size: 28px; margin-bottom: 16px; box-shadow: 0 6px 20px rgba(39,158,214,0.3);
}
.avx-find-title { font-weight: 800; color: #1a1a2e; font-size: 22px; margin-bottom: 8px; }
.avx-find-subtitle { color: #777; font-size: 14px; margin-bottom: 0; }
.avx-find-form { padding: 24px 32px 32px; }
.avx-find-input { border-radius: 12px; padding: 12px 16px; border: 1.5px solid #e0e0e0; font-size: 15px; transition: border-color 0.2s; }
.avx-find-input:focus { border-color: #279ED6; box-shadow: 0 0 0 3px rgba(39,158,214,0.12); }
.avx-find-btn {
    background: linear-gradient(135deg, #279ED6, #1a7ab5);
    color: #fff; border: none; border-radius: 14px;
    padding: 14px; font-size: 16px; font-weight: 700; transition: all 0.25s;
}
.avx-find-btn:hover { background: linear-gradient(135deg, #1a7ab5, #15668e); color: #fff; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(39,158,214,0.3); }
.avx-find-footer { background: #f8f9fa; padding: 14px 32px; text-align: center; border-top: 1px solid #eee; }
.avx-find-footer p { font-size: 12px; color: #999; margin:0; }

/* Result Card */
.avx-result-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.08); }
.avx-result-header { padding: 24px 28px; border-bottom: 1px dashed #e0e0e0; }
.avx-result-label { font-size: 11px; color: #999; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 2px; }
.avx-result-section { padding: 20px 28px; border-bottom: 1px solid #f0f0f0; }
.avx-result-total { padding: 20px 28px; background: #eef7fc; }
.avx-result-price { font-size: 22px; font-weight: 800; color: #279ED6; }

/* Action Area */
.avx-result-actions { padding: 20px 28px; display: flex; flex-direction: column; gap: 12px; }
.avx-action-info { background: #f8f9fa; border-radius: 12px; padding: 12px 14px; font-size: 13px; color: #555; display: flex; align-items: flex-start; gap: 8px; }
.avx-action-info.avx-action-warn  { background: #fff8e1; }
.avx-action-info.avx-action-pending { background: #fff3cd; }
.avx-action-info.avx-action-success { background: #d4edda; }
.avx-action-btn { display: block; width: 100%; padding: 14px; border: none; border-radius: 14px; font-size: 15px; font-weight: 700; cursor: pointer; text-align: center; transition: all 0.25s; }
.avx-action-refund { background: linear-gradient(135deg, #f0a500, #e08c00); color: #fff; }
.avx-action-refund:hover { opacity: 0.9; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(240,165,0,0.3); }
.avx-action-cancel { background: linear-gradient(135deg, #dc3545, #b02a37); color: #fff; }
.avx-action-cancel:hover { opacity: 0.9; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(220,53,69,0.3); }
</style>
@endsection
