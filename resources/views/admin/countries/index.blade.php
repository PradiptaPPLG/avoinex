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
    <div class="card-body p-0">    <div class="p-3 border-bottom bg-light" id="bulkActions" style="display: none;">
        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center" onclick="submitBulkDelete('{{ route('admin.countries.bulk_delete') }}')" id="btnBulkDelete">
            <i class="bi bi-check-all me-1"></i> Pilih (<span id="bulkCount">0</span>) - Hapus Selected
        </button>
    </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
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
                        <td style="width: 40px;"><input type="checkbox" class="form-check-input row-checkbox" value="{{ $country->country_code }}"></td>
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
                                                        <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid var(--border); box-shadow: none;">
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.countries.edit', $country->country_id) }}">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.countries.destroy', $country->country_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event, this.closest('form'), 'Delete country {{ $country->country_name }}?')">
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






