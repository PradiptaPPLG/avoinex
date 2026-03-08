@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Total Bookings</div>
                <div class="stat-value">{{ number_format($totalBookings) }}</div>
            </div>
            <div class="stat-icon" style="background: rgba(0,102,204,0.10); color: #0066CC;">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Confirmed</div>
                <div class="stat-value" style="color: #0DAF7A;">{{ number_format($confirmedBookings) }}</div>
            </div>
            <div class="stat-icon" style="background: rgba(13,175,122,0.10); color: #0DAF7A;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Cancelled</div>
                <div class="stat-value" style="color: #EF4444;">{{ number_format($cancelledBookings) }}</div>
            </div>
            <div class="stat-icon" style="background: rgba(239,68,68,0.10); color: #EF4444;">
                <i class="bi bi-x-circle-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value" style="font-size:24px;">${{ number_format($totalRevenue, 0) }}</div>
            </div>
            <div class="stat-icon" style="background: rgba(0,194,168,0.12); color: #00C2A8;">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
    </div>
</div>

{{-- SECOND ROW --}}
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-calendar-check text-primary"></i>
                <h5 class="mb-0">Today's Flights</h5>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-5">
                <div style="font-size: 72px; font-weight: 800; color: var(--primary); line-height: 1;">
                    {{ $flightsToday }}
                </div>
                <div class="text-muted mt-2" style="font-size: 13px; font-weight: 500;">Scheduled departures today</div>
                <div class="mt-3 d-flex align-items-center gap-1" style="font-size: 12px; color: var(--success); font-weight: 600;">
                    <i class="bi bi-circle-fill" style="font-size: 7px;"></i> Live tracking active
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-lightning-charge-fill text-warning"></i>
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <a href="{{ route('admin.bookings.index') }}" class="text-decoration-none">
                            <div style="border: 1.5px solid var(--border); border-radius: 10px; padding: 18px; transition: all 0.2s; background: var(--surface-2);" onmouseover="this.style.borderColor='var(--primary)';this.style.background='var(--primary-light)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface-2)'">
                                <i class="bi bi-ticket-perforated-fill" style="font-size: 22px; color: var(--primary);"></i>
                                <div style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-top: 10px;">View Bookings</div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">Manage all reservations</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.flights.create') }}" class="text-decoration-none">
                            <div style="border: 1.5px solid var(--border); border-radius: 10px; padding: 18px; transition: all 0.2s; background: var(--surface-2);" onmouseover="this.style.borderColor='var(--success)';this.style.background='rgba(13,175,122,0.06)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface-2)'">
                                <i class="bi bi-plus-circle-fill" style="font-size: 22px; color: var(--success);"></i>
                                <div style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-top: 10px;">New Flight</div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">Create flight instance</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.schedules.create') }}" class="text-decoration-none">
                            <div style="border: 1.5px solid var(--border); border-radius: 10px; padding: 18px; transition: all 0.2s; background: var(--surface-2);" onmouseover="this.style.borderColor='var(--info)';this.style.background='rgba(59,130,246,0.06)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface-2)'">
                                <i class="bi bi-calendar-plus-fill" style="font-size: 22px; color: var(--info);"></i>
                                <div style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-top: 10px;">Add Schedule</div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">Set up flight schedule</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.aircraft.create') }}" class="text-decoration-none">
                            <div style="border: 1.5px solid var(--border); border-radius: 10px; padding: 18px; transition: all 0.2s; background: var(--surface-2);" onmouseover="this.style.borderColor='var(--warning)';this.style.background='rgba(245,158,11,0.06)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface-2)'">
                                <i class="bi bi-airplane-fill" style="font-size: 22px; color: var(--warning);"></i>
                                <div style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-top: 10px;">Add Aircraft</div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">Register new aircraft</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection