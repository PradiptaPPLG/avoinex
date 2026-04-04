@extends('layouts.app')

@section('title', 'My Profile - Avoinex')

@section('content')
<div class="avx-profile-page">
    <div class="container py-4">

        {{-- Success / Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show avx-alert-toast" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show avx-alert-toast" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- LEFT: Profile Card --}}
            <div class="col-lg-4">
                <div class="avx-profile-card">
                    <div class="avx-profile-cover"></div>
                    <div class="avx-profile-avatar-wrapper">
                        <div class="avx-profile-avatar">
                            <span>{{ strtoupper(substr($client->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($client->last_name ?? 'X', 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="avx-profile-info">
                        <h4 class="avx-profile-name">{{ $client->first_name }} {{ $client->last_name }}</h4>
                        <p class="avx-profile-email"><i class="bi bi-envelope me-1"></i>{{ $client->email }}</p>
                        @if($client->phone)
                            <p class="avx-profile-phone"><i class="bi bi-phone me-1"></i>{{ $client->phone }}</p>
                        @endif
                        <div class="avx-profile-member-since">
                            <i class="bi bi-calendar3 me-1"></i>Member sejak {{ $client->created_at ? $client->created_at->format('M Y') : 'N/A' }}
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="avx-profile-stats">
                        <div class="avx-stat-item">
                            <div class="avx-stat-number">{{ $totalBookings }}</div>
                            <div class="avx-stat-label">Total Booking</div>
                        </div>
                        <div class="avx-stat-item">
                            <div class="avx-stat-number" style="color: #0DAF7A;">{{ $confirmedBookings }}</div>
                            <div class="avx-stat-label">Confirmed</div>
                        </div>
                        <div class="avx-stat-item">
                            <div class="avx-stat-number" style="color: #279ED6;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                            <div class="avx-stat-label">Total Pengeluaran</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Edit Forms --}}
            <div class="col-lg-8">
                {{-- Edit Profile --}}
                <div class="avx-form-card">
                    <div class="avx-form-card-header">
                        <h5><i class="bi bi-person-fill me-2"></i>Edit Profil</h5>
                    </div>
                    <div class="avx-form-card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="avx-form-label">Nama Depan</label>
                                    <input type="text" name="first_name" class="avx-form-control" value="{{ old('first_name', $client->first_name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="avx-form-label">Nama Belakang</label>
                                    <input type="text" name="last_name" class="avx-form-control" value="{{ old('last_name', $client->last_name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="avx-form-label">Email</label>
                                    <input type="email" class="avx-form-control" value="{{ $client->email }}" disabled>
                                    <small class="text-muted">Email tidak bisa diubah</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="avx-form-label">Nomor Telepon</label>
                                    <input type="text" name="phone" class="avx-form-control" value="{{ old('phone', $client->phone) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="avx-form-label">Tanggal Lahir</label>
                                    <input type="date" name="date_of_birth" class="avx-form-control" value="{{ old('date_of_birth', $client->date_of_birth) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="avx-form-label">Passport</label>
                                    <input type="text" class="avx-form-control" value="{{ $client->passport ?? '-' }}" disabled>
                                    <small class="text-muted">Hubungi support untuk mengubah passport</small>
                                </div>
                            </div>

                            <button type="submit" class="avx-btn-save mt-4">
                                <i class="bi bi-check2-circle me-2"></i>Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Change Password --}}
                <div class="avx-form-card mt-4">
                    <div class="avx-form-card-header">
                        <h5><i class="bi bi-shield-lock-fill me-2"></i>Ubah Password</h5>
                    </div>
                    <div class="avx-form-card-body">
                        @if($client->password_hash)
                        <form action="{{ route('profile.change-password') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="avx-form-label">Password Saat Ini</label>
                                    <input type="password" name="current_password" class="avx-form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="avx-form-label">Password Baru</label>
                                    <input type="password" name="new_password" class="avx-form-control" required minlength="8">
                                </div>
                                <div class="col-md-6">
                                    <label class="avx-form-label">Konfirmasi Password Baru</label>
                                    <input type="password" name="new_password_confirmation" class="avx-form-control" required minlength="8">
                                </div>
                            </div>
                            <button type="submit" class="avx-btn-save mt-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-key me-2"></i>Ubah Password
                            </button>
                        </form>
                        @else
                        <div class="text-center py-4">
                            <i class="bi bi-google text-primary" style="font-size: 2rem;"></i>
                            <p class="mt-2 text-muted">Akun Anda terdaftar melalui Google SSO. Anda tidak memiliki password lokal.</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Recent Bookings --}}
                @if($recentBookings->count() > 0)
                <div class="avx-form-card mt-4">
                    <div class="avx-form-card-header">
                        <h5><i class="bi bi-ticket-perforated me-2"></i>Booking Terakhir</h5>
                        <a href="{{ route('booking.index') }}" class="avx-view-all">Lihat Semua →</a>
                    </div>
                    <div class="avx-form-card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Rute</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                    <tr>
                                        <td><strong>{{ $booking->booking_code }}</strong></td>
                                        <td>
                                            {{ $booking->flightInstance->schedule->originAirport->iata_code ?? '?' }}
                                            → {{ $booking->flightInstance->schedule->destinationAirport->iata_code ?? '?' }}
                                        </td>
                                        <td>{{ $booking->created_at->format('d M Y') }}</td>
                                        <td>Rp {{ number_format($booking->total_price_usd, 0, ',', '.') }}</td>
                                        <td>
                                            @if($booking->booking_status === 'confirmed')
                                                <span class="badge bg-success">Confirmed</span>
                                            @elseif($booking->booking_status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($booking->booking_status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avx-profile-page {
    min-height: calc(100vh - 72px);
    background: linear-gradient(180deg, #f0f7ff 0%, #F8F9FA 50%);
}

/* Profile Card */
.avx-profile-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    border: 1px solid #e8eef5;
}
.avx-profile-cover {
    height: 120px;
    background: linear-gradient(135deg, #279ED6 0%, #3A86FF 50%, #8338EC 100%);
    position: relative;
}
.avx-profile-cover::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 40px;
    background: linear-gradient(to top, rgba(255,255,255,0.3), transparent);
}
.avx-profile-avatar-wrapper {
    display: flex;
    justify-content: center;
    margin-top: -45px;
    position: relative;
    z-index: 2;
}
.avx-profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, #279ED6, #8338EC);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid #fff;
    box-shadow: 0 4px 16px rgba(39,158,214,0.3);
}
.avx-profile-avatar span {
    color: #fff;
    font-size: 28px;
    font-weight: 800;
    letter-spacing: 2px;
}
.avx-profile-info {
    text-align: center;
    padding: 16px 20px 0;
}
.avx-profile-name {
    font-weight: 700;
    font-size: 20px;
    margin-bottom: 4px;
}
.avx-profile-email, .avx-profile-phone {
    color: #666;
    font-size: 13px;
    margin-bottom: 4px;
}
.avx-profile-member-since {
    font-size: 12px;
    color: #999;
    margin-top: 8px;
    padding: 6px 12px;
    background: #f8f9fa;
    border-radius: 20px;
    display: inline-block;
}

/* Stats */
.avx-profile-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    border-top: 1px solid #f0f0f0;
    margin-top: 20px;
}
.avx-stat-item {
    text-align: center;
    padding: 16px 8px;
    border-right: 1px solid #f0f0f0;
}
.avx-stat-item:last-child { border-right: none; }
.avx-stat-number {
    font-size: 18px;
    font-weight: 800;
    color: #333;
    line-height: 1.2;
}
.avx-stat-label {
    font-size: 11px;
    color: #999;
    font-weight: 500;
    margin-top: 4px;
}

/* Form Cards */
.avx-form-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    border: 1px solid #e8eef5;
}
.avx-form-card-header {
    padding: 18px 24px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.avx-form-card-header h5 {
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    color: #333;
}
.avx-form-card-body { padding: 24px; }

.avx-form-label {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: #555;
    margin-bottom: 6px;
    letter-spacing: 0.02em;
}
.avx-form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #dde5f0;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s;
    background: #fff;
    font-family: 'Poppins', sans-serif;
}
.avx-form-control:focus {
    border-color: #279ED6;
    box-shadow: 0 0 0 3px rgba(39,158,214,0.1);
    outline: none;
}
.avx-form-control:disabled {
    background: #f8f9fa;
    color: #888;
}
.avx-btn-save {
    padding: 12px 28px;
    background: linear-gradient(135deg, #279ED6 0%, #1a7bb5 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 14px rgba(39,158,214,0.3);
}
.avx-btn-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(39,158,214,0.4);
}
.avx-view-all {
    font-size: 13px;
    color: #279ED6;
    font-weight: 600;
    text-decoration: none;
}
.avx-view-all:hover { text-decoration: underline; }

/* Alert toast */
.avx-alert-toast { border-radius: 12px; font-size: 14px; }

/* Table */
.avx-form-card .table { font-size: 13px; }
.avx-form-card .table thead th {
    background: #f8fbfe;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #888;
    border-bottom: 1px solid #f0f0f0;
    padding: 12px 16px;
}
.avx-form-card .table tbody td {
    padding: 12px 16px;
    border-bottom: 1px solid #f5f5f5;
    vertical-align: middle;
}

@media (max-width: 768px) {
    .avx-profile-stats { grid-template-columns: 1fr; }
    .avx-stat-item { border-right: none; border-bottom: 1px solid #f0f0f0; }
    .avx-stat-item:last-child { border-bottom: none; }
}
</style>
@endpush
@endsection
