@extends('admin.layouts.app')

@section('title', 'Refund Requests')
@section('page-title', 'Refund Requests')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-arrow-counterclockwise text-warning" style="font-size: 20px;"></i>
            <h5 class="mb-0">Permintaan Refund</h5>
            @if($refundRequests->total() > 0)
                <span class="badge bg-warning text-dark">{{ $refundRequests->total() }} menunggu</span>
            @endif
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Bookings
        </a>
    </div>
    <div class="card-body p-0">
        @if(session('success'))
            <div class="alert alert-success m-3 mb-0">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger m-3 mb-0">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
            </div>
        @endif

        @forelse($refundRequests as $booking)
        <div class="border-bottom p-4">
            {{-- Header Row --}}
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Booking Code</div>
                    <div style="font-family: 'JetBrains Mono', monospace; font-weight: 700; font-size: 16px; color: var(--primary);">
                        {{ $booking->booking_code }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Penumpang</div>
                    <div style="font-weight: 600;">{{ $booking->client->first_name }} {{ $booking->client->last_name }}</div>
                    <div style="font-size: 12px; color: var(--text-muted);">{{ $booking->client->email }}</div>
                </div>
                <div class="col-md-3">
                    <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Penerbangan</div>
                    <div style="font-weight: 600;">
                        {{ $booking->flightInstance->schedule->originAirport->iata_code }} → {{ $booking->flightInstance->schedule->destinationAirport->iata_code }}
                    </div>
                    <div style="font-size: 12px; color: var(--text-muted);">
                        {{ $booking->flightInstance->flight_date->format('d M Y') }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Total Bayar</div>
                    <div style="font-weight: 700; font-size: 18px; color: var(--success);">
                        Rp {{ number_format($booking->total_price_usd, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 11px; color: var(--text-muted);">
                        {{ $booking->bookingSeats->count() }} penumpang
                    </div>
                </div>
            </div>

            {{-- Refund Reason --}}
            <div class="p-3 rounded mb-3" style="background: #FFF8E1; border: 1px solid #FFE082;">
                <div style="font-size: 12px; color: #F57F17; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                    <i class="bi bi-chat-left-quote me-1"></i> Alasan Refund
                </div>
                <div style="font-size: 14px; color: #333;">{{ $booking->refund_reason }}</div>
                <div style="font-size: 11px; color: var(--text-muted); margin-top: 6px;">
                    <i class="bi bi-clock me-1"></i> Diminta pada: {{ $booking->refund_requested_at->format('d M Y H:i') }}
                    ({{ $booking->refund_requested_at->diffForHumans() }})
                </div>
            </div>

            {{-- Action Form --}}
            <div class="row g-3">
                {{-- Approve --}}
                <div class="col-md-6">
                    @php $calc = $booking->calculateRefundAmount(); @endphp
                    <form action="{{ route('admin.bookings.refund.process', $booking->booking_id) }}" method="POST"
                        class="p-3 rounded h-100" style="background: #E8F5E9; border: 1px solid #A5D6A7;"
                        onsubmit="return confirm('Yakin ingin MENYETUJUI refund otomatis senilai Rp {{ number_format($calc['amount'], 0, ',', '.') }}?')">
                        @csrf
                        <input type="hidden" name="action" value="approve">
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0" style="color: #2E7D32;">
                                <i class="bi bi-check-circle me-1"></i> Setujui Refund
                            </h6>
                            <span class="badge" style="background: #2E7D32;">Sesuai Kebijakan</span>
                        </div>

                        <div class="mb-3 p-2 rounded" style="background: rgba(255,255,255,0.5); border: 1px dashed #A5D6A7;">
                            <div class="row g-2 text-center">
                                <div class="col-6 border-end">
                                    <div style="font-size: 11px; color: #666;">Estimasi Refund</div>
                                    <div style="font-weight: 700; color: #2E7D32;">Rp {{ number_format($calc['amount'], 0, ',', '.') }}</div>
                                </div>
                                <div class="col-6">
                                    <div style="font-size: 11px; color: #666;">Kebijakan</div>
                                    <div style="font-weight: 700; color: #2E7D32;">{{ $calc['percentage'] }}% ({{ ceil($calc['hours_remaining']) }} jam lagi)</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-size: 13px; font-weight: 600;">Catatan Admin (opsional)</label>
                            <textarea name="admin_notes" class="form-control form-control-sm" rows="2"
                                placeholder="Contoh: Refund otomatis disetujui sistem"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            <i class="bi bi-check2-all me-1"></i> Konfirmasi & Approve Refund
                        </button>
                    </form>
                </div>

                {{-- Reject --}}
                <div class="col-md-6">
                    <form action="{{ route('admin.bookings.refund.process', $booking->booking_id) }}" method="POST"
                        class="p-3 rounded h-100" style="background: #FFEBEE; border: 1px solid #EF9A9A;"
                        onsubmit="return confirm('Yakin ingin MENOLAK refund untuk {{ $booking->booking_code }}?')">
                        @csrf
                        <input type="hidden" name="action" value="reject">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0" style="color: #C62828;">
                                <i class="bi bi-x-octagon me-1"></i> Tolak Refund
                            </h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 13px; font-weight: 600;">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="admin_notes" class="form-control form-control-sm" rows="4" required
                                placeholder="Jelaskan mengapa permintaan ini ditolak. Contoh: Pembatalan dilakukan kurang dari 24 jam sebelum keberangkatan."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="bi bi-x-circle me-1"></i> Reject Refund
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="bi bi-emoji-smile" style="font-size: 48px; color: var(--border); display: block; margin-bottom: 12px;"></i>
            <span style="color: var(--text-muted); font-weight: 500; font-size: 15px;">Tidak ada permintaan refund saat ini</span>
            <div class="mt-2">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Bookings</a>
            </div>
        </div>
        @endforelse

        @if($refundRequests->hasPages())
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            {{ $refundRequests->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
