@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Bookings</h6>
                        <h2 class="mb-0">{{ $totalBookings }}</h2>
                    </div>
                    <div class="text-primary" style="font-size: 48px; opacity: 0.3;">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Confirmed</h6>
                        <h2 class="mb-0 text-success">{{ $confirmedBookings }}</h2>
                    </div>
                    <div class="text-success" style="font-size: 48px; opacity: 0.3;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Cancelled</h6>
                        <h2 class="mb-0 text-danger">{{ $cancelledBookings }}</h2>
                    </div>
                    <div class="text-danger" style="font-size: 48px; opacity: 0.3;">
                        <i class="bi bi-x-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Revenue</h6>
                        <h2 class="mb-0 text-primary">${{ number_format($totalRevenue, 0) }}</h2>
                    </div>
                    <div class="text-primary" style="font-size: 48px; opacity: 0.3;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Flights Today</h5>
            </div>
            <div class="card-body text-center py-5">
                <h1 class="display-4 text-primary">{{ $flightsToday }}</h1>
                <p class="text-muted">Scheduled flights for today</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-ticket-perforated"></i> View All Bookings
                    </a>
                    <a href="{{ route('admin.flights.create') }}" class="btn btn-outline-success">
                        <i class="bi bi-plus-circle"></i> Create New Flight
                    </a>
                    <a href="{{ route('admin.schedules.create') }}" class="btn btn-outline-info">
                        <i class="bi bi-calendar-plus"></i> Add Schedule
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
