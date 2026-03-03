<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Avoinex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: #1a1d29;
            color: white;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #b8bec9;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #272b3a;
            color: #fff;
            border-left-color: #279ED6;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background: #f5f6fa;
        }
        .top-navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            padding: 15px 30px;
            margin-bottom: 30px;
        }
        .admin-logo {
            font-size: 24px;
            font-weight: 700;
            color: #279ED6;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #272b3a;
            margin-bottom: 10px;
        }
        .content-area {
            padding: 0 30px 30px;
        }
        .card {
            border: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            border-radius: 8px;
        }
        .btn-primary {
            background: #279ED6;
            border-color: #279ED6;
        }
        .btn-primary:hover {
            background: #1e8bc8;
            border-color: #1e8bc8;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="admin-logo">
            <i class="bi bi-shield-lock"></i> AVOINEX ADMIN
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.aircraft.index') }}" class="nav-link {{ request()->routeIs('admin.aircraft.*') ? 'active' : '' }}">
                <i class="bi bi-airplane"></i> Aircraft
            </a>
            <a href="{{ route('admin.schedules.index') }}" class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Schedules
            </a>
            <a href="{{ route('admin.flights.index') }}" class="nav-link {{ request()->routeIs('admin.flights.*') ? 'active' : '' }}">
                <i class="bi bi-airplane-engines"></i> Flights
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="bi bi-ticket-perforated"></i> Bookings
            </a>
            <hr style="border-color: #272b3a; margin: 10px 20px;">
            <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent" style="cursor: pointer;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">@yield('page-title', 'Admin Panel')</h5>
                <div>
                    <span class="text-muted"><i class="bi bi-person-circle"></i> {{ session('admin_name') }}</span>
                </div>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
