@extends('layouts.app')

@section('title', 'Reset Password - Avoinex')

@section('content')
<div class="avx-forgot-page">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="avx-forgot-card">
                    <div class="avx-forgot-header">
                        <div class="avx-forgot-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="bi bi-key"></i>
                        </div>
                        <h3>Reset Password</h3>
                        <p>Masukkan kode verifikasi dan password baru Anda.</p>
                    </div>

                    {{-- Show the code for simulation --}}
                    @if(session('reset_code_sent'))
                        <div class="alert alert-info" style="border-radius: 12px; font-size: 14px; text-align: center; background: linear-gradient(135deg, #e8f4fd, #f0f4ff); border: 1px solid #b8daff;">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Simulasi:</strong> Kode verifikasi telah dikirim ke email <strong>{{ session('reset_email') }}</strong><br>
                            <div style="font-size: 32px; font-weight: 800; color: #279ED6; margin-top: 8px; letter-spacing: 8px; font-family: 'Courier New', monospace;">
                                {{ session('reset_code_sent') }}
                            </div>
                            <small class="text-muted">Kode berlaku 15 menit</small>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger" style="border-radius: 10px; font-size: 14px;">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('password.reset.process') }}" method="POST">
                        @csrf
                        <div class="avx-forgot-form-group">
                            <label class="avx-forgot-label">Kode Verifikasi (6 digit)</label>
                            <div class="avx-forgot-input-wrap">
                                <i class="bi bi-shield-check"></i>
                                <input type="text" name="code" placeholder="000000" required maxlength="6"
                                       class="avx-forgot-input" style="letter-spacing: 8px; font-size: 20px; font-weight: 700; text-align: center;">
                            </div>
                        </div>

                        <div class="avx-forgot-form-group">
                            <label class="avx-forgot-label">Password Baru</label>
                            <div class="avx-forgot-input-wrap">
                                <i class="bi bi-lock"></i>
                                <input type="password" name="password" placeholder="Min. 8 karakter" required minlength="8" class="avx-forgot-input">
                            </div>
                        </div>

                        <div class="avx-forgot-form-group">
                            <label class="avx-forgot-label">Konfirmasi Password Baru</label>
                            <div class="avx-forgot-input-wrap">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru" required minlength="8" class="avx-forgot-input">
                            </div>
                        </div>

                        <button type="submit" class="avx-forgot-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 14px rgba(102,126,234,0.3);">
                            <i class="bi bi-check-circle me-2"></i>Reset Password
                        </button>
                    </form>

                    <div class="avx-forgot-footer">
                        <a href="{{ route('password.forgot') }}" class="avx-forgot-back">
                            <i class="bi bi-arrow-left me-1"></i> Kirim ulang kode
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avx-forgot-page {
    min-height: calc(100vh - 72px);
    background: linear-gradient(180deg, #f0f7ff 0%, #F8F9FA 50%);
    display: flex;
    align-items: center;
}
.avx-forgot-card {
    background: #fff;
    border-radius: 24px;
    padding: 40px 36px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    border: 1px solid #e8eef5;
}
.avx-forgot-header { text-align: center; margin-bottom: 28px; }
.avx-forgot-icon {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, #279ED6, #3A86FF);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px; color: #fff; font-size: 28px;
    box-shadow: 0 8px 24px rgba(39,158,214,0.3);
}
.avx-forgot-header h3 { font-weight: 700; font-size: 22px; color: #333; margin-bottom: 8px; }
.avx-forgot-header p { color: #777; font-size: 13.5px; line-height: 1.6; }
.avx-forgot-form-group { margin-bottom: 20px; }
.avx-forgot-label { display: block; font-size: 12.5px; font-weight: 600; color: #555; margin-bottom: 8px; }
.avx-forgot-input-wrap {
    display: flex; align-items: center; border: 1.5px solid #dde5f0;
    border-radius: 12px; padding: 0 16px; height: 52px;
    transition: all 0.2s; background: #fff;
}
.avx-forgot-input-wrap:focus-within { border-color: #279ED6; box-shadow: 0 0 0 3px rgba(39,158,214,0.1); }
.avx-forgot-input-wrap i { color: #279ED6; font-size: 18px; margin-right: 12px; }
.avx-forgot-input { border: none; outline: none; width: 100%; font-size: 14px; background: transparent; }
.avx-forgot-btn {
    width: 100%; padding: 14px;
    background: linear-gradient(135deg, #279ED6 0%, #1a7bb5 100%);
    color: #fff; border: none; border-radius: 12px;
    font-weight: 700; font-size: 15px; cursor: pointer;
    transition: all 0.3s; box-shadow: 0 4px 14px rgba(39,158,214,0.3);
}
.avx-forgot-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(39,158,214,0.4); }
.avx-forgot-footer { text-align: center; margin-top: 20px; }
.avx-forgot-back { color: #279ED6; font-size: 13px; font-weight: 600; text-decoration: none; }
.avx-forgot-back:hover { text-decoration: underline; }
</style>
@endpush
@endsection
