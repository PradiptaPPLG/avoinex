@extends('admin.layouts.app')

@section('page-title', 'Edit Destinasi Populer')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Informasi Destinasi Populer</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.featured_destinations.update', $featuredDestination->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Destinasi / Judul</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $featuredDestination->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Destinasi</label>
                        @if($featuredDestination->image_path)
                            <div class="mb-2">
                                <img src="{{ asset($featuredDestination->image_path) }}" alt="{{ $featuredDestination->title }}" style="width: 200px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Bandara Asal (Origin)</label>
                            <select name="origin_iata" class="form-select @error('origin_iata') is-invalid @enderror" required>
                                <option value="">Pilih Bandara Asal</option>
                                @foreach($airports as $airport)
                                    <option value="{{ $airport->iata_code }}" {{ old('origin_iata', $featuredDestination->origin_iata) == $airport->iata_code ? 'selected' : '' }}>
                                        {{ $airport->city }} ({{ $airport->iata_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('origin_iata')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bandara Tujuan (Destination)</label>
                            <select name="destination_iata" class="form-select @error('destination_iata') is-invalid @enderror" required>
                                <option value="">Pilih Bandara Tujuan</option>
                                @foreach($airports as $airport)
                                    <option value="{{ $airport->iata_code }}" {{ old('destination_iata', $featuredDestination->destination_iata) == $airport->iata_code ? 'selected' : '' }}>
                                        {{ $airport->city }} ({{ $airport->iata_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('destination_iata')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Harga Mulai Dari (IDR)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" name="starting_price_usd" class="form-control rupiah-input @error('starting_price_usd') is-invalid @enderror" value="{{ old('starting_price_usd', $featuredDestination->starting_price_usd) }}" required>
                            </div>
                            @error('starting_price_usd')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rentang Tanggal (cth: 3-14 Mar)</label>
                            <input type="text" name="date_range" class="form-control @error('date_range') is-invalid @enderror" value="{{ old('date_range', $featuredDestination->date_range) }}" required>
                            @error('date_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Urutan Tampil (Sort Order)</label>
                            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $featuredDestination->sort_order) }}">
                            <small class="text-muted">Angka lebih kecil tampil duluan.</small>
                            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 d-flex align-items-center mt-3">
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActiveCheck" value="1" {{ old('is_active', $featuredDestination->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label ps-2" for="isActiveCheck">Tampilkan / Aktif</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('admin.featured_destinations.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
