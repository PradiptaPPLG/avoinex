@extends('admin.layouts.app')

@section('title', 'Manufacturer Management')
@section('page-title', 'Aircraft Manufacturers')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-building text-primary"></i>
            <h5 class="mb-0">Manufacturer Registry</h5>
            <span class="badge bg-primary ms-1">{{ $manufacturers->total() }} manufacturers</span>
        </div>
        <a href="{{ route('admin.manufacturers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Manufacturer
        </a>
    </div>
    <div class="card-body p-0">    <div class="p-3 border-bottom bg-light" id="bulkActions" style="display: none;">
        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center" onclick="submitBulkDelete('{{ route('admin.manufacturers.bulk_delete') }}')" id="btnBulkDelete">
            <i class="bi bi-check-all me-1"></i> Pilih (<span id="bulkCount">0</span>) - Hapus Selected
        </button>
    </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Founded Year</th>
                        <th>Aircraft Count</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($manufacturers as $mfr)    
                    <tr>
                        <td style="width: 40px;"><input type="checkbox" class="form-check-input row-checkbox" value="{{ $mfr->manufacturer_id }}"></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 34px; height: 34px; background: var(--primary-light); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 14px;">
                                    <i class="bi bi-building"></i>
                                </div>
                                <strong>{{ $mfr->name }}</strong>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $mfr->country->country_name ?? $mfr->country_code }}</span>
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-size: 13px;">{{ $mfr->founded_year ?? '—' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $mfr->aircrafts->count() }} models</span>
                        </td>
                        <td>
                                                        <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid var(--border); box-shadow: none;">
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.manufacturers.edit', $mfr->aircraft_manufacturer_id) }}">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.manufacturers.destroy', $mfr->aircraft_manufacturer_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event, this.closest('form'), 'Delete manufacturer {{ $mfr->name }}?')">
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
<td colspan="5" class="text-center py-5">
                            <i class="bi bi-building" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No manufacturers found</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($manufacturers->hasPages())
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            {{ $manufacturers->links() }}
        </div>
        @endif
    </div>
</div>

@endsection






