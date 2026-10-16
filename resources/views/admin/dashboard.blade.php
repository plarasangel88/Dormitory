<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dorm Portal - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy-deep: #16213E;
            --navy-mid: #24345C;
            --navy-soft: #3A4E7A;
            --amber: #F0A857;
            --amber-soft: #F6C98B;
            --paper: #FBF8F2;
            --ink: #2A2620;
            --slate: #8993A8;

            --bg-main: var(--paper);
            --sidebar-bg: var(--navy-deep);
            --card-bg: #FFFFFF;
            --text-primary: var(--ink);
            --text-secondary: var(--slate);
            --border-color: #E3DFD5;

            --primary-blue: var(--navy-soft);
            --primary-hover: var(--navy-mid);
            --success-green: #4E9A6B;
            --warning-orange: var(--amber);
            --danger-red: #C4573E;
            --purple-accent: #7C6FA6;
            --teal-accent: #3E8E8A;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        body { background-color: var(--bg-main); color: var(--text-primary); overflow-x: hidden; }

        .app-container { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1B2A4D 0%, #16213E 55%, #101A33 100%);
            color: #FFF;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            flex-shrink: 0;
            transition: transform 0.25s ease;
        }

        .sidebar-brand {
            display: flex; align-items: center; gap: 12px;
            font-family: 'Fraunces', serif; font-weight: 500; font-size: 1.25rem;
            margin-bottom: 32px; padding-left: 8px; color: var(--amber);
            text-decoration: none;
        }

        .sidebar-menu { display: flex; flex-direction: column; gap: 8px; flex-grow: 1; }

        .menu-item {
            display: flex; align-items: center; gap: 12px;
            color: #B7C0D6; text-decoration: none;
            padding: 12px 16px; border-radius: 8px;
            font-weight: 500; font-size: 0.92rem; transition: all 0.2s ease;
        }

        .menu-item:hover, .menu-item.active { background-color: rgba(240, 168, 87, 0.14); color: #FFF; }
        .menu-item.active { box-shadow: inset 3px 0 0 var(--amber); }

        .sidebar-footer { padding-top: 16px; border-top: 1px solid #334155; }

        .logout-btn {
            width: 100%; padding: 10px; background: transparent;
            border: 1px solid #334155; color: #94A3B8; border-radius: 8px;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            gap: 8px; font-weight: 600; transition: 0.2s;
        }

        .logout-btn:hover { color: #FFF; background-color: var(--danger-red); border-color: var(--danger-red); }

        /* Main */
        .main-content { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        .top-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 16px 32px; background-color: #FFF; border-bottom: 1px solid var(--border-color);
            gap: 16px;
        }

        .menu-toggle {
            display: none; background: none; border: 1px solid var(--border-color);
            border-radius: 8px; width: 40px; height: 40px; cursor: pointer;
            color: var(--navy-deep); font-size: 1rem;
        }

        .search-bar {
            display: flex; align-items: center; gap: 10px;
            background-color: var(--paper); border: 1px solid var(--border-color);
            padding: 10px 16px; border-radius: 20px; width: 360px; max-width: 100%;
            color: var(--text-secondary);
        }

        .search-bar:focus-within { border-color: var(--amber); box-shadow: 0 0 0 3px rgba(240,168,87,0.18); }

        .search-bar input { border: none; background: transparent; outline: none; width: 100%; font-size: 0.9rem; color: var(--text-primary); }
        .search-bar input::placeholder { color: #B7B2A6; }

        .search-bar button {
            background: none; border: none; color: inherit; cursor: pointer; font-size: 0.9rem;
        }

        .search-bar button:hover { color: var(--navy-deep); }

        .admin-profile-badge { display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit; }
        a.admin-profile-badge:hover .user-name { color: var(--navy-soft); }

        .avatar {
            width: 40px; height: 40px; background-color: var(--navy-deep); color: var(--amber);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-family: 'Fraunces', serif;
        }

        .user-info { display: flex; flex-direction: column; }
        .user-name { font-size: 0.9rem; font-weight: 600; color: var(--text-primary); }
        .user-role { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.4px; color: var(--text-secondary); }

        .dashboard-body { padding: 32px; overflow-y: auto; }

        .welcome-banner h1 { font-family: 'Fraunces', serif; font-weight: 500; font-size: 1.8rem; color: var(--text-primary); }
        .welcome-banner p { color: var(--text-secondary); margin-top: 4px; margin-bottom: 24px; font-size: 0.92rem; }

        /* Metrics */
        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }

        .metric-card {
            background: var(--card-bg); padding: 20px; border-radius: 12px;
            border: 1px solid var(--border-color); display: flex; align-items: center; gap: 16px;
            box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        a.metric-card {
            text-decoration: none; color: inherit; cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
        }

        a.metric-card:hover, a.metric-card:focus-visible {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -10px rgba(22, 33, 62, 0.25);
            border-color: var(--amber-soft); outline: none;
        }

        .metric-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
        .metric-icon.blue { background-color: #EAEEF7; color: var(--primary-blue); }
        .metric-icon.orange { background-color: #FBEBD4; color: var(--warning-orange); }
        .metric-icon.green { background-color: #E1EFE6; color: var(--success-green); }
        .metric-icon.purple { background-color: #EBE7F4; color: var(--purple-accent); }
        .metric-icon.red { background-color: #F6E2DD; color: var(--danger-red); }
        .metric-icon.teal { background-color: #DFEEED; color: var(--teal-accent); }

        .metric-title { font-size: 0.68rem; font-weight: 700; color: var(--text-secondary); letter-spacing: 0.6px; }
        .metric-value { font-family: 'Fraunces', serif; font-size: 1.4rem; font-weight: 600; color: var(--text-primary); margin-top: 4px; }
        .metric-value small { font-family: 'Inter', sans-serif; font-size: 0.75rem; font-weight: normal; color: var(--text-secondary); }

        .dashboard-main-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 24px; }

        .card-panel {
            background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 12px; padding: 20px; box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        .margin-top { margin-top: 24px; }

        .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; gap: 8px; flex-wrap: wrap; }

        .card-panel h3 { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 8px; }
        .card-panel h3 i { color: var(--amber); }

        /* Quick Actions */
        .quick-actions-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 12px; }

        .action-btn {
            padding: 12px 16px; background-color: var(--paper);
            border: 1.5px solid var(--border-color); border-radius: 8px;
            font-size: 0.85rem; font-weight: 600; color: var(--text-primary);
            cursor: pointer; display: flex; align-items: center; gap: 8px;
            transition: all 0.2s ease; text-decoration: none;
        }

        .action-btn:hover { background-color: var(--navy-deep); color: #FFF; border-color: var(--navy-deep); }
        .action-btn:hover i { color: var(--amber); }

        /* Live badge */
        .live-badge {
            background-color: #E1EFE6; color: var(--success-green);
            padding: 4px 10px; border-radius: 12px; font-size: 0.68rem; font-weight: 700;
            letter-spacing: 0.3px; border: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
        }

        .live-badge .dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; animation: pulse 1.6s infinite; }
        .live-badge.paused { background-color: #EFEBE0; color: var(--text-secondary); }
        .live-badge.paused .dot { animation: none; }

        @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.3; } }
        .spin { animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Announcements / feed list */
        .activity-feed { list-style: none; display: flex; flex-direction: column; gap: 4px; margin-top: 8px; }

        .feed-item { display: flex; gap: 12px; align-items: flex-start; padding: 8px; border-radius: 8px; }

        .feed-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; flex-shrink: 0; }
        .feed-icon.green { background-color: #E1EFE6; color: var(--success-green); }
        .feed-icon.orange { background-color: #FBEBD4; color: var(--warning-orange); }
        .feed-icon.blue { background-color: #EAEEF7; color: var(--primary-blue); }

        .feed-content p { font-size: 0.85rem; color: var(--text-primary); line-height: 1.3; }
        .feed-content small { font-size: 0.75rem; color: var(--text-secondary); }

        .announce-form {
            display: flex; flex-direction: column; gap: 8px;
            margin-bottom: 12px; padding-bottom: 14px; border-bottom: 1px solid var(--border-color);
        }

        .announce-form input[type="text"], .announce-form textarea {
            width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 8px;
            font-size: 0.85rem; background: var(--paper); outline: none; resize: vertical; color: var(--text-primary);
        }

        .announce-form input[type="text"]:focus, .announce-form textarea:focus { border-color: var(--amber); background: #FFF; }
        .announce-form textarea { min-height: 80px; }

        .announce-row { display: flex; justify-content: space-between; align-items: center; gap: 8px; flex-wrap: wrap; }
        .pin-check { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; color: var(--text-secondary); cursor: pointer; }

        .post-btn {
            padding: 8px 16px; background: var(--amber); color: var(--navy-deep); border: none;
            border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .post-btn:hover { background: var(--amber-soft); }
        .post-btn:disabled { opacity: 0.6; cursor: wait; }

        .announce-item { border-bottom: 1px solid var(--border-color); padding: 12px 8px; }
        .announce-item:last-child { border-bottom: none; }
        .announce-item .feed-content { flex: 1; min-width: 0; }
        .announce-item .feed-content p { word-break: break-word; }
        .announce-item .feed-content p + p { margin-top: 4px; color: #4A4439; line-height: 1.5; }
        .announce-item small { display: block; margin-top: 6px; }
        .announce-item .table-btn { margin-left: auto; flex-shrink: 0; }

        /* Payment table */
        .view-all-link { font-size: 0.8rem; color: var(--navy-deep); text-decoration: none; font-weight: 600; border-bottom: 1.5px solid var(--amber); padding-bottom: 1px; }

        .filter-tabs { display: flex; gap: 6px; margin-bottom: 8px; flex-wrap: wrap; }

        .filter-tab {
            padding: 5px 12px; border: 1px solid var(--border-color); background: var(--paper);
            border-radius: 14px; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); cursor: pointer;
        }

        .filter-tab:hover { border-color: var(--amber-soft); color: var(--text-primary); }
        .filter-tab.active { background: var(--navy-deep); color: #FFF; border-color: var(--navy-deep); }

        .table-responsive { overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 8px; }

        .data-table th, .data-table td { padding: 12px 8px; text-align: left; border-bottom: 1px solid var(--border-color); font-size: 0.85rem; }

        .data-table th { color: var(--text-secondary); font-weight: 700; font-size: 0.7rem; letter-spacing: 0.4px; text-transform: uppercase; }

        .data-table tbody tr[data-href] { cursor: pointer; transition: background-color 0.15s ease; }
        .data-table tbody tr[data-href]:hover, .data-table tbody tr[data-href]:focus-visible { background-color: var(--paper); outline: none; }

        .status-pill { padding: 4px 10px; border-radius: 12px; font-size: 0.68rem; font-weight: 700; display: inline-block; }
        .status-pill.pending { background-color: #FBEBD4; color: #A9721F; }
        .status-pill.paid { background-color: #E1EFE6; color: #327049; }
        .status-pill.unpaid { background-color: #F6E2DD; color: #A8412B; }

        .table-btn {
            padding: 6px 12px; border: none; background-color: var(--navy-deep); color: #FFF;
            border-radius: 6px; font-size: 0.75rem; font-weight: 600; cursor: pointer;
            display: inline-flex; align-items: center; gap: 4px; text-decoration: none;
        }

        .table-btn.secondary { background-color: var(--paper); color: var(--text-primary); border: 1px solid var(--border-color); }
        .table-btn:hover { background-color: var(--navy-mid); color: #FFF; }
        .table-btn.secondary:hover { background-color: #F0ECE2; color: var(--text-primary); }
        .table-btn:disabled { opacity: 0.6; cursor: wait; }

        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(22, 33, 62, 0.55);
            display: none; align-items: center; justify-content: center; z-index: 1000; padding: 16px;
        }

        .modal-card {
            background: var(--paper); padding: 28px; border-radius: 16px; width: 100%; max-width: 420px;
            text-align: center; border: 1px solid var(--border-color); box-shadow: 0 30px 70px -28px rgba(0,0,0,0.5);
        }

        .modal-card h3 { font-family: 'Fraunces', serif; font-weight: 500; font-size: 1.2rem; margin-bottom: 10px; color: var(--text-primary); justify-content: center; }
        .modal-card p { font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5; }

        #qrReader { width: 100%; max-width: 280px; min-height: 200px; margin: 16px auto 8px; border-radius: 10px; overflow: hidden; background: #FFF; border: 2px dashed var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--slate); font-size: 3rem; }
        #qrReader video { border-radius: 8px; }

        .scan-status { font-size: 0.8rem; min-height: 1.2em; margin-bottom: 8px; color: var(--text-secondary); }
        .scan-status.error { color: var(--danger-red); }
        .scan-status.ok { color: var(--success-green); }

        .manual-entry { display: flex; gap: 8px; margin-top: 8px; }
        .manual-entry input { flex: 1; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.85rem; background: #FFF; outline: none; }
        .manual-entry input:focus { border-color: var(--amber); }
        .manual-entry button { padding: 10px 14px; background: var(--amber); color: var(--navy-deep); border: none; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; }
        .manual-entry button:hover { background: var(--amber-soft); }

        .close-modal-btn { padding: 10px 20px; background-color: var(--navy-deep); color: var(--paper); border: none; border-radius: 8px; cursor: pointer; margin-top: 16px; font-weight: 600; font-size: 0.85rem; }
        .close-modal-btn:hover { background-color: var(--navy-mid); }

        /* Toasts */
        .toast-stack { position: fixed; bottom: 20px; right: 20px; display: flex; flex-direction: column; gap: 10px; z-index: 2000; }
        .toast {
            background: var(--navy-deep); color: #FFF; padding: 12px 16px; border-radius: 10px;
            font-size: 0.85rem; box-shadow: 0 12px 30px -12px rgba(0,0,0,0.5);
            display: flex; align-items: center; gap: 10px; border-left: 4px solid var(--amber);
            animation: toastIn 0.2s ease;
        }
        .toast.success { border-left-color: var(--success-green); }
        .toast.error { border-left-color: var(--danger-red); }
        @keyframes toastIn { from { transform: translateY(8px); opacity: 0; } to { transform: none; opacity: 1; } }

        .sidebar-backdrop { display: none; }

        @media (max-width: 1024px) {
            .dashboard-main-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 820px) {
            .menu-toggle { display: inline-block; }
            .sidebar { position: fixed; top: 0; bottom: 0; left: 0; z-index: 900; transform: translateX(-100%); }
            body.sidebar-open .sidebar { transform: none; }
            body.sidebar-open .sidebar-backdrop { display: block; position: fixed; inset: 0; background: rgba(22,33,62,0.5); z-index: 800; }
            .top-header { padding: 12px 16px; }
            .dashboard-body { padding: 20px 16px; }
            .user-info { display: none; }
        }
    </style>
</head>
<body>
    @php
        // Safe route helper: falls back to the index page if a named route isn't defined yet.
        $studentCreate = Route::has('admin.students.create') ? route('admin.students.create') : route('admin.students.index');
        $roomAssign    = Route::has('admin.rooms.assign')    ? route('admin.rooms.assign')    : route('admin.rooms.index');
        $profileUrl    = Route::has('admin.profile.edit') ? route('admin.profile.edit') : (Route::has('profile.edit') ? route('profile.edit') : null);
    @endphp

    <div class="app-container">
        <div class="sidebar-backdrop" data-action="toggle-sidebar"></div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="fa-solid fa-building-user"></i>
                <span>Dorm Portal</span>
            </a>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                <a href="{{ route('admin.students.index') }}" class="menu-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate"></i> Students
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="menu-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-door-closed"></i> Rooms
                </a>
                <a href="{{ route('admin.payments.index', ['section' => 'billing']) }}" class="menu-item {{ request()->routeIs('admin.payments.*', 'admin.bills.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Payments & Billing
                </a>
                <a href="{{ route('admin.payments.index') }}" class="menu-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wallet"></i> Payments
                </a>
                <a href="{{ route('admin.maintenance.index') }}" class="menu-item {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wrench"></i> Maintenance
                </a>
            </nav>
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <main class="main-content">
            <header class="top-header">
                <button class="menu-toggle" type="button" data-action="toggle-sidebar" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <!-- Search: filters the payment table live; Enter searches the Students page -->
                <form class="search-bar" method="GET" action="{{ route('admin.students.index') }}" role="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" id="globalSearch" placeholder="Search student name, room #, or ID..." autocomplete="off">
                    <button type="submit" aria-label="Search"><i class="fa-solid fa-arrow-right"></i></button>
                </form>

                @if ($profileUrl)
                    <a href="{{ $profileUrl }}" class="admin-profile-badge" title="My profile">
                @else
                    <div class="admin-profile-badge">
                @endif
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">ADMIN</span>
                    </div>
                @if ($profileUrl)
                    </a>
                @else
                    </div>
                @endif
            </header>

            <div class="dashboard-body">
                <div class="welcome-banner">
                    <h1>Welcome, {{ auth()->user()->name }}!</h1>
                    <p>Here's an overview of the dormitory system status today.</p>
                </div>

                <!-- Metrics -->
                <section class="metrics-grid" id="metricsGrid">
                    <a href="{{ route('admin.students.index') }}" class="metric-card">
                        <div class="metric-icon blue"><i class="fa-solid fa-users"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">TOTAL STUDENTS</span>
                            <div class="metric-value">{{ $totalStudents ?? 0 }}</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="metric-card">
                        <div class="metric-icon orange"><i class="fa-solid fa-bed"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">TOTAL ROOMS</span>
                            <div class="metric-value">{{ $totalRooms ?? 0 }}</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.rooms.index') }}?status=occupied" class="metric-card">
                        <div class="metric-icon green"><i class="fa-solid fa-chart-pie"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">OCCUPANCY RATE</span>
                            <div class="metric-value">{{ $occupancyRate ?? 0 }}% <small>({{ $occupiedRooms ?? 0 }} Occupied)</small></div>
                        </div>
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="metric-card">
                        <div class="metric-icon purple"><i class="fa-solid fa-calendar-check"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">MONTHLY BOOKINGS</span>
                            <div class="metric-value">{{ $monthlyBookings ?? 0 }}</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="metric-card">
                        <div class="metric-icon red"><i class="fa-solid fa-clock"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">PENDING PAYMENTS</span>
                            <div class="metric-value">{{ $pendingPayments ?? 0 }}</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.payments.index', ['status' => 'paid']) }}" class="metric-card">
                        <div class="metric-icon teal"><i class="fa-solid fa-peso-sign"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">TOTAL COLLECTED</span>
                            <div class="metric-value">₱{{ number_format($totalCollected ?? 0, 2) }}</div>
                        </div>
                    </a>
                </section>

                <section class="dashboard-main-grid">
                    <!-- Left -->
                    <div class="left-column">
                        <div class="card-panel">
                            <h3><i class="fa-solid fa-bolt"></i> Quick Actions</h3>
                            <div class="quick-actions-grid">
                                <a href="{{ $studentCreate }}" class="action-btn">
                                    <i class="fa-solid fa-user-plus"></i> Add Student
                                </a>
                                <a href="{{ $roomAssign }}" class="action-btn">
                                    <i class="fa-solid fa-door-open"></i> Assign Room
                                </a>
                                <a href="{{ route('admin.payments.index') }}" class="action-btn">
                                    <i class="fa-solid fa-wallet"></i> Manage Payments
                                </a>
                                <a href="{{ route('admin.payments.index', ['section' => 'billing']) }}" class="action-btn">
                                    <i class="fa-solid fa-file-invoice"></i> Manage Billing
                                </a>
                            </div>
                        </div>

                        <!-- Announcements (admin posts, students see on their dashboard) -->
                        <div class="card-panel margin-top">
                            <div class="panel-header">
                                <h3><i class="fa-solid fa-bullhorn"></i> Announcements</h3>
                                <button type="button" class="live-badge" id="liveBadge" data-action="toggle-live" title="Click to pause / resume auto-refresh">
                                    <span class="dot"></span> <span id="liveLabel">Live Updates</span>
                                </button>
                            </div>

                            <form class="announce-form" id="announceForm">
                                <input type="text" name="title" placeholder="Announcement title" maxlength="150" required>
                                <textarea name="body" placeholder="Write your message to the students..." maxlength="2000" required></textarea>
                                <div class="announce-row">
                                    <label class="pin-check">
                                        <input type="checkbox" name="is_pinned" value="1"> Pin to top
                                    </label>
                                    <button type="submit" class="post-btn">
                                        <i class="fa-solid fa-paper-plane"></i> Post
                                    </button>
                                </div>
                            </form>

                            <ul class="activity-feed" id="activityFeed">
                                @forelse ($announcements ?? [] as $a)
                                    <li class="feed-item announce-item">
                                        <span class="feed-icon {{ $a->is_pinned ? 'orange' : 'blue' }}">
                                            <i class="fa-solid {{ $a->is_pinned ? 'fa-thumbtack' : 'fa-bullhorn' }}"></i>
                                        </span>
                                        <div class="feed-content">
                                            <p><strong>{{ $a->title }}</strong></p>
                                            <p>{!! nl2br(e($a->body)) !!}</p>
                                            <small>{{ $a->author->name ?? 'Admin' }} · {{ $a->created_at->diffForHumans() }}</small>
                                        </div>
                                        <button type="button" class="table-btn secondary" data-action="delete-announcement" data-id="{{ $a->id }}" title="Delete announcement">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </li>
                                @empty
                                    <li class="feed-item">
                                        <div class="feed-content"><p>No announcements yet.</p></div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Right -->
                    <div class="right-column">
                        <div class="card-panel">
                            <div class="panel-header">
                                <h3><i class="fa-solid fa-file-invoice-dollar"></i> Student Payment Monitoring</h3>
                                <a href="{{ route('admin.payments.index') }}" class="view-all-link">View All Records</a>
                            </div>

                            <div class="filter-tabs" id="statusFilters">
                                <button type="button" class="filter-tab active" data-filter="all">All</button>
                                <button type="button" class="filter-tab" data-filter="pending">Pending</button>
                                <button type="button" class="filter-tab" data-filter="paid">Paid</button>
                                <button type="button" class="filter-tab" data-filter="unpaid">Unpaid</button>
                            </div>

                            <div class="table-responsive">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Room</th>
                                            <th>Payment Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="paymentBody">
                                        @forelse ($paymentMonitoring ?? [] as $payment)
                                            @php $status = strtolower($payment->status); @endphp
                                            <tr data-status="{{ $status }}">
                                                <td><strong>{{ $payment->student_name }}</strong></td>
                                                <td>{{ $payment->room_number ?? 'Unassigned' }}</td>
                                                <td>₱{{ number_format($payment->amount_due, 2) }}</td>
                                                <td><span class="status-pill {{ $status }}">{{ ucfirst($payment->status) }}</span></td>
                                                <td>
                                                    <a class="table-btn" href="{{ route('admin.payments.index') }}">
                                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Open
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="empty-row">
                                                <td colspan="5" style="text-align:center; color: var(--text-secondary);">No payment records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <p id="noMatch" style="display:none; text-align:center; color: var(--text-secondary); font-size:0.85rem; padding:16px 0;">No matching records.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Payment Code Scanner Modal -->
    <div class="modal-overlay" id="scannerModal" role="dialog" aria-modal="true" aria-labelledby="scannerTitle">
        <div class="modal-card">
            <h3 id="scannerTitle"><i class="fa-solid fa-qrcode"></i> Payment Code Scanner</h3>
            <p>Place the student's Payment QR or Barcode in front of the camera to confirm the cash payment.</p>
            <div id="qrReader"><i class="fa-solid fa-barcode"></i></div>
            <div class="scan-status" id="scanStatus"></div>
            <form class="manual-entry" id="manualForm">
                <input type="text" id="manualCode" placeholder="Or type the payment code" autocomplete="off">
                <button type="submit">Confirm</button>
            </form>
            <button class="close-modal-btn" type="button" data-action="close-scanner">Close Scanner</button>
        </div>
    </div>

    <div class="toast-stack" id="toasts" aria-live="polite"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <script>
    (function () {
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const $ = (s, r = document) => r.querySelector(s);
        const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));

        /* ---------- Toasts ---------- */
        function toast(msg, type = 'info') {
            const el = document.createElement('div');
            el.className = 'toast ' + type;
            el.textContent = msg;
            $('#toasts').appendChild(el);
            setTimeout(() => el.remove(), 3500);
        }

        async function post(url, body = {}) {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(body)
            });
            let data = {};
            try { data = await res.json(); } catch (e) {}
            if (!res.ok) {
                // Show the first validation error if there is one
                const firstError = data.errors ? Object.values(data.errors)[0][0] : null;
                throw new Error(firstError || data.message || 'Request failed (' + res.status + ')');
            }
            return data;
        }

        /* ---------- Scanner ---------- */
        let scanner = null, activePaymentId = null, handling = false;
        const modal = $('#scannerModal'), statusEl = $('#scanStatus');

        function setStatus(msg, cls = '') { statusEl.textContent = msg; statusEl.className = 'scan-status ' + cls; }

        async function openScanner(paymentId) {
            activePaymentId = paymentId || null;
            handling = false;
            modal.style.display = 'flex';
            setStatus(activePaymentId ? 'Scanning for the selected payment…' : 'Scanning…');
            $('#manualCode').value = '';

            if (typeof Html5Qrcode === 'undefined' || !navigator.mediaDevices) {
                setStatus('Camera not available. Enter the code manually.', 'error');
                return;
            }
            try {
                scanner = new Html5Qrcode('qrReader');
                await scanner.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: { width: 220, height: 220 } },
                    code => confirmCode(code)
                );
            } catch (err) {
                scanner = null;
                setStatus('Could not open camera. Enter the code manually.', 'error');
            }
        }

        async function stopScanner() {
            if (scanner) {
                try { await scanner.stop(); scanner.clear(); } catch (e) {}
                scanner = null;
            }
        }

        async function closeScanner() {
            modal.style.display = 'none';
            await stopScanner();
            $('#qrReader').innerHTML = '<i class="fa-solid fa-barcode"></i>';
        }

        async function confirmCode(code) {
            code = (code || '').trim();
            if (!code || handling) return;
            handling = true;
            setStatus('Checking code…');
            try {
                const data = await post('/admin/payments/scan', { code, payment_id: activePaymentId });
                setStatus(data.message || 'Payment confirmed.', 'ok');
                toast(data.message || 'Payment confirmed.', 'success');
                await closeScanner();
                refreshDashboard();
            } catch (err) {
                setStatus(err.message, 'error');
                setTimeout(() => { handling = false; }, 1500); // allow retry
            }
        }

        $('#manualForm').addEventListener('submit', e => { e.preventDefault(); confirmCode($('#manualCode').value); });
        modal.addEventListener('click', e => { if (e.target === modal) closeScanner(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeScanner(); document.body.classList.remove('sidebar-open'); } });

        /* ---------- Reminders ---------- */
        async function sendReminder(btn) {
            const original = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner spin"></i> Sending';
            try {
                const data = await post('/admin/payments/' + btn.dataset.id + '/remind');
                toast(data.message || 'Reminder sent.', 'success');
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Sent';
            } catch (err) {
                toast(err.message, 'error');
                btn.innerHTML = original;
                btn.disabled = false;
            }
        }

        /* ---------- Announcements ---------- */
        $('#announceForm').addEventListener('submit', async e => {
            e.preventDefault();
            const form = e.target;
            const btn = $('.post-btn', form);
            btn.disabled = true;
            try {
                const data = await post('{{ route('admin.announcements.store') }}', {
                    title: form.title.value.trim(),
                    body: form.body.value.trim(),
                    is_pinned: form.is_pinned.checked ? 1 : 0
                });
                toast(data.message || 'Announcement posted.', 'success');
                form.reset();
                refreshDashboard();
            } catch (err) {
                toast(err.message, 'error');
            } finally {
                btn.disabled = false;
            }
        });

        async function deleteAnnouncement(btn) {
            if (!confirm('Delete this announcement? Students will no longer see it.')) return;
            btn.disabled = true;
            try {
                const deleteUrl = @json(route('admin.announcements.destroy', ['announcement' => '__ANNOUNCEMENT_ID__']));
                const data = await post(deleteUrl.replace('__ANNOUNCEMENT_ID__', encodeURIComponent(btn.dataset.id)));
                toast(data.message || 'Announcement deleted.', 'success');
                refreshDashboard();
            } catch (err) {
                toast(err.message, 'error');
                btn.disabled = false;
            }
        }

        /* ---------- Filters + live search for payment table ---------- */
        let statusFilter = 'all';

        function applyFilters() {
            const q = ($('#globalSearch').value || '').toLowerCase().trim();
            let shown = 0;
            const rows = $$('#paymentBody tr[data-status]');
            rows.forEach(r => {
                const okStatus = statusFilter === 'all' || r.dataset.status === statusFilter;
                const okText = !q || r.textContent.toLowerCase().includes(q);
                r.style.display = okStatus && okText ? '' : 'none';
                if (okStatus && okText) shown++;
            });
            $('#noMatch').style.display = rows.length && !shown ? 'block' : 'none';
        }

        $('#globalSearch').addEventListener('input', applyFilters);
        $('#statusFilters').addEventListener('click', e => {
            const tab = e.target.closest('.filter-tab');
            if (!tab) return;
            $$('.filter-tab').forEach(t => t.classList.toggle('active', t === tab));
            statusFilter = tab.dataset.filter;
            applyFilters();
        });

        /* ---------- Live refresh (no extra endpoint needed) ---------- */
        let live = true, timer = null, refreshing = false;

        async function refreshDashboard(manual) {
            if (refreshing) return;
            refreshing = true;
            try {
                const res = await fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' });
                if (!res.ok) throw new Error();
                const doc = new DOMParser().parseFromString(await res.text(), 'text/html');
                ['#metricsGrid', '#activityFeed', '#paymentBody'].forEach(sel => {
                    const fresh = $(sel, doc), cur = $(sel);
                    if (fresh && cur) cur.innerHTML = fresh.innerHTML;
                });
                applyFilters();
                if (manual) toast('Dashboard updated.', 'success');
            } catch (e) {
                if (manual) toast('Could not refresh. Check your connection.', 'error');
            } finally { refreshing = false; }
        }

        function startLive() { clearInterval(timer); timer = setInterval(() => { if (!document.hidden) refreshDashboard(); }, 30000); }

        function toggleLive() {
            live = !live;
            $('#liveBadge').classList.toggle('paused', !live);
            $('#liveLabel').textContent = live ? 'Live Updates' : 'Paused';
            if (live) { startLive(); refreshDashboard(true); } else { clearInterval(timer); toast('Auto-refresh paused.'); }
        }

        startLive();

        /* ---------- Delegated clicks ---------- */
        document.addEventListener('click', e => {
            const actionEl = e.target.closest('[data-action]');
            if (actionEl) {
                switch (actionEl.dataset.action) {
                    case 'scan': openScanner(actionEl.dataset.id); break;
                    case 'close-scanner': closeScanner(); break;
                    case 'remind': sendReminder(actionEl); break;
                    case 'toggle-live': toggleLive(); break;
                    case 'toggle-sidebar': document.body.classList.toggle('sidebar-open'); break;
                    case 'delete-announcement': deleteAnnouncement(actionEl); break;
                }
                return;
            }
            // Whole payment row is clickable (but not the buttons/links inside it)
            const row = e.target.closest('tr[data-href]');
            if (row && !e.target.closest('a, button')) window.location = row.dataset.href;
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Enter' && e.target.matches('tr[data-href]')) window.location = e.target.dataset.href;
        });

        /* ---------- Logout confirmation ---------- */
        $('#logoutForm').addEventListener('submit', e => {
            if (!confirm('Are you sure you want to log out?')) e.preventDefault();
        });
    })();
    </script>
</body>
</html>
