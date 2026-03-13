@extends('admin.layouts.app')

@section('title', 'Airport Management')
@section('page-title', 'Airports')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-geo-alt-fill text-primary"></i>
            <h5 class="mb-0">Airport Registry</h5>
            <span class="badge bg-primary ms-1">{{ $airports->total() }} airports</span>
        </div>
        <a href="{{ route('admin.airports.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Airport
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>IATA Code</th>
                        <th>Airport Name</th>
                        <th>City</th>
                        <th>Country</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($airports as $airport)
                    <tr>
                        <td>
                            <span style="font-family:'JetBrains Mono',monospace; font-size: 14px; font-weight: 700; background: var(--surface-2); padding: 3px 10px; border-radius: 6px; border: 1px solid var(--border);">{{ $airport->iata_code }}</span>
                        </td>
                        <td style="font-weight: 600;">{{ $airport->airport_name }}</td>
                        <td style="color: var(--text-secondary);">{{ $airport->city }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $airport->country->country_name ?? $airport->country_code }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.airports.edit', $airport->airport_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.airports.destroy', $airport->airport_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="confirmDelete(event, this.closest('form'), 'Delete airport {{ $airport->iata_code }}?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-geo-alt" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No airports found</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($airports->hasPages())
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            {{ $airports->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
