@extends('admin.layouts.app')

@section('title', 'Airline Management')
@section('page-title', 'Airlines')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-briefcase-fill text-primary"></i>
            <h5 class="mb-0">Airline Registry</h5>
            <span class="badge bg-primary ms-1">{{ $airlines->total() }} airlines</span>
        </div>
        <a href="{{ route('admin.airlines.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Airline
        </a>
    </div>
    <div class="card-body p-0">    <div class="p-3 border-bottom bg-light" id="bulkActions" style="display: none;">
        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center" onclick="submitBulkDelete('{{ route('admin.airlines.bulk_delete') }}')" id="btnBulkDelete">
            <i class="bi bi-check-all me-1"></i> Pilih (<span id="bulkCount">0</span>) - Hapus Selected
        </button>
    </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                        <th>Code</th>
                        <th>Airline Name</th>
                        <th>Country</th>
                        <th>Website</th>
                        <th>Phone</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($airlines as $airline)
                    <tr>
                        <td style="width: 40px;"><input type="checkbox" class="form-check-input row-checkbox" value="{{ $airline->airline_code }}"></td>
                        <td>
                            <span style="font-family:'JetBrains Mono',monospace; font-size: 14px; font-weight: 700; background: var(--surface-2); padding: 3px 10px; border-radius: 6px; border: 1px solid var(--border);">{{ $airline->airline_code }}</span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 34px; height: 34px; background: var(--primary-light); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 14px;">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <strong>{{ $airline->airline_name }}</strong>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $airline->country->country_name ?? $airline->country_code }}</span>
                        </td>
                        <td>
                            @if($airline->website)
                                <a href="{{ $airline->website }}" target="_blank" style="font-size: 12px; color: var(--primary);">{{ Str::limit($airline->website, 30) }}</a>
                            @else
                                <span style="color: var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-size: 12px; color: var(--text-secondary);">{{ $airline->contact_phone ?? '—' }}</td>
                        <td>
                                                        <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid var(--border); box-shadow: none;">
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.airlines.edit', $airline->airline_id) }}">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.airlines.destroy', $airline->airline_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event, this.closest('form'), 'Delete airline {{ $airline->airline_name }}?')">
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
<td colspan="6" class="text-center py-5">
                            <i class="bi bi-briefcase" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No airlines found</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($airlines->hasPages())
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            {{ $airlines->links() }}
        </div>
        @endif
    </div>
</div>

@endsection






