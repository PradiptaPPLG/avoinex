<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Avoinex - Flight Reservation')</title>

    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #279ED6;
            --primary-2: #3A86FF;
            --accent: #8338EC;
            --light: #F8F9FA;
            --dark: #212529;
            --muted: #6C757D;
        }
        *{ box-sizing:border-box; }
        html,body{ height:100%; margin:0; padding:0; font-family: 'Poppins', sans-serif; background-color:var(--light); color:var(--dark); }

        .avx-topbar{
            position:fixed;
            left:0;
            right:0;
            top:0;
            height:72px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:12px 28px;
            background:#ffffff;
            z-index:1000;
        }

        @media print {
            .avx-topbar {
                display: none !important;
            }
            main {
                padding-top: 0 !important;
            }
            body {
                background-color: #fff !important;
            }
        }
        .avx-topbar .avx-left{ display:flex; align-items:center; gap:12px; }
        .avx-topbar .avx-logo{ height:36px; }
        .avx-topbar .avx-currency-block{
            background: rgba(217,217,217,0.5);
            padding:6px 10px;
            border-radius:10px;
            display:inline-flex;
            align-items:center;
            gap:8px;
            font-size:14px;
        }
        .avx-topbar .avx-flag-img{ width:18px; }

        .avx-topbar .avx-right{ display:flex; gap:12px; align-items:center; }
        .avx-login-btn{
            background:transparent;
            border:2px solid var(--primary);
            color:var(--primary);
            font-weight:600;
            padding:8px 14px;
            border-radius:10px;
            cursor:pointer;
        }
        .avx-signup-btn{
            background:var(--primary);
            color:#fff;
            padding:8px 14px;
            border-radius:10px;
            font-weight:700;
            cursor:pointer;
            border: none;
        }

        /* Styles untuk user login */
        .avx-user-profile-wrapper {
            display: inline-flex;
            align-items: center;
            background: white;
            border: 1px solid #279ED6;
            border-radius: 10px;
            padding: 4px 8px 4px 4px;
            position: relative;
        }

        .avx-user-profile {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .avx-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #279ED6;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f8ff;
        }

        .avx-user-name {
            font-weight: 600;
            color: #279ED6;
            font-size: 14px;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .avx-help-link {
            color: #11549D;
            font-family: 'Segoe UI Semibold', 'Segoe UI', sans-serif;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            margin-right: 16px;
        }

        .avx-currency-login {
            background: rgba(217,217,217,0.5);
            padding: 6px 10px;
            border-radius: 10px;
            font-size: 14px;
            margin-right: 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* Dropdown Styles */
        .avx-user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            min-width: 200px;
            display: none;
            overflow: hidden;
            z-index: 1001;
            border: 1px solid #e8e8e8;
        }

        .avx-user-dropdown.show {
            display: block;
        }

        .avx-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            color: #212529;
            text-decoration: none;
            border-bottom: 1px solid #f5f5f5;
            transition: all 0.2s ease;
            background: white;
        }

        .avx-dropdown-item:hover {
            background: #f8f9fa;
            color: #279ED6;
            padding-left: 20px;
        }

        .avx-dropdown-item:last-child {
            border-bottom: none;
        }

        .avx-dropdown-item.logout:hover {
            background: #fff0f0;
            color: #d32f2f;
        }

        .avx-dropdown-icon {
            width: 18px;
            height: 18px;
            color: #279ED6;
            transition: color 0.2s ease;
        }

        .avx-dropdown-item:hover .avx-dropdown-icon {
            color: inherit;
        }

        .avx-dropdown-item.logout:hover .avx-dropdown-icon {
            color: #d32f2f;
        }

        /* Logout message */
        .avx-logout-message {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-weight: 500;
            animation: fadeInOut 3s ease-in-out;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
            10% { opacity: 1; transform: translateX(-50%) translateY(0); }
            90% { opacity: 1; transform: translateX(-50%) translateY(0); }
            100% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
        }

        main{ min-height: calc(100vh - 72px); padding-top: 72px; }
        a{ color:inherit; text-decoration: none; }
        button{ font:inherit; }

        /* ===== AVX MODAL STYLES ===== */
        /* Colors requested */
        :root {
            --avx-primary: #279ED6;
            --avx-primary-rgba-37: rgba(39,158,214,0.37);
            --avx-link: #11549D;
            --avx-muted: #787878;
        }

        /* Prefix avx- to avoid conflicts */
        .avx-modal-overlay {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.55);
            z-index: 99999;
        }

        /* Container that centers the card */
        .avx-modal-container {
            overflow: hidden;
            width: 560px;
            max-width: 94vw;
            max-height: 92vh;
            outline: none;
        }

        /* Card with specified stroke and bigger radius (96px) */
        .avx-modal-card {
            background: #ffffff;
            border-radius: 96px; /* increased corner radius */
            overflow: visible;
            position: relative;
            border: 5px solid var(--avx-primary-rgba-37);
            box-shadow:
                0 34px 84px rgba(10,20,30,0.32),
                0 10px 36px rgba(39,158,214,0.09);
        }

        /* Close button */
        .avx-modal-close {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 30;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: none;
            background: rgba(255,255,255,0.95);
            color: #333;
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        /* Header: match top radius to card to avoid sharp edges */
        .avx-modal-header {
            border-radius: 96px 96px 0 0; /* match card top corners */
            text-align: center;
            padding: 28px 24px 18px;
            background: linear-gradient(180deg, rgba(255,255,255,0.99) 0%, rgba(250,250,255,0.99) 100%);
            color: #0b2350;
        }

        /* Logo - REMOVE any shadow effect */
        .avx-logo-wrap { margin-bottom: 8px; }
        .avx-modal-logo { width: 72px; height: 72px; object-fit: contain; filter: none; box-shadow: none; }

        /* Premium tag: uses Segoe UI Regular and color #787878 */
        .avx-premium-tag {
            display: inline-flex;
            gap:8px;
            align-items:center;
            font-size:12px;
            color: var(--avx-muted);
            opacity: 1; /* 100% */
            margin-bottom: 8px;
            font-family: "Segoe UI", system-ui, -apple-system, "Helvetica Neue", Arial;
            font-weight: 400;
        }

        /* LOGIN / REGISTER TITLE: Segoe UI Bold, color #279ED6 */
        .avx-modal-title {
            font-size: 26px;
            margin:6px 0 6px;
            font-family: "Segoe UI", "Segoe UI Semibold", system-ui, -apple-system;
            font-weight: 700;
            color: var(--avx-primary); /* #279ED6 */
            letter-spacing: -0.4px;
        }

        /* subtitle lines (part of premium through get exclusive deals must be Segoe UI Regular color #787878) */
        .avx-modal-subtitle {
            font-size:13px;
            color: var(--avx-muted); /* #787878 */
            margin:0;
            line-height:1.45;
            font-family: "Segoe UI", system-ui, -apple-system;
            font-weight: 400;
        }

        /* Body */
        .avx-modal-body { padding: 18px 28px 20px; }

        /* Alerts */
        .avx-alert-error { background:#FFF0F0; border-left:4px solid #FF4D4F; padding:12px 14px; border-radius:8px; color:#8b1f1f; margin-bottom:16px; font-size:14px; }

        /* Buttons base */
        .avx-btn { display:flex; align-items:center; gap:10px; justify-content:center; width:100%; padding:14px 16px; border-radius:14px; font-weight:700; cursor:pointer; text-decoration:none; }

        /* GOOGLE: white with outline #787878 1px; make narrower */
        .avx-btn-google {
            background:white;
            border:1px solid #787878;
            color:#222;
            font-size:15px;
            margin: 0 auto 12px;
            box-shadow:none;
            border-radius:14px;
            max-width: 420px; /* reduced width */
            width: calc(100% - 120px); /* keep responsive narrower */
        }

        /* Primary email button: color #279ED6, slightly narrower than full */
        .avx-btn-primary.avx-email-btn {
            background: var(--avx-primary);
            color: white;
            border: none;
            font-size:15px;
            box-shadow: 0 10px 24px rgba(39,158,214,0.18);
            border-radius:14px;
            max-width: 500px; /* slightly reduced width */
            width: calc(100% - 60px);
            margin: 0 auto 12px;
        }

        .avx-btn svg { display:inline-block; }

        /* Divider: removed side lines, text black and Segoe UI Regular */
        .avx-divider {
            display:flex;
            align-items:center;
            justify-content:center;
            margin:18px 0;
            color: #000000; /* black */
            font-size:13px;
            font-family: "Segoe UI", system-ui, -apple-system;
            font-weight: 400; /* Segoe UI Regular */
        }
        .avx-divider span { padding: 0 6px; background: transparent; }

        /* Alternative buttons (FB / Apple) */
        .avx-alt-buttons { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:8px; }
        .avx-alt { padding:12px; border-radius:14px; border:1.5px solid #E8E8E8; background:white; font-weight:700; cursor:pointer; display:inline-flex; gap:8px; align-items:center; justify-content:center; }
        .avx-alt-facebook { color: #000000; border-color: #E8E8E8; } /* Facebook text black as requested */
        .avx-alt-apple { color: #000000; border-color: #E8E8E8; }

        /* keep icon-only styles in case needed elsewhere, but not used for register */
        .avx-alt-icons { display:flex; justify-content:center; gap:18px; margin-bottom:12px; }
        .avx-icon-btn { width:60px; height:60px; border-radius:50%; border:1.5px solid #E8E8E8; background:white; display:inline-flex; align-items:center; justify-content:center; font-size:22px; }

        /* Form */
        .avx-form-block { margin-top: 6px; }
        .avx-form-row { display:flex; gap:12px; margin-bottom:12px; }
        .avx-form-group { margin-bottom:12px; }
        .avx-half { flex:1; }
        .avx-form-input { width:100%; padding:14px; border-radius:12px; border:1.6px solid #E8E8E8; background:#FBFBFD; font-size:15px; font-family: "Segoe UI", system-ui, -apple-system; }
        .avx-form-input:focus { outline:none; box-shadow:0 0 0 4px rgba(39,158,214,0.08); border-color:var(--avx-primary); background:white; }

        /* options */
        .avx-form-options { display:flex; justify-content:space-between; align-items:center; margin:12px 0 18px 0; }
        .avx-checkbox { display:flex; gap:8px; align-items:center; font-weight:600; color:#555; font-family: "Segoe UI", system-ui; }
        .avx-forgot-link { color:var(--avx-primary); text-decoration:none; font-weight:700; }

        /* Submit */
        .avx-btn-submit { padding:14px; background:linear-gradient(135deg,#3A86FF 0%,#8338EC 100%); color:white; border:none; border-radius:14px; font-weight:800; margin-top:6px; }

        /* Footer: privacy block — NO top border, compact spacing, links color #11549D */
        .avx-modal-footer, .avx-privacy-block, .avx-privacy-note {
            text-align:center;
            margin-top:6px; /* minimal */
            border-top: none; /* remove divider line above */
            color: #000000; /* main privacy text black */
            font-size:13px;
            font-family: "Segoe UI", system-ui, -apple-system;
            font-weight: 400; /* Segoe UI Regular */
            line-height:1.3;
            padding: 6px 8px 12px 8px;
        }
        /* FORCE privacy links color so Bootstrap doesn't override it */
        .avx-privacy-note a, .avx-privacy-link, .avx-switch-action {
            color: var(--avx-link) !important; /* #11549D */
            font-weight: 700; /* keep Login/Sign action bold like before */
            text-decoration: none;
        }
        .avx-privacy-note a:hover, .avx-switch-action:hover { text-decoration: underline !important; }

        /* responsive */
        @media (max-width: 768px) {
            .avx-topbar { padding: 12px 16px; }
            .avx-currency-block { display: none !important; }
            .avx-currency-login { display: none !important; }
            .avx-topbar .avx-left { gap: 8px; }
            .avx-topbar .avx-right { gap: 8px; }
            .avx-login-btn, .avx-signup-btn { padding: 8px 10px; font-size: 13px; }
            .avx-user-name { display: none; }
            .avx-help-link { display: none; }
        }

        @media (max-width: 520px) {
            .avx-modal-container { width: 96vw; }
            .avx-modal-card { border-radius:48px; } /* smaller on mobile */
            .avx-modal-logo { width:60px; height:60px; }
            .avx-divider { margin:14px 0; }
            .avx-btn-google { width: 88%; max-width: 360px; }
            .avx-btn-primary.avx-email-btn { width: 88%; max-width: 360px; }
            
            .avx-user-profile-wrapper {
                max-width: unset;
                padding: 2px 6px 2px 2px;
                border: none;
                background: transparent;
            }
            .avx-user-name { display: none; }
            .avx-help-link { display: none; }
            .avx-login-btn span, .avx-signup-btn span { display: none; } /* Hide text on very small screens, keep icons */
        }
    </style>

    @stack('styles')
</head>
<body>

<header class="avx-topbar">
    <div class="avx-left">
        <a href="/" id="avoinex-logo-link">
            <img src="{{ asset('images/logotext.png') }}" class="avx-logo">
        </a>
        @if(!session('client_id'))
        <span class="avx-currency-block">
            <img src="{{ asset('images/bendera.png') }}" class="avx-flag-img">
            IDR | ID
        </span>
        @endif
    </div>

    <div class="avx-right">
        @if(session('client_id'))
            <!-- Bantuan Link -->
            <a href="{{ route('support') }}" class="avx-help-link">Bantuan</a>
            
            <!-- IDR | ID untuk user login dengan bendera -->
            <div class="avx-currency-login">
                <img src="{{ asset('images/bendera.png') }}" class="avx-flag-img">
                IDR | ID
            </div>
            
            <!-- User Profile dengan wrapper -->
            <div class="avx-user-profile-wrapper">
                <div class="avx-user-profile" id="userProfile">
                    <div class="avx-user-avatar">
                        @if(session('client_avatar') && session('client_avatar') != 'default')
                            <img src="{{ session('client_avatar') }}" alt="{{ session('client_name') }}" style="width:100%;height:100%;border-radius:50%;">
                        @else
                            <svg class="avx-default-avatar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 24px; height: 24px; color: #279ED6;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endif
                    </div>
                    <span class="avx-user-name">{{ session('client_name') }}</span>
                    
                    <!-- Dropdown arrow -->
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" style="margin-left: 4px;">
                        <path d="M6 9L12 15L18 9" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                
                <!-- Dropdown Menu -->
                <div class="avx-user-dropdown" id="userDropdown">
                    <a href="{{ route('home') }}" class="avx-dropdown-item">
                        <svg class="avx-dropdown-icon" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Home
                    </a>
                    <a href="{{ route('profile') }}" class="avx-dropdown-item">
                        <svg class="avx-dropdown-icon" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        My Profile
                    </a>
                    <a href="{{ route('booking.index') }}" class="avx-dropdown-item">
                        <svg class="avx-dropdown-icon" viewBox="0 0 24 24"><path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        My Bookings
                    </a>
                    <div class="avx-dropdown-item logout">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            color: inherit;
                            text-decoration: none;
                            width: 100%;
                        ">
                            <svg class="avx-dropdown-icon" viewBox="0 0 24 24"><path fill="currentColor" d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <button class="avx-login-btn" onclick="showModal('login')"><i class="bi bi-box-arrow-in-right me-1"></i>Login</button>
            <button class="avx-signup-btn" onclick="showModal('register')"><i class="bi bi-person-plus-fill me-1"></i>Register</button>
        @endif
    </div>
</header>

<main>
    @yield('content')
</main>

@stack('scripts')

<!-- ==================== -->
<!-- LOGIN MODAL -->
<!-- ==================== -->
<div id="loginModal" class="avx-modal-overlay" aria-hidden="true" role="dialog" aria-modal="true" style="display: none;">
    <div class="avx-modal-container" role="document" tabindex="-1" aria-labelledby="avx-login-title">
        <button class="avx-modal-close" onclick="closeModal('login')" aria-label="Close modal">×</button>

        <div class="avx-modal-card" role="presentation">
            <div class="avx-modal-header">
                <div class="avx-logo-wrap">
                    <img src="{{ asset('images/iconfix.png') }}" alt="Avoinex" class="avx-modal-logo">
                </div>
                <div class="avx-premium-tag">
                    <span>Part of Premium Flight Network</span>
                </div>

                <h1 id="avx-login-title" class="avx-modal-title">Login to Avoinex</h1>
                <p class="avx-modal-subtitle">Create your account to book flights, earn<br>rewards,and get exclusive deals</p>
            </div>

            <div class="avx-modal-body">
                @if(session('error'))
                    <div class="avx-alert-error">{{ session('error') }}</div>
                @endif

                <!-- Google button: white with #787878 outline 1px, narrower -->
                <a href="{{ route('google.redirect') }}" class="avx-btn avx-btn-social avx-btn-google" aria-label="Continue with Google">
                    <!-- google svg -->
                    <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>

                <!-- Continue with Email or Phone: color #279ED6 -->
                <button type="button" class="avx-btn avx-btn-primary avx-email-btn" onclick="toggleEmailLogin()" id="avx-email-login-toggle">
                    <!-- mail icon -->
                    <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="#ffffff" d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5L4 8V6l8 5 8-5v2z"/></svg>
                    <span>Continue with Email or Phone</span>
                </button>

                <div id="emailLoginForm" class="avx-form-block" style="display: none; margin-top: 20px;">
                    <form action="{{ route('login.submit') }}" method="POST" novalidate>
                        @csrf
                        <div class="avx-form-group">
                            <input type="text" name="identifier" placeholder="Email or Phone Number" required class="avx-form-input" autocomplete="username">
                        </div>
                        <div class="avx-form-group">
                            <input type="password" name="password" placeholder="Password" required class="avx-form-input" autocomplete="current-password">
                        </div>
                        <div class="avx-form-options">
                            <label class="avx-checkbox"><input type="checkbox" name="remember" checked> <span>Remember me</span></label>
                            <a href="{{ route('password.forgot') }}" class="avx-forgot-link">Forgot password?</a>
                        </div>
                        <button type="submit" class="avx-btn avx-btn-submit"><i class="bi bi-airplane-fill me-2" style="transform: rotate(45deg);"></i> Login to Account</button>
                    </form>
                </div>

                <!-- Divider: no side lines as requested, Segoe UI Regular black -->
                <div class="avx-divider"><span>Or continue with</span></div>

                <div class="avx-alt-buttons">
                    <!-- Facebook button: icon color blue + text black -->
                    <button class="avx-alt avx-alt-facebook" onclick="handleFacebookLogin()">
                        <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="#1877F2" d="M22 12A10 10 0 1 0 12 22V14.7h-1.9V12H12V10.1c0-1.9 1.1-3 2.9-3 .8 0 1.6.06 1.6.06v1.8h-1c-1 0-1.3.62-1.3 1.26V12h2.3l-.37 2.7H14.2V22A10 10 0 0 0 22 12z"/></svg>
                        Facebook
                    </button>

                    <!-- Apple button: icon + black text -->
                    <button class="avx-alt avx-alt-apple" onclick="handleAppleLogin()">
                        <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="#000000" d="M16.365 1.43c-.95.028-2.117.64-2.8 1.41-.6.68-1.18 1.76-.98 2.82 1.02.06 2.1-.56 2.79-1.34.7-.78 1.19-1.95.99-2.9zM20.6 7.58c-1.06-.54-2.53-.3-3.46.34-.74.52-1.36 1.38-2.28 1.38-.95 0-1.47-.87-2.53-.87-1.07 0-2.4.86-3.23 2.05-1.14 1.66-1.05 4.7.18 6.9.77 1.36 2.15 3.13 3.68 3.12.92-.02 1.26-.6 2.36-.6 1.09 0 1.41.6 2.36.57 1.56-.03 2.53-1.4 3.3-2.77.93-1.6 1.33-3.14 1.35-3.22-.03-.01-2.57-.99-2.67-3.95-.09-2.68 1.87-3.96 1.92-4.01-.01-.01-1.96-.75-3.01-.17z"/></svg>
                        Apple
                    </button>
                </div>

                <div class="avx-modal-footer avx-privacy-block">
                    <!-- Privacy lines with explicit breaks and NO top border/extra spacing -->
                    <p class="avx-privacy-note">
                        By logging in, you agree to Avoinex's
                        <a href="#" class="avx-privacy-link">Privacy Policy</a> and<br>
                        <a href="#" class="avx-privacy-link">Terms &amp; Conditions</a>.<br>
                        Don't have an account? <a href="#" onclick="switchModal('login','register'); return false;" class="avx-switch-action">Sign up here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== -->
<!-- REGISTER MODAL -->
<!-- ==================== -->
<div id="registerModal" class="avx-modal-overlay" aria-hidden="true" role="dialog" aria-modal="true" style="display: none;">
    <div class="avx-modal-container" role="document" tabindex="-1" aria-labelledby="avx-register-title">
        <button class="avx-modal-close" onclick="closeModal('register')" aria-label="Close modal">×</button>

        <div class="avx-modal-card" role="presentation">
            <div class="avx-modal-header">
                <div class="avx-logo-wrap">
                    <img src="{{ asset('images/iconfix.png') }}" alt="Avoinex" class="avx-modal-logo">
                </div>
                <div class="avx-premium-tag">
                    <span>Part of Premium Flight Network</span>
                </div>

                <h1 id="avx-register-title" class="avx-modal-title">Join Avoinex</h1>
                <p class="avx-modal-subtitle">Create your account to book flights, earn<br>rewards,and get exclusive deals</p>
            </div>

            <div class="avx-modal-body">
                @if($errors->any())
                    <div class="avx-alert-error">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <a href="{{ route('google.redirect') }}" class="avx-btn avx-btn-social avx-btn-google" aria-label="Continue with Google">
                    <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>

                <button type="button" class="avx-btn avx-btn-primary avx-email-btn" onclick="toggleEmailRegister()" id="avx-email-register-toggle">
                    <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="#ffffff" d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5L4 8V6l8 5 8-5v2z"/></svg>
                    <span>Continue with Email or Phone</span>
                </button>

                <div id="emailRegisterForm" class="avx-form-block" style="display: none; margin-top: 20px;">
                    <form action="{{ route('register') }}" method="POST" novalidate>
                        @csrf
                        <div class="avx-form-row">
                            <div class="avx-form-group avx-half"><input type="text" name="first_name" placeholder="First Name" required class="avx-form-input"></div>
                            <div class="avx-form-group avx-half"><input type="text" name="last_name" placeholder="Last Name" required class="avx-form-input"></div>
                        </div>
                        <div class="avx-form-group"><input type="email" name="email" placeholder="Email Address" required class="avx-form-input"></div>
                        <div class="avx-form-group"><input type="tel" name="phone" placeholder="Phone Number" required class="avx-form-input"></div>
                        <div class="avx-form-group"><input type="text" name="passport" placeholder="Passport Number" required class="avx-form-input"></div>
                        <div class="avx-form-group"><input type="password" name="password" placeholder="Password (min 8 characters)" required class="avx-form-input"></div>
                        <div class="avx-form-group"><input type="password" name="password_confirmation" placeholder="Confirm Password" required class="avx-form-input"></div>

                        <div class="avx-form-check">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">I agree to the <a href="#" class="avx-link avx-privacy-link">Terms of Service</a> and <a href="#" class="avx-link avx-privacy-link">Privacy Policy</a></label>
                        </div>

                        <button type="submit" class="avx-btn avx-btn-submit"><i class="bi bi-airplane-fill me-2" style="transform: rotate(45deg);"></i> Create Account</button>
                    </form>
                </div>

                <!-- Use same alt-buttons (not icon-only) so register matches login -->
                <div class="avx-alt-buttons">
                    <button class="avx-alt avx-alt-facebook" onclick="handleFacebookRegister()">
                        <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="#1877F2" d="M22 12A10 10 0 1 0 12 22V14.7h-1.9V12H12V10.1c0-1.9 1.1-3 2.9-3 .8 0 1.6.06 1.6.06v1.8h-1c-1 0-1.3.62-1.3 1.26V12h2.3l-.37 2.7H14.2V22A10 10 0 0 0 22 12z"/></svg>
                        Facebook
                    </button>
                    <button class="avx-alt avx-alt-apple" onclick="handleAppleRegister()">
                        <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path fill="#000000" d="M16.365 1.43c-.95.028-2.117.64-2.8 1.41-.6.68-1.18 1.76-.98 2.82 1.02.06 2.1-.56 2.79-1.34.7-.78 1.19-1.95.99-2.9zM20.6 7.58c-1.06-.54-2.53-.3-3.46.34-.74.52-1.36 1.38-2.28 1.38-.95 0-1.47-.87-2.53-.87-1.07 0-2.4.86-3.23 2.05-1.14 1.66-1.05 4.7.18 6.9.77 1.36 2.15 3.13 3.68 3.12.92-.02 1.26-.6 2.36-.6 1.09 0 1.41.6 2.36.57 1.56-.03 2.53-1.4 3.3-2.77.93-1.6 1.33-3.14 1.35-3.22-.03-.01-2.57-.99-2.67-3.95-.09-2.68 1.87-3.96 1.92-4.01-.01-.01-1.96-.75-3.01-.17z"/></svg>
                        Apple
                    </button>
                </div>

                <div class="avx-modal-footer avx-privacy-block">
                    <p class="avx-privacy-note">
                        By signing up, you agree to Avoinex's
                        <a href="#" class="avx-privacy-link">Privacy Policy</a> and<br>
                        <a href="#" class="avx-privacy-link">Terms &amp; Conditions</a>.<br>
                        Already have an account? <a href="#" onclick="switchModal('register','login'); return false;" class="avx-switch-action">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
// Fungsi untuk toggle dropdown user
document.addEventListener('DOMContentLoaded', function() {
    const userProfile = document.getElementById('userProfile');
    const userDropdown = document.getElementById('userDropdown');
    let dropdownTimeout;
    
    if (userProfile && userDropdown) {
        // Hover untuk membuka dropdown
        userProfile.addEventListener('mouseenter', function() {
            clearTimeout(dropdownTimeout);
            dropdownTimeout = setTimeout(() => {
                userDropdown.classList.add('show');
            }, 200);
        });
        
        // Hover untuk menutup dropdown (dengan delay)
        userProfile.addEventListener('mouseleave', function(e) {
            clearTimeout(dropdownTimeout);
            dropdownTimeout = setTimeout(() => {
                if (!userDropdown.matches(':hover')) {
                    userDropdown.classList.remove('show');
                }
            }, 300);
        });
        
        // Juga support klik untuk mobile
        userProfile.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        
        // Biar dropdown stay open ketika hover di dalamnya
        userDropdown.addEventListener('mouseenter', function() {
            clearTimeout(dropdownTimeout);
        });
        
        userDropdown.addEventListener('mouseleave', function() {
            dropdownTimeout = setTimeout(() => {
                userDropdown.classList.remove('show');
            }, 300);
        });
        
        // Close dropdown ketika klik di luar
        document.addEventListener('click', function(e) {
            if (!userProfile.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
    }
    
    // Cek jika ada parameter logout di URL untuk menampilkan notifikasi
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('logout') === 'success') {
        showLogoutNotification();
    }
    
    // Fungsi untuk menampilkan notifikasi logout
    function showLogoutNotification() {
        const notification = document.createElement('div');
        notification.className = 'avx-logout-message';
        notification.textContent = 'Anda Berhasil Logout!';
        notification.style.cssText = `
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-weight: 500;
            animation: fadeInOut 3s ease-in-out;
        `;
        
        // Tambahkan style animation jika belum ada
        if (!document.querySelector('#logout-notification-style')) {
            const style = document.createElement('style');
            style.id = 'logout-notification-style';
            style.textContent = `
                @keyframes fadeInOut {
                    0% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
                    10% { opacity: 1; transform: translateX(-50%) translateY(0); }
                    90% { opacity: 1; transform: translateX(-50%) translateY(0); }
                    100% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
                }
            `;
            document.head.appendChild(style);
        }
        
        document.body.appendChild(notification);
        
        // Hapus notifikasi setelah 3 detik
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    const logoutLinks = document.querySelectorAll('.logout-link');
    logoutLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Create a form dynamically
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('logout') }}";
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = "{{ csrf_token() }}";
            form.appendChild(csrfToken);
            
            document.body.appendChild(form);
            form.submit();
        });
    });
});

// ===== AVX SCOPE JS (safe, vanilla, resilient) =====
(function(){
    function $(id){ return document.getElementById(id); }
    function showOverlay(id) {
        const el = $(id + 'Modal');
        if(!el) return;
        el.style.display = 'flex';
        el.setAttribute('aria-hidden','false');
        document.body.style.overflow = 'hidden';
        const focusable = el.querySelector('button, a, input, [tabindex]:not([tabindex="-1"])');
        if(focusable) focusable.focus();
    }
    function hideOverlay(id) {
        const el = $(id + 'Modal');
        if(!el) return;
        el.style.display = 'none';
        el.setAttribute('aria-hidden','true');
        document.body.style.overflow = '';
        const loginForm = $('emailLoginForm');
        const regForm = $('emailRegisterForm');
        if(loginForm) loginForm.style.display = 'none';
        if(regForm) regForm.style.display = 'none';
    }

    window.showModal = function(type){ showOverlay(type); };
    window.closeModal = function(type){ hideOverlay(type); };

    window.switchModal = function(from, to){
        hideOverlay(from);
        setTimeout(function(){ showOverlay(to); }, 160);
    };

    window.toggleEmailLogin = function(){
        const f = $('emailLoginForm');
        if(!f) return;
        f.style.display = (f.style.display === 'block') ? 'none' : 'block';
        if(f.style.display === 'block') {
            const i = f.querySelector('input');
            if(i) i.focus();
        }
    };
    window.toggleEmailRegister = function(){
        const f = $('emailRegisterForm');
        if(!f) return;
        f.style.display = (f.style.display === 'block') ? 'none' : 'block';
        if(f.style.display === 'block') {
            const i = f.querySelector('input');
            if(i) i.focus();
        }
    };

    window.handleFacebookLogin = function(){ alert('Facebook login flow'); };
    window.handleAppleLogin = function(){ alert('Apple login flow'); };
    window.handleFacebookRegister = function(){ alert('Facebook register flow'); };
    window.handleAppleRegister = function(){ alert('Apple register flow'); };

    document.addEventListener('click', function(e){
        const overlays = document.querySelectorAll('.avx-modal-overlay');
        overlays.forEach(function(ov){
            if(ov.style.display !== 'none' && e.target === ov) {
                const id = ov.id.replace('Modal','');
                hideOverlay(id);
            }
        });
    });

    document.addEventListener('keydown', function(e){
        if(e.key === 'Escape' || e.key === 'Esc') {
            const open = document.querySelector('.avx-modal-overlay[style*="display: flex"]');
            if(open) {
                const id = open.id.replace('Modal','');
                hideOverlay(id);
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function(){
        @if(session('error'))
            showOverlay('login');
            setTimeout(function(){ toggleEmailLogin(); }, 250);
        @endif

        @if($errors->any())
            showOverlay('register');
            setTimeout(function(){ toggleEmailRegister(); }, 250);
        @endif
        
        // Cek jika ada session logout message dari server
        @if(session('logout_message'))
            const notification = document.createElement('div');
            notification.className = 'avx-logout-message';
            notification.textContent = '{{ session("logout_message") }}';
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        @endif
    });
    });
})();
</script>

<script>
// Hidden Admin Trigger: 7 clicks on logo -> Type "123" -> Press "Enter"
document.addEventListener('DOMContentLoaded', function() {
    const logoLink = document.getElementById('avoinex-logo-link');
    if (!logoLink) return;

    let logoClickCount = 0;
    let logoClickTimer;
    let isSecretModeReady = false;
    let secretTyped = "";

    logoLink.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent immediate home navigation
        logoClickCount++;
        
        clearTimeout(logoClickTimer);
        
        if (logoClickCount >= 7) {
            // Activate secret mode listening
            isSecretModeReady = true;
            secretTyped = "";
            logoClickCount = 0;
            // Visual indicator to the user that it unlocked
            logoLink.style.transform = 'scale(1.1)';
            setTimeout(() => logoLink.style.transform = 'scale(1)', 300);
            console.log("Secret Mode Ready... Type PIN and press Enter");
        } else {
            // Give them 2000ms between clicks
            logoClickTimer = setTimeout(() => {
                if (logoClickCount > 0 && !isSecretModeReady) {
                    window.location.href = '/'; 
                }
                logoClickCount = 0;
            }, 2000); 
        }
    });

    window.addEventListener('keydown', function(e) {
        if (!isSecretModeReady) return;
        
        if (e.key === 'Enter') {
            if (secretTyped === '123') {
                window.location.href = '/admin/login';
            } else {
                isSecretModeReady = false;
                secretTyped = "";
            }
        } else {
            if (e.key.length === 1) {
                secretTyped += e.key;
            }
        }
    });
});
</script>


<!-- ═══════════════════════════════════════════════════════ -->
<!-- FOOTER                                                  -->
<!-- ═══════════════════════════════════════════════════════ -->
<style>
    .avx-footer {
        background: linear-gradient(180deg, #0a1628 0%, #060d1a 100%);
        color: rgba(255,255,255,0.7);
        font-family: 'Poppins', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .avx-footer::before {
        content: '';
        position: absolute;
        top: -120px;
        left: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(39,158,214,0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .avx-footer::after {
        content: '';
        position: absolute;
        bottom: -80px;
        right: -60px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(39,158,214,0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    .avx-footer-main {
        max-width: 1240px;
        margin: 0 auto;
        padding: 56px 32px 40px;
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
        gap: 48px;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 992px) {
        .avx-footer-main {
            grid-template-columns: 1fr 1fr;
            gap: 36px;
        }
    }

    @media (max-width: 576px) {
        .avx-footer-main {
            grid-template-columns: 1fr;
            gap: 32px;
            padding: 40px 20px 32px;
        }
    }

    .avx-footer-brand img {
        height: 32px;
        margin-bottom: 16px;
        filter: brightness(0) invert(1);
    }

    .avx-footer-tagline {
        font-size: 13.5px;
        line-height: 1.7;
        color: rgba(255,255,255,0.5);
        margin-bottom: 24px;
    }

    .avx-footer-socials {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .avx-footer-socials a {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.5);
        font-size: 16px;
        transition: all 0.25s ease;
        text-decoration: none;
    }

    .avx-footer-socials a:hover {
        background: rgba(39,158,214,0.15);
        border-color: rgba(39,158,214,0.4);
        color: #279ED6;
        transform: translateY(-2px);
    }

    .avx-footer h4 {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: rgba(255,255,255,0.9);
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
    }

    .avx-footer h4::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 28px;
        height: 2px;
        background: #279ED6;
        border-radius: 2px;
    }

    .avx-footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .avx-footer-links li {
        margin-bottom: 10px;
    }

    .avx-footer-links a {
        color: rgba(255,255,255,0.5);
        text-decoration: none;
        font-size: 13.5px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .avx-footer-links a:hover {
        color: #279ED6;
        transform: translateX(3px);
    }

    .avx-footer-links a i {
        font-size: 11px;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .avx-footer-links a:hover i {
        opacity: 1;
    }

    .avx-footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 16px;
        font-size: 13.5px;
    }

    .avx-footer-contact-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: rgba(39,158,214,0.1);
        border: 1px solid rgba(39,158,214,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #279ED6;
        font-size: 16px;
        flex-shrink: 0;
    }
    .avx-footer-contact-icon i {
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1; /* Best for icon centering */
        display: inline-flex;
    }

    .avx-footer-contact-text {
        line-height: 1.5;
    }

    .avx-footer-contact-text span {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(255,255,255,0.35);
        font-weight: 600;
        margin-bottom: 2px;
    }

    .avx-footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.06);
        position: relative;
        z-index: 1;
    }

    .avx-footer-bottom-inner {
        max-width: 1240px;
        margin: 0 auto;
        padding: 20px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    @media (max-width: 576px) {
        .avx-footer-bottom-inner {
            flex-direction: column;
            text-align: center;
            padding: 16px 20px;
        }
    }

    .avx-footer-copyright {
        font-size: 12.5px;
        color: rgba(255,255,255,0.35);
    }

    .avx-footer-legal {
        display: flex;
        gap: 20px;
    }

    .avx-footer-legal a {
        font-size: 12.5px;
        color: rgba(255,255,255,0.35);
        text-decoration: none;
        transition: color 0.2s;
    }

    .avx-footer-legal a:hover {
        color: #279ED6;
    }

    /* Don't show footer when printing */
    @media print {
        .avx-footer { display: none !important; }
    }
</style>

<footer class="avx-footer">
    <div class="avx-footer-main">
        <!-- Brand -->
        <div class="avx-footer-brand">
            <img src="{{ asset('images/logotext.png') }}" alt="Avoinex">
            <p class="avx-footer-tagline">{{ $siteSettings['footer_tagline'] ?? 'Your Trusted Partner for Smarter, Easier, and More Affordable Flight Booking.' }}</p>
            <div class="avx-footer-socials">
                @if(!empty($siteSettings['social_instagram']) && $siteSettings['social_instagram'] !== '#')
                <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                @endif
                @if(!empty($siteSettings['social_facebook']) && $siteSettings['social_facebook'] !== '#')
                <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                @endif
                @if(!empty($siteSettings['social_twitter']) && $siteSettings['social_twitter'] !== '#')
                <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                @endif
                @if(!empty($siteSettings['social_youtube']) && $siteSettings['social_youtube'] !== '#')
                <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                @endif
                @if(!empty($siteSettings['social_tiktok']) && $siteSettings['social_tiktok'] !== '#')
                <a href="{{ $siteSettings['social_tiktok'] }}" target="_blank" rel="noopener" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                @endif
                @if(!empty($siteSettings['social_whatsapp']) && $siteSettings['social_whatsapp'] !== '#')
                <a href="{{ $siteSettings['social_whatsapp'] }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                @endif
            </div>
        </div>

        <!-- Navigasi -->
        <div>
            <h4>Layanan</h4>
            <ul class="avx-footer-links">
                <li><a href="/"><i class="bi bi-chevron-right"></i> Cari Penerbangan</a></li>
                <li><a href="{{ route('deals') }}"><i class="bi bi-chevron-right"></i> Promo & Deals</a></li>
                <li><a href="{{ route('booking.find.form') }}"><i class="bi bi-chevron-right"></i> Cek Booking</a></li>
                <li><a href="{{ route('support') }}"><i class="bi bi-chevron-right"></i> Pusat Bantuan</a></li>
            </ul>
        </div>

        <!-- Perusahaan -->
        <div>
            <h4>Perusahaan</h4>
            <ul class="avx-footer-links">
                <li><a href="#"><i class="bi bi-chevron-right"></i> Tentang Kami</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Karir</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Blog</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Mitra & Afiliasi</a></li>
            </ul>
        </div>

        <!-- Kontak -->
        <div>
            <h4>Hubungi Kami</h4>
            @if(!empty($siteSettings['contact_email']))
            <div class="avx-footer-contact-item">
                <div class="avx-footer-contact-icon"><i class="bi bi-envelope-fill"></i></div>
                <div class="avx-footer-contact-text">
                    <span>Email</span>
                    {{ $siteSettings['contact_email'] }}
                </div>
            </div>
            @endif
            @if(!empty($siteSettings['contact_phone']))
            <div class="avx-footer-contact-item">
                <div class="avx-footer-contact-icon"><i class="bi bi-telephone-fill"></i></div>
                <div class="avx-footer-contact-text">
                    <span>Telepon</span>
                    {{ $siteSettings['contact_phone'] }}
                </div>
            </div>
            @endif
            @if(!empty($siteSettings['contact_address']))
            <div class="avx-footer-contact-item">
                <div class="avx-footer-contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                <div class="avx-footer-contact-text">
                    <span>Kantor</span>
                    {{ $siteSettings['contact_address'] }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="avx-footer-bottom">
        <div class="avx-footer-bottom-inner">
            <div class="avx-footer-copyright">
                {{ $siteSettings['footer_copyright'] ?? '© 2026 Avoinex Airlines. All Rights Reserved.' }}
            </div>
            <div class="avx-footer-legal">
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Cookies</a>
            </div>
        </div>
    </div>
</footer>

@include('chatbot')

@stack('scripts')
</body>
</html>