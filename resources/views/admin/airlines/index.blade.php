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
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
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
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.airlines.edit', $airline->airline_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.airlines.destroy', $airline->airline_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="confirmDelete(event, this.closest('form'), 'Delete airline {{ $airline->airline_name }}?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
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
