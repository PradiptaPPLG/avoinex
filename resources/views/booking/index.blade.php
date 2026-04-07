@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-ticket-perforated"></i> My Bookings</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($bookings->isEmpty())
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> You have no bookings yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Booking Code</th>
                                <th>Booking Date</th>
                                <th>Flight Number</th>
                                <th>Route</th>
                                <th>Flight Date</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td><strong>{{ $booking->booking_code }}</strong></td>
                                <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $booking->flightInstance->schedule->flight_number }}</td>
                                <td>
                                    {{ $booking->flightInstance->schedule->originAirport->city }} ({{ $booking->flightInstance->schedule->originAirport->iata_code }})
                                    →
                                    {{ $booking->flightInstance->schedule->destinationAirport->city }} ({{ $booking->flightInstance->schedule->destinationAirport->iata_code }})
                                </td>
                                <td>{{ $booking->flightInstance->flight_date->format('d M Y') }}</td>
                                <td>
                                    <div>Rp {{ number_format($booking->total_price_usd, 0, ',', '.') }}</div>
                                    @if($booking->bookingSeats->sum('baggage_weight') > 0)
                                        <div class="small text-muted"><i class="bi bi-suitcase"></i> Includes Baggage</div>
                                    @endif
                                </td>
                                <td>
                                    {{-- Dynamic status badges --}}
                                    @if($booking->booking_status === 'confirmed')
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Confirmed</span>
                                    @elseif($booking->booking_status === 'refund_requested')
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Refund Pending</span>
                                    @elseif($booking->booking_status === 'cancelled' && $booking->payment_status === 'refunded')
                                        <span class="badge bg-info"><i class="bi bi-arrow-counterclockwise me-1"></i>Refunded</span>
                                        @if($booking->refund_amount_usd)
                                            <div class="small text-success mt-1">
                                                <i class="bi bi-cash-coin"></i> Rp {{ number_format($booking->refund_amount_usd, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    @elseif($booking->booking_status === 'cancelled')
                                        <span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i>Cancelled</span>
                                    @elseif($booking->payment_status === 'refund_rejected')
                                        <span class="badge bg-danger"><i class="bi bi-x-octagon me-1"></i>Refund Rejected</span>
                                        @if($booking->refund_admin_notes)
                                            <div class="small text-muted mt-1" title="{{ $booking->refund_admin_notes }}">
                                                <i class="bi bi-chat-left-text"></i> {{ Str::limit($booking->refund_admin_notes, 30) }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="badge bg-warning"><i class="bi bi-clock me-1"></i>{{ ucfirst($booking->booking_status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-gear-fill me-1"></i> Atur
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            {{-- View Detail --}}
                                            <li>
                                                <a class="dropdown-item" href="{{ route('booking.confirmation', $booking->booking_id) }}">
                                                    <i class="bi bi-eye me-2"></i> Lihat Detail
                                                </a>
                                            </li>

                                            {{-- E-Ticket (only confirmed) --}}
                                            @if($booking->booking_status === 'confirmed')
                                                <li>
                                                    <a class="dropdown-item text-success" href="{{ route('booking.ticket', $booking->booking_id) }}" target="_blank">
                                                        <i class="bi bi-file-earmark-pdf me-2"></i> Download E-Ticket
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Refund Request --}}
                                            @if($booking->canRequestRefund())
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-warning"
                                                        data-bs-toggle="modal" data-bs-target="#refundModal{{ $booking->booking_id }}">
                                                        <i class="bi bi-arrow-counterclockwise me-2"></i> Ajukan Refund
                                                    </button>
                                                </li>
                                            @endif

                                            {{-- Cancel (only for UNPAID bookings) --}}
                                            @if($booking->canCancel())
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('booking.cancel', $booking->booking_id) }}" method="POST" id="cancelForm{{ $booking->booking_id }}" class="d-none">
                                                        @csrf
                                                    </form>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0)" 
                                                       onclick="if(confirm('Yakin ingin membatalkan booking ini?')) document.getElementById('cancelForm{{ $booking->booking_id }}').submit();">
                                                        <i class="bi bi-x-circle me-2"></i> Batalkan Pesanan
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Refund Status Indicator inside dropdown --}}
                                            @if($booking->booking_status === 'refund_requested')
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <span class="dropdown-item-text small text-muted">
                                                        <i class="bi bi-clock-history me-2"></i> Refund sedang diproses...
                                                    </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Refund Request Modals --}}
@foreach($bookings as $booking)
    @if($booking->canRequestRefund())
    <div class="modal fade" id="refundModal{{ $booking->booking_id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('booking.refund.request', $booking->booking_id) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title"><i class="bi bi-arrow-counterclockwise me-2"></i>Permintaan Refund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Booking:</strong> {{ $booking->booking_code }}<br>
                            <strong>Total Bayar:</strong> Rp {{ number_format($booking->total_price_usd, 0, ',', '.') }}
                        </div>

                        <div class="alert alert-light border mb-3">
                            <small>
                                <i class="bi bi-exclamation-triangle text-warning me-1"></i>
                                Permintaan refund akan ditinjau oleh tim kami dalam <strong>1–3 hari kerja</strong>.
                                Jumlah refund yang dikembalikan akan ditentukan berdasarkan kebijakan pembatalan yang berlaku.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="refund_reason_{{ $booking->booking_id }}" class="form-label fw-bold">
                                Alasan Refund <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" name="refund_reason"
                                id="refund_reason_{{ $booking->booking_id }}"
                                rows="4" required
                                placeholder="Contoh: Perubahan jadwal perjalanan, keadaan darurat, dll."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-send me-1"></i> Kirim Permintaan Refund
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection
