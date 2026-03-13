@extends('admin.layouts.app')

@section('title', 'Country Management')
@section('page-title', 'Countries')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-globe-americas text-primary"></i>
            <h5 class="mb-0">Country Registry</h5>
            <span class="badge bg-primary ms-1">{{ $countries->total() }} countries</span>
        </div>
        <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Country
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Country Name</th>
                        <th>Phone Code</th>
                        <th>Continent</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($countries as $country)
                    <tr>
                        <td>
                            <span style="font-family:'JetBrains Mono',monospace; font-size: 14px; font-weight: 700; background: var(--surface-2); padding: 3px 10px; border-radius: 6px; border: 1px solid var(--border);">{{ $country->country_code }}</span>
                        </td>
                        <td style="font-weight: 600;">{{ $country->country_name }}</td>
                        <td style="font-family:'JetBrains Mono',monospace; font-size: 13px; color: var(--text-secondary);">{{ $country->phone_code ?? '—' }}</td>
                        <td>
                            @if($country->continent)
                                <span class="badge bg-info">{{ $country->continent }}</span>
                            @else
                                <span style="color: var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.countries.edit', $country->country_id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.countries.destroy', $country->country_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="confirmDelete(event, this.closest('form'), 'Delete country {{ $country->country_name }}?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-globe-americas" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No countries found</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($countries->hasPages())
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            {{ $countries->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
