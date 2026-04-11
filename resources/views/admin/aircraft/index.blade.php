@extends('admin.layouts.app')

@section('title', 'Aircraft Management')
@section('page-title', 'Aircraft Management')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-airplane-fill text-primary"></i>
            <h5 class="mb-0">Fleet Registry</h5>
            <span class="badge bg-primary ms-1">{{ $aircraft->total() }} aircraft</span>
        </div>
        <a href="{{ route('admin.aircraft.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Register Aircraft
        </a>
    </div>
    <div class="card-body p-0">    <div class="p-3 border-bottom bg-light" id="bulkActions" style="display: none;">
        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center" onclick="submitBulkDelete('{{ route('admin.aircraft.bulk_delete') }}')" id="btnBulkDelete">
            <i class="bi bi-check-all me-1"></i> Pilih (<span id="bulkCount">0</span>) - Hapus Selected
        </button>
    </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                        <th>Registration</th>
                        <th>Model</th>
                        <th>Manufacturer</th>
                        <th>Layout</th>
                        <th>Total Seats</th>
                        <th>Business</th>
                        <th>Preferred Zone</th>
                        <th>Economy</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aircraft as $item)
                    <tr>
                        <td style="width: 40px;"><input type="checkbox" class="form-check-input row-checkbox" value="{{ $item->aircraft_id }}"></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 34px; height: 34px; background: var(--primary-light); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 14px;">
                                    <i class="bi bi-airplane"></i>
                                </div>
                                <strong style="font-family: 'JetBrains Mono', monospace; font-size: 13px; color: var(--primary);">{{ $item->registration_number }}</strong>
                            </div>
                        </td>
                        <td style="font-weight: 600;">{{ $item->aircraft_model }}</td>
                        <td style="color: var(--text-secondary);">{{ $item->manufacturer->name ?? '—' }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                <i class="bi bi-grid-3x3 me-1" style="font-size: 9px;"></i>
                                {{ $item->seat_columns ?? 6 }} × {{ $item->seat_rows ?? 30 }}
                            </span>
                        </td>
                        <td>
                            <span style="font-weight: 700; font-size: 15px;">{{ $item->total_seats }}</span>
                        </td>
                        <td>
                            @if(($item->business_rows ?? 0) > 0)
                                <span class="badge bg-warning">{{ ($item->seat_columns ?? 6) * ($item->business_rows ?? 0) }} seats</span>
                            @else
                                <span style="color: var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($item->preferred_zone_enabled)
                                <span class="badge bg-info">Rows {{ $item->preferred_zone_start_row }}–{{ $item->preferred_zone_end_row }}</span>
                            @else
                                <span style="color: var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td style="font-weight: 600;">{{ $item->economy_seats ?? '—' }}</td>
                        <td>
                                                        <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid var(--border); box-shadow: none;">
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.aircraft.edit', $item->aircraft_id) }}">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.aircraft.destroy', $item->aircraft_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event, this.closest('form'), 'Delete aircraft {{ $item->registration_number }}?')">
                                                <i class="bi bi-trash me-2 text-danger"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
<td colspan="9" class="text-center py-5">
                            <i class="bi bi-airplane" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No aircraft registered</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($aircraft->hasPages())
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            {{ $aircraft->links() }}
        </div>
        @endif
    </div>
</div>

@endsection





