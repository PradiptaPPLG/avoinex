@extends('admin.layouts.app')

@section('page-title', 'Destinasi Populer')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Destinasi Populer</h5>
        <a href="{{ route('admin.featured_destinations.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Destinasi
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Gambar</th>
                        <th>Destinasi</th>
                        <th>Trayek</th>
                        <th>Harga Mulai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($destinations as $dest)
                    <tr>
                        <td>{{ $dest->sort_order }}</td>
                        <td>
                            @if($dest->image_path)
                            <img src="{{ asset($dest->image_path) }}" alt="{{ $dest->title }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 6px;">
                            @else
                            <div style="width: 80px; height: 50px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">No Image</div>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $dest->title }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $dest->origin_iata }}</span>
                            <i class="bi bi-arrow-right mx-1 text-muted"></i>
                            <span class="badge bg-primary">{{ $dest->destination_iata }}</span>
                            <div class="small text-muted mt-1">{{ $dest->date_range }}</div>
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($dest->starting_price_usd * config('app.usd_to_idr', 15000), 0, ',', '.') }}</td>
                        <td>
                            @if($dest->is_active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.featured_destinations.edit', $dest->id) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.featured_destinations.destroy', $dest->id) }}" method="POST" class="d-inline" onsubmit="confirmDelete(event, this, 'Yakin ingin menghapus destinasi ini?')">
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
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada destinasi populer yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
