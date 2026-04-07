<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> — Avoinex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0066CC;
            --primary-dark: #004A99;
            --primary-light: #E8F1FB;
            --accent: #00C2A8;
            --accent-dark: #009E88;
            --sidebar-bg: #080F1E;
            --sidebar-width: 260px;
            --surface: #ffffff;
            --surface-2: #F4F7FC;
            --surface-3: #EBF0F9;
            --text-primary: #0D1B2A;
            --text-secondary: #5A6B82;
            --text-muted: #8FA0B5;
            --border: #DDE5F0;
            --success: #0DAF7A;
            --warning: #F59E0B;
            --danger: #EF4444;
            --info: #3B82F6;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 16px rgba(0,30,80,0.10);
            --shadow-lg: 0 10px 40px rgba(0,30,80,0.15);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface-2);
            color: var(--text-primary);
            margin: 0;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ─────────────────────────────────────── */
        .sidebar {
            position: fixed;
            left: 0; top: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -60px; left: -60px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(0,102,204,0.25) 0%, transparent 70%);
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 38px; height: 38px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(0,102,204,0.4);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-name {
            color: white;
            font-weight: 800;
            font-size: 15px;
            letter-spacing: 0.05em;
            line-height: 1;
        }

        .brand-sub {
            color: rgba(255,255,255,0.35);
            font-size: 10px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.22);
            padding: 16px 12px 8px;
        }

        .nav-item { margin-bottom: 2px; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
            border: 1px solid transparent;
        }

        .nav-link:hover {
            color: rgba(255,255,255,0.85);
            background: rgba(255,255,255,0.06);
        }

        .nav-link.active {
            background: rgba(0,102,204,0.2);
            color: #5BA8F5;
            border-color: rgba(0,102,204,0.3);
        }

        .nav-link.active .nav-icon {
            color: #5BA8F5;
        }

        .nav-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: rgba(255,255,255,0.4);
            background: none;
            border: 1px solid rgba(255,255,255,0.06);
            width: 100%;
            font-size: 13.5px;
            font-weight: 500;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: rgba(239,68,68,0.12);
            color: #F87171;
            border-color: rgba(239,68,68,0.2);
        }

        /* ── MAIN CONTENT ────────────────────────────────── */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOP NAVBAR ──────────────────────────────────── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .page-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-time {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: var(--text-muted);
            background: var(--surface-2);
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        .admin-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            padding: 6px 14px 6px 8px;
            border-radius: 100px;
        }

        .admin-avatar {
            width: 30px; height: 30px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 700;
        }

        .admin-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ── CONTENT AREA ────────────────────────────────── */
        .content-area {
            flex: 1;
            padding: 28px 32px;
        }

        /* ── CARDS ───────────────────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            background: var(--surface) !important;
            border-bottom: 1px solid var(--border);
            padding: 18px 24px;
            border-radius: var(--radius) var(--radius) 0 0 !important;
        }

        .card-header h5 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .card-body { padding: 24px; }

        /* ── TABLES ──────────────────────────────────────── */
        .table {
            font-size: 13.5px;
            margin: 0;
        }

        .table thead th {
            background: var(--surface-2);
            color: var(--text-secondary);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
            padding: 12px 16px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: var(--text-primary);
        }

        .table tbody tr:last-child td { border-bottom: none; }

        .table-hover tbody tr:hover td {
            background: var(--primary-light);
        }

        /* ── BADGES ──────────────────────────────────────── */
        .badge {
            font-size: 11px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 6px;
            letter-spacing: 0.02em;
        }

        .badge.bg-success { background: rgba(13,175,122,0.12) !important; color: #0DAF7A; border: 1px solid rgba(13,175,122,0.25); }
        .badge.bg-danger  { background: rgba(239,68,68,0.10) !important; color: #EF4444; border: 1px solid rgba(239,68,68,0.22); }
        .badge.bg-warning { background: rgba(245,158,11,0.12) !important; color: #D97706; border: 1px solid rgba(245,158,11,0.25); }
        .badge.bg-info    { background: rgba(59,130,246,0.10) !important; color: #3B82F6; border: 1px solid rgba(59,130,246,0.22); }
        .badge.bg-primary { background: rgba(0,102,204,0.10) !important; color: #0066CC; border: 1px solid rgba(0,102,204,0.22); }
        .badge.bg-secondary { background: var(--surface-3) !important; color: var(--text-secondary); border: 1px solid var(--border); }

        /* ── BUTTONS ─────────────────────────────────────── */
        .btn {
            font-size: 13px;
            font-weight: 600;
            border-radius: var(--radius-sm);
            padding: 9px 18px;
            transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(0,102,204,0.35);
        }

        .btn-secondary {
            background: var(--surface);
            border-color: var(--border);
            color: var(--text-secondary);
        }
        .btn-secondary:hover {
            background: var(--surface-2);
            border-color: var(--text-muted);
            color: var(--text-primary);
        }

        .btn-sm {
            font-size: 12px;
            padding: 5px 11px;
            border-radius: 6px;
        }

        .btn-warning {
            background: rgba(245,158,11,0.1);
            border-color: rgba(245,158,11,0.3);
            color: #B45309;
        }
        .btn-warning:hover {
            background: rgba(245,158,11,0.2);
            border-color: rgba(245,158,11,0.5);
            color: #92400E;
        }

        .btn-danger {
            background: rgba(239,68,68,0.08);
            border-color: rgba(239,68,68,0.25);
            color: #DC2626;
        }
        .btn-danger:hover {
            background: rgba(239,68,68,0.15);
            border-color: rgba(239,68,68,0.45);
            color: #B91C1C;
        }

        .btn-info {
            background: rgba(59,130,246,0.08);
            border-color: rgba(59,130,246,0.25);
            color: #2563EB;
        }
        .btn-info:hover {
            background: rgba(59,130,246,0.15);
            border-color: rgba(59,130,246,0.45);
        }

        /* ── FORMS ───────────────────────────────────────── */
        .form-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 0.02em;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            font-size: 13.5px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 9px 13px;
            color: var(--text-primary);
            background: var(--surface);
            transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0,102,204,0.12);
            outline: none;
        }

        .form-control.bg-light {
            background: var(--surface-2) !important;
            border-color: var(--border);
            color: var(--text-primary);
        }

        .form-control::placeholder { color: var(--text-muted); }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(0,102,204,0.12);
        }

        .form-check-label {
            font-size: 13.5px;
            font-weight: 500;
        }

        /* ── ALERTS ──────────────────────────────────────── */
        .alert {
            border-radius: var(--radius-sm);
            border: none;
            font-size: 13.5px;
            font-weight: 500;
            padding: 14px 18px;
        }

        .alert-success {
            background: rgba(13,175,122,0.10);
            color: #065F46;
            border-left: 3px solid var(--success);
        }

        .alert-danger {
            background: rgba(239,68,68,0.08);
            color: #991B1B;
            border-left: 3px solid var(--danger);
        }

        /* ── PAGINATION ──────────────────────────────────── */
        .pagination { gap: 4px; }

        .page-item .page-link {
            border: 1.5px solid var(--border);
            color: var(--text-secondary);
            border-radius: 8px !important;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 13px;
            transition: all 0.2s;
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            box-shadow: 0 3px 10px rgba(0,102,204,0.3);
        }

        .page-item .page-link:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* ── STAT CARDS ──────────────────────────────────── */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            box-shadow: var(--shadow-sm);
            transition: all 0.25s;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .stat-label {
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        hr { border-color: var(--border); opacity: 1; margin: 28px 0; }

        .text-muted { color: var(--text-muted) !important; }

        small.text-muted { font-size: 11.5px; }

        /* ── SECTION HEADERS IN FORMS ────────────────────── */
        .form-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 20px;
        }

        .form-section-title i {
            width: 28px; height: 28px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        /* ── SCROLLBAR ───────────────────────────────────── */
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        /* ── SCROLL REVEAL ANIMATIONS ────────────────────── */
        .avx-reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s cubic-bezier(0.165, 0.84, 0.44, 1), 
                        transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            will-change: opacity, transform;
        }
        .avx-reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .avx-delay-50 { transition-delay: 50ms; }
        .avx-delay-100 { transition-delay: 100ms; }
        .avx-delay-150 { transition-delay: 150ms; }
        .avx-delay-200 { transition-delay: 200ms; }
        .avx-delay-250 { transition-delay: 250ms; }
        .avx-delay-300 { transition-delay: 300ms; }
        .avx-delay-350 { transition-delay: 350ms; }
        .avx-delay-400 { transition-delay: 400ms; }
        .avx-delay-500 { transition-delay: 500ms; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand-logo">
                <div class="brand-icon">
                    <i class="bi bi-airplane-fill"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-name">AVOINEX</span>
                    <span class="brand-sub">Admin Portal</span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <i class="bi bi-speedometer2 nav-icon"></i>
                    Dashboard
                </a>
            </div>

            <div class="nav-section-label">Fleet & Operations</div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.aircraft.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.aircraft.*') ? 'active' : ''); ?>">
                    <i class="bi bi-airplane nav-icon"></i>
                    Aircraft
                </a>
            </div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.schedules.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.schedules.*') ? 'active' : ''); ?>">
                    <i class="bi bi-calendar3 nav-icon"></i>
                    Schedules
                </a>
            </div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.flights.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.flights.*') ? 'active' : ''); ?>">
                    <i class="bi bi-airplane-engines nav-icon"></i>
                    Flight Instances
                </a>
            </div>

            <div class="nav-section-label">Revenue</div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.bookings.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.bookings.index') || request()->routeIs('admin.bookings.show') ? 'active' : ''); ?>">
                    <i class="bi bi-ticket-perforated nav-icon"></i>
                    Bookings
                </a>
            </div>

            <div class="nav-item">
                <?php $refundBadgeCount = \App\Models\Booking::where('booking_status', 'refund_requested')->count(); ?>
                <a href="<?php echo e(route('admin.bookings.refunds')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.bookings.refunds') ? 'active' : ''); ?>">
                    <i class="bi bi-arrow-counterclockwise nav-icon"></i>
                    Refund Requests
                    <?php if($refundBadgeCount > 0): ?>
                        <span class="badge bg-danger ms-auto" style="font-size: 10px;"><?php echo e($refundBadgeCount); ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.flash_sales.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.flash_sales.*') ? 'active' : ''); ?>">
                    <i class="bi bi-lightning-charge-fill text-warning nav-icon"></i>
                    Flash Sales
                </a>
            </div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.featured_destinations.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.featured_destinations.*') ? 'active' : ''); ?>">
                    <i class="bi bi-star-fill text-primary nav-icon"></i>
                    Destinasi Populer
                </a>
            </div>

            <div class="nav-section-label">Master Data</div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.airports.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.airports.*') ? 'active' : ''); ?>">
                    <i class="bi bi-geo-alt nav-icon"></i>
                    Airports
                </a>
            </div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.manufacturers.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.manufacturers.*') ? 'active' : ''); ?>">
                    <i class="bi bi-building nav-icon"></i>
                    Manufacturers
                </a>
            </div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.countries.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.countries.*') ? 'active' : ''); ?>">
                    <i class="bi bi-globe-americas nav-icon"></i>
                    Countries
                </a>
            </div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.airlines.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.airlines.*') ? 'active' : ''); ?>">
                    <i class="bi bi-briefcase nav-icon"></i>
                    Airlines
                </a>
            </div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.meals.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.meals.*') ? 'active' : ''); ?>">
                    <i class="bi bi-cup-hot nav-icon"></i>
                    In-Flight Meals
                </a>
            </div>

            <div class="nav-section-label">Support</div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.help')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.help*') ? 'active' : ''); ?>">
                    <i class="bi bi-question-circle nav-icon"></i>
                    Help / Guide
                </a>
            </div>

            <div class="nav-item">
                <a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>">
                    <i class="bi bi-gear nav-icon"></i>
                    Settings
                </a>
            </div>

            <div class="sidebar-footer">
            <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <h1 class="page-title"><?php echo $__env->yieldContent('page-title', 'Admin Panel'); ?></h1>
            </div>
            <div class="topbar-right">
                <div class="topbar-time" id="liveClock">--:-- UTC</div>
                <div class="admin-pill">
                    <div class="admin-avatar">A</div>
                    <span class="admin-name"><?php echo e(session('admin_name', 'Admin')); ?></span>
                </div>
            </div>
        </header>

        <div class="content-area avx-reveal">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateClock() {
            const now = new Date();
            const h = String(now.getUTCHours()).padStart(2,'0');
            const m = String(now.getUTCMinutes()).padStart(2,'0');
            const s = String(now.getUTCSeconds()).padStart(2,'0');
            const el = document.getElementById('liveClock');
            if (el) el.textContent = `${h}:${m}:${s} UTC`;
        }
        updateClock();
        setInterval(updateClock, 1000);

        // ===== INTERSECTION OBSERVER FOR SCROLL REVEAL =====
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -50px 0px',
                threshold: 0.1
            };
            
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const revealElements = document.querySelectorAll('.avx-reveal');
            revealElements.forEach(el => observer.observe(el));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, form, message) {
            event.preventDefault();
            
            let timeLeft = 5;
            let timerInterval;
            
            Swal.fire({
                title: 'Are you sure you want to delete?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#5A6B82',
                confirmButtonText: `Wait (${timeLeft}s)`,
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    if (timeLeft > 0) {
                        return false;
                    }
                    return true;
                },
                didOpen: () => {
                    const b = Swal.getConfirmButton();
                    b.disabled = true;
                    b.style.opacity = '0.5';
                    b.style.cursor = 'not-allowed';
                    
                    timerInterval = setInterval(() => {
                        timeLeft -= 1;
                        if (timeLeft > 0) {
                            b.textContent = `Wait (${timeLeft}s)`;
                        } else {
                            clearInterval(timerInterval);
                            b.disabled = false;
                            b.style.opacity = '1';
                            b.style.cursor = 'pointer';
                            b.textContent = 'Yes, delete';
                        }
                    }, 1000);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rupiahInputs = document.querySelectorAll('.rupiah-input');
            
            rupiahInputs.forEach(input => {
                if (input.value) {
                    input.value = formatRupiah(input.value);
                }
                
                input.addEventListener('input', function(e) {
                    this.value = formatRupiah(this.value);
                });
            });
            
            function formatRupiah(angka) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                
                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }
            
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    rupiahInputs.forEach(input => {
                        input.value = input.value.replace(/\./g, '');
                    });
                });
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>