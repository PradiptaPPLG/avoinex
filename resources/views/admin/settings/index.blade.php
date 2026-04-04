@extends('admin.layouts.app')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')

@section('content')

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1" style="font-weight: 800; font-size: 20px;">Website Settings</h4>
            <p class="text-muted mb-0" style="font-size: 13px;">Kelola informasi yang ditampilkan di footer dan halaman publik website.</p>
        </div>
        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-check-lg"></i> Save All Changes
        </button>
    </div>

    @foreach($groups as $groupKey => $groupInfo)
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-3">
                <div style="width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px;
                    @if($groupKey === 'social') background: rgba(59,130,246,0.1); color: #3B82F6;
                    @elseif($groupKey === 'contact') background: rgba(13,175,122,0.1); color: #0DAF7A;
                    @else background: rgba(245,158,11,0.1); color: #D97706;
                    @endif">
                    <i class="bi {{ $groupInfo['icon'] }}"></i>
                </div>
                <div>
                    <h5 class="mb-0">{{ $groupInfo['label'] }}</h5>
                    <small class="text-muted">{{ $groupInfo['description'] }}</small>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @if(isset($settings[$groupKey]))
                        @foreach($settings[$groupKey] as $setting)
                            <div class="{{ $setting->type === 'textarea' ? 'col-12' : 'col-md-6' }}">
                                <label class="form-label d-flex align-items-center gap-2">
                                    @if($groupKey === 'social')
                                        @php
                                            $iconMap = [
                                                'social_instagram' => 'bi-instagram',
                                                'social_facebook' => 'bi-facebook',
                                                'social_twitter' => 'bi-twitter-x',
                                                'social_youtube' => 'bi-youtube',
                                                'social_tiktok' => 'bi-tiktok',
                                                'social_whatsapp' => 'bi-whatsapp',
                                            ];
                                        @endphp
                                        <i class="bi {{ $iconMap[$setting->key] ?? 'bi-link-45deg' }}" style="font-size: 15px;"></i>
                                    @elseif($groupKey === 'contact')
                                        @php
                                            $contactIconMap = [
                                                'contact_email' => 'bi-envelope-fill',
                                                'contact_phone' => 'bi-telephone-fill',
                                                'contact_address' => 'bi-geo-alt-fill',
                                            ];
                                        @endphp
                                        <i class="bi {{ $contactIconMap[$setting->key] ?? 'bi-info-circle' }}" style="font-size: 14px;"></i>
                                    @endif
                                    {{ $setting->label }}
                                </label>

                                @if($setting->type === 'textarea')
                                    <textarea class="form-control" name="{{ $setting->key }}" rows="2" placeholder="{{ $setting->label }}">{{ $setting->value }}</textarea>
                                @else
                                    <input type="{{ $setting->type === 'email' ? 'email' : 'text' }}" 
                                           class="form-control" 
                                           name="{{ $setting->key }}" 
                                           value="{{ $setting->value }}" 
                                           placeholder="{{ $setting->label }}">
                                @endif

                                @if($setting->type === 'url')
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-info-circle" style="font-size: 10px;"></i> 
                                        Masukkan URL lengkap (contoh: https://instagram.com/avoinex)
                                    </small>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <div class="d-flex justify-content-end mb-4">
        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 px-4">
            <i class="bi bi-check-lg"></i> Save All Changes
        </button>
    </div>
</form>

@endsection
