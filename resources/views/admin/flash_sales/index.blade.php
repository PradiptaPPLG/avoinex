@extends('admin.layouts.app')

@section('page-title', 'Flash Sales')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Manage Flash Sales</h4>
    <a href="{{ route('admin.flash_sales.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-2"></i> Create Flash Sale
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="px-4 py-3">Flight & Route</th>
                        <th class="py-3">Discount</th>
                        <th class="py-3">Period</th>
                        <th class="py-3">Seats</th>
                        <th class="py-3 text-center">Priority</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flashSales as $sale)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold">{{ $sale->flightInstance->flightInstanceCode() }}</div>
                                <small class="text-muted">
                                    {{ $sale->flightInstance->schedule->originAirport->iata_code }} &rarr; {{ $sale->flightInstance->schedule->destinationAirport->iata_code }} 
                                    ({{ $sale->flightInstance->flight_date->format('d M y') }})
                                </small>
                            </td>
                            <td class="py-3 fw-semibold text-primary">
                                @if($sale->discount_type == 'percentage')
                                    {{ $sale->discount_value }}% OFF
                                @else
                                    Rp {{ number_format($sale->discount_value, 0, ',', '.') }} OFF
                                @endif
                            </td>
                            <td class="py-3">
                                <div class="small"><i class="bi bi-clock me-1"></i> {{ $sale->start_time->format('d M H:i') }}</div>
                                <div class="small text-muted"><i class="bi bi-chevron-right me-1"></i> {{ $sale->end_time->format('d M H:i') }}</div>
                            </td>
                            <td class="py-3">
                                <div>{{ $sale->seats_sold }} / {{ $sale->max_seats }}</div>
                                <div class="progress mt-1" style="height: 4px; width: 80px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $sale->max_seats > 0 ? ($sale->seats_sold / $sale->max_seats) * 100 : 0 }}%"></div>
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge bg-secondary rounded-pill px-3">{{ $sale->priority }}</span>
                            </td>
                            <td class="py-3 text-center">
                                @if($sale->is_active && $sale->end_time > now())
                                    <span class="badge bg-success">Active</span>
                                @elseif(!$sale->is_active)
                                    <span class="badge bg-secondary">Inactive</span>
                                @else
                                    <span class="badge bg-danger">Expired</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.flash_sales.edit', $sale->id) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.flash_sales.destroy', $sale->id) }}" method="POST" class="d-inline" onsubmit="confirmDelete(event, this, 'Are you sure you want to delete this flash sale? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i>
                                No flash sales found. Start by creating a new one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($flashSales->hasPages())
        <div class="card-footer bg-white border-top-0 pt-3 pb-3 px-4">
            {{ $flashSales->links() }}
        </div>
    @endif
</div>
@endsection
