<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Maintenance - Dorm Portal</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Theme base */
            --navy-deep: #16213E;
            --navy-mid: #24345C;
            --navy-soft: #3A4E7A;
            --amber: #F0A857;
            --amber-soft: #F6C98B;
            --amber-tint: #FBEBD4;
            --amber-deep: #A9721F;
            --paper: #FBF8F2;
            --ink: #2A2620;
            --slate: #8993A8;

            /* Mapped app tokens */
            --bg-main: var(--paper);
            --sidebar-bg: var(--navy-deep);
            --card-bg: #FFFFFF;
            --text-primary: var(--ink);
            --text-secondary: var(--slate);
            --border-color: #E3DFD5;

            /* Status & Accent Colors */
            --primary-blue: var(--navy-soft);
            --primary-hover: var(--navy-mid);
            --success-green: #4E9A6B;
            --warning-orange: var(--amber);
            --danger-red: #C4573E;
            --purple-accent: #7C6FA6;
            --teal-accent: #3E8E8A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1B2A4D 0%, #16213E 55%, #101A33 100%);
            color: #FFF;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            flex-shrink: 0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 1.25rem;
            margin-bottom: 32px;
            padding-left: 8px;
            color: var(--amber);
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #B7C0D6;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.92rem;
            transition: all 0.2s ease;
        }

        .menu-item:hover, .menu-item.active {
            background-color: rgba(240, 168, 87, 0.14);
            color: #FFF;
        }

        .menu-item.active {
            box-shadow: inset 3px 0 0 var(--amber);
        }

        .sidebar-footer {
            padding-top: 16px;
            border-top: 1px solid #334155;
        }

        .logout-btn {
            width: 100%;
            padding: 10px;
            background: transparent;
            border: 1px solid #334155;
            color: #94A3B8;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            transition: 0.2s;
        }

        .logout-btn:hover {
            color: #FFF;
            background-color: var(--danger-red);
            border-color: var(--danger-red);
        }

        /* Main Area */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 32px;
            background-color: #FFF;
            border-bottom: 1px solid var(--border-color);
            gap: 16px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: var(--paper);
            border: 1px solid var(--border-color);
            padding: 10px 16px;
            border-radius: 20px;
            width: 360px;
            max-width: 100%;
            color: var(--text-secondary);
        }

        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        .search-bar input::placeholder {
            color: #B7B2A6;
        }

        .admin-profile-badge {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background-color: var(--navy-deep);
            color: var(--amber);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-family: 'Fraunces', serif;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            color: var(--text-secondary);
        }

        /* Page Container */
        .dashboard-body {
            padding: 32px;
            overflow-y: auto;
        }

        .welcome-banner {
            margin-bottom: 24px;
        }

        .welcome-banner h1 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 1.8rem;
            color: var(--text-primary);
        }

        .welcome-banner p {
            color: var(--text-secondary);
            margin-top: 4px;
            font-size: 0.92rem;
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #E1EFE6;
            color: #327049;
            border: 1px solid rgba(78, 154, 107, 0.3);
        }

        .alert-error {
            background: #F6E2DD;
            color: #A8412B;
            border: 1px solid rgba(196, 87, 62, 0.3);
        }

        /* Stat Cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .stat-icon.pending { background: var(--amber-tint); color: var(--amber-deep); }
        .stat-icon.in_progress { background: #E4E1F2; color: var(--purple-accent); }
        .stat-icon.completed { background: #E1EFE6; color: #327049; }
        .stat-icon.rejected { background: #F6E2DD; color: #A8412B; }

        .stat-value { font-size: 1.3rem; font-weight: 700; color: var(--navy-deep); font-family: 'Fraunces', serif; }
        .stat-label { font-size: 0.74rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; }

        /* Filter tabs */
        .filter-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            color: var(--text-secondary);
            background: var(--paper);
            border: 1px solid var(--border-color);
            transition: all 0.15s ease;
        }

        .filter-tab:hover { border-color: var(--amber); color: var(--navy-deep); }

        .filter-tab.active {
            background: var(--navy-deep);
            color: #FFF;
            border-color: var(--navy-deep);
        }

        /* Panels */
        .card-panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .card-panel h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-panel h3 i {
            color: var(--amber);
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .data-table th, .data-table td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .data-table th {
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover { background: #FCFAF6; }

        .row-cell { display: flex; align-items: center; gap: 12px; }

        .row-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--amber-tint);
            color: var(--amber-deep);
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .row-title { font-weight: 600; color: var(--navy-deep); }
        .row-sub { color: var(--text-secondary); font-size: 0.75rem; margin-top: 1px; }

        .issue-desc {
            max-width: 260px;
            color: var(--text-secondary);
            font-size: 0.8rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            display: inline-block;
            text-transform: capitalize;
        }

        .status-pill.pending { background-color: #FBEBD4; color: #A9721F; }
        .status-pill.in_progress { background-color: #E4E1F2; color: #5B4E8C; }
        .status-pill.completed { background-color: #E1EFE6; color: #327049; }
        .status-pill.rejected { background-color: #F6E2DD; color: #A8412B; }

        .priority-pill {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 8px;
            text-transform: capitalize;
            margin-left: 6px;
            vertical-align: middle;
        }

        .priority-pill.high { background: #F6E2DD; color: #A8412B; }
        .priority-pill.medium { background: #FBEBD4; color: #A9721F; }
        .priority-pill.low { background: #E1EFE6; color: #327049; }

        .icon-btn {
            padding: 7px 9px;
            border: 1px solid var(--border-color);
            background-color: var(--paper);
            color: var(--text-secondary);
            border-radius: 6px;
            font-size: 0.78rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .icon-btn:hover { background-color: var(--navy-deep); color: #FFF; border-color: var(--navy-deep); }
        .message-action { gap: 7px; white-space: nowrap; }
        .message-action-count { display: inline-grid; place-items: center; min-width: 19px; height: 19px; padding: 0 5px; border-radius: 999px; background: #e8edf5; color: var(--navy-deep); font-size: 10px; font-weight: 700; }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .pagination-wrap { margin-top: 18px; display: flex; justify-content: flex-end; }
        .pagination-wrap nav { font-size: 0.8rem; }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(22, 33, 62, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-overlay.open { display: flex; }

        .modal-card {
            background: var(--paper);
            border-radius: 16px;
            width: 100%;
            max-width: 620px;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            box-shadow: 0 30px 70px -28px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header h3 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 1.15rem;
            color: var(--navy-deep);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-header h3 i { color: var(--amber); }

        .modal-close {
            background: none;
            border: none;
            font-size: 1rem;
            color: var(--text-secondary);
            cursor: pointer;
            line-height: 1;
        }

        .modal-body { padding: 20px 24px; }

        .req-description-view {
            background: #FFF;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 14px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--navy-deep);
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--text-primary);
            background: #FFF;
            outline: none;
            transition: border-color 0.15s ease;
            resize: vertical;
        }

        .form-control:focus, .form-select:focus { border-color: var(--amber); }

        .conversation-panel { padding: 0 24px 20px; }
        .conversation-panel h4 { margin: 0 0 10px; color: var(--navy-deep); font-size: 0.9rem; }
        .message-thread { display: grid; gap: 9px; max-height: 230px; overflow-y: auto; padding: 11px; border: 1px solid var(--border-color); border-radius: 10px; background: #f8f9fb; }
        .maintenance-message { max-width: 88%; padding: 9px 11px; border: 1px solid var(--border-color); border-radius: 10px; background: #fff; }
        .maintenance-message.is-mine { justify-self: end; border-color: #d8e3f1; background: #edf3fb; }
        .maintenance-message-meta { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 4px; color: var(--text-secondary); font-size: 10px; }
        .maintenance-message-body { margin: 0; color: var(--text-primary); font-size: 0.78rem; line-height: 1.55; overflow-wrap: anywhere; white-space: pre-wrap; }
        .message-empty { margin: 0; color: var(--text-secondary); font-size: 0.8rem; text-align: center; }
        .message-form { display: grid; gap: 8px; margin-top: 10px; }
        .message-form textarea { width: 100%; min-height: 68px; padding: 9px 11px; resize: vertical; border: 1px solid var(--border-color); border-radius: 8px; font: inherit; }
        .message-form .btn-save { justify-self: end; }
        .message-error { margin: 0; color: var(--danger-red); font-size: 0.72rem; }

        .field-error { color: var(--danger-red); font-size: 0.72rem; margin-top: 5px; }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px 22px;
        }

        .btn-light {
            background: #FFF;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-light:hover { background: #F0ECE2; }

        .btn-save {
            background: var(--navy-deep);
            border: none;
            color: var(--paper);
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save:hover { background: var(--navy-mid); }

        /* Responsive */
        @media (max-width: 1024px) {
            .app-container { flex-direction: column; }
            .sidebar { width: 100%; }
            .sidebar-menu { flex-direction: row; flex-wrap: wrap; }
            .top-header { flex-wrap: wrap; }
            .search-bar { width: 100%; }
            .dashboard-body { padding: 24px 20px; }
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 560px) {
            .stat-grid { grid-template-columns: 1fr; }
            .issue-desc { max-width: 140px; }
        }
    </style>
    @include('admin.partials.theme')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <i class="fa-solid fa-building-user"></i>
                <span>Dorm Portal</span>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                <a href="{{ route('admin.announcements.index') }}" class="menu-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-bullhorn"></i> Announcements
                </a>
                <a href="{{ route('admin.students.index') }}" class="menu-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate"></i> Students
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="menu-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-door-closed"></i> Rooms
                </a>
                <a href="{{ route('admin.payments.index') }}" class="menu-item {{ request()->routeIs('admin.payments.*', 'admin.bills.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wallet"></i> Payments &amp; Billing
                </a>
                <a href="{{ route('admin.maintenance.index') }}" class="menu-item {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wrench"></i> Maintenance
                </a>
            </nav>
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="main-content">
            <!-- Header Bar -->
            <header class="top-header">
                <div class="admin-page-heading"><strong>Maintenance</strong><small>Review and manage student requests</small></div>
                <form method="GET" class="search-bar" role="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student or room..." aria-label="Search maintenance requests">
                    <button type="submit" aria-label="Search maintenance requests"><i class="fa-solid fa-arrow-right"></i></button>
                </form>
                @include('admin.partials.notification-bell')
                <div class="admin-profile-badge">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">ADMIN</span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="dashboard-body">
                <div class="welcome-banner">
                    <div class="banner-feature-name" role="heading" aria-level="1">Maintenance Management</div>
                    <p>Review student maintenance requests and update their status as work progresses.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
                @endif

                <!-- Stat Cards -->
                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="stat-icon pending"><i class="fa-solid fa-hourglass-half"></i></div>
                        <div>
                            <div class="stat-value">{{ $counts['pending'] }}</div>
                            <div class="stat-label">Pending</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon in_progress"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                        <div>
                            <div class="stat-value">{{ $counts['in_progress'] }}</div>
                            <div class="stat-label">In Progress</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon completed"><i class="fa-solid fa-circle-check"></i></div>
                        <div>
                            <div class="stat-value">{{ $counts['completed'] }}</div>
                            <div class="stat-label">Completed</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon rejected"><i class="fa-solid fa-circle-xmark"></i></div>
                        <div>
                            <div class="stat-value">{{ $counts['rejected'] }}</div>
                            <div class="stat-label">Rejected</div>
                        </div>
                    </div>
                </div>

                <div class="card-panel">
                    <div class="panel-header">
                        <h3><i class="fa-solid fa-wrench"></i> Maintenance Requests</h3>
                        <div class="filter-tabs">
                            <a href="{{ route('admin.maintenance.index') }}" class="filter-tab {{ empty($status) ? 'active' : '' }}">All</a>
                            <a href="{{ route('admin.maintenance.index', ['status' => 'pending']) }}" class="filter-tab {{ $status === 'pending' ? 'active' : '' }}">Pending</a>
                            <a href="{{ route('admin.maintenance.index', ['status' => 'in_progress']) }}" class="filter-tab {{ $status === 'in_progress' ? 'active' : '' }}">In Progress</a>
                            <a href="{{ route('admin.maintenance.index', ['status' => 'completed']) }}" class="filter-tab {{ $status === 'completed' ? 'active' : '' }}">Completed</a>
                            <a href="{{ route('admin.maintenance.index', ['status' => 'rejected']) }}" class="filter-tab {{ $status === 'rejected' ? 'active' : '' }}">Rejected</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Room</th>
                                    <th>Category / Description</th>
                                    <th>Submitted</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $request)
                                    <tr>
                                        <td>
                                            <div class="row-cell">
                                                <div class="row-avatar">{{ strtoupper(substr($request->user->name ?? '?', 0, 1)) }}</div>
                                                <div>
                                                    <div class="row-title">{{ $request->user->name ?? 'Unknown Student' }}</div>
                                                    <div class="row-sub">{{ $request->user->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $request->room->room_number ?? 'N/A' }}</td>
                                        <td>
                                            <div class="row-title" style="font-size: 0.85rem;">
                                                {{ \Illuminate\Support\Str::startsWith($request->title ?? '', '[') ? \Illuminate\Support\Str::before(\Illuminate\Support\Str::after($request->title, '['), ']') : 'Other' }}
                                                @if ($request->priority)
                                                    <span class="priority-pill {{ $request->priority }}">{{ $request->priority }}</span>
                                                @endif
                                            </div>
                                            <div class="issue-desc" title="{{ $request->description }}">{{ $request->description }}</div>
                                        </td>
                                        <td>{{ \Illuminate\Support\Carbon::parse($request->created_at)->format('M d, Y') }}</td>
                                        <td>
                                            <span class="status-pill {{ $request->status }}">
                                                {{ str_replace('_', ' ', $request->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="icon-btn message-action" title="Open request and messages" onclick="openModal('maintenanceModal{{ $request->id }}')">
                                                <i class="fa-solid fa-comments" aria-hidden="true"></i> Messages <span class="message-action-count">{{ $request->messages_count }}</span>
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Update Maintenance Request Modal --}}
                                    <div class="modal-overlay" id="maintenanceModal{{ $request->id }}">
                                        <div class="modal-card">
                                            <form action="{{ route('admin.maintenance.update', $request) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h3><i class="fa-solid fa-wrench"></i> Request Details</h3>
                                                    <button type="button" class="modal-close" onclick="closeModal('maintenanceModal{{ $request->id }}')">✕</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="req-description-view">
                                                        <strong>{{ $request->user->name ?? 'Unknown Student' }}</strong> &middot; Room {{ $request->room->room_number ?? 'N/A' }}<br>
                                                        Category: {{ \Illuminate\Support\Str::startsWith($request->title ?? '', '[') ? \Illuminate\Support\Str::before(\Illuminate\Support\Str::after($request->title, '['), ']') : 'Other' }}<br>
                                                        {{ $request->description }}<br>
                                                        Assigned to: {{ $request->assignee->name ?? 'Unassigned' }}<br>
                                                        Target date: {{ $request->due_at?->format('M d, Y g:i A') ?? 'Not set' }}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="pending" {{ $request->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="in_progress" {{ $request->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                            <option value="completed" {{ $request->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                            <option value="rejected" {{ $request->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Assigned administrator</label>
                                                        <select name="assigned_to" class="form-select">
                                                            <option value="">Unassigned</option>
                                                            @foreach ($admins as $admin)
                                                                <option value="{{ $admin->id }}" {{ (int) $request->assigned_to === (int) $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Target date</label>
                                                        <input type="datetime-local" name="due_at" class="form-control" value="{{ $request->due_at?->format('Y-m-d\\TH:i') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Admin Notes</label>
                                                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add notes for the student...">{{ old('admin_notes', $request->admin_notes) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn-light" onclick="closeModal('maintenanceModal{{ $request->id }}')">Cancel</button>
                                                    <button type="submit" class="btn-save">Save Changes</button>
                                                </div>
                                            </form>
                                            <section class="conversation-panel" aria-label="Conversation with {{ $request->user->name ?? 'student' }}">
                                                <h4>Conversation with {{ $request->user->name ?? 'the student' }}</h4>
                                                <div class="message-thread" aria-live="polite">
                                                    @forelse ($request->messages as $message)
                                                        <article class="maintenance-message {{ (int) $message->user_id === (int) auth()->id() ? 'is-mine' : '' }}">
                                                            <div class="maintenance-message-meta">
                                                                <strong>{{ (int) $message->user_id === (int) auth()->id() ? 'You' : ($message->user->name ?? 'Dorm Portal User') }}</strong>
                                                                <time datetime="{{ $message->created_at->toIso8601String() }}">{{ $message->created_at->format('M d, g:i A') }}</time>
                                                            </div>
                                                            <p class="maintenance-message-body">{{ $message->body }}</p>
                                                        </article>
                                                    @empty
                                                        <p class="message-empty">No messages yet. Start the conversation with the student.</p>
                                                    @endforelse
                                                </div>
                                                <form class="message-form" action="{{ route('maintenance.messages.store', $request) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="maintenance_request_id" value="{{ $request->id }}">
                                                    <textarea name="body" maxlength="2000" required aria-label="Message to student" placeholder="Write a message to the student...">{{ (int) old('maintenance_request_id') === (int) $request->id ? old('body') : '' }}</textarea>
                                                    @if ((int) old('maintenance_request_id') === (int) $request->id)
                                                        @error('body') <p class="message-error">{{ $message }}</p> @enderror
                                                    @endif
                                                    <button type="submit" class="btn-save"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Send Message</button>
                                                </form>
                                            </section>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">No maintenance requests found. Requests appear here once students submit them.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.add('open');
            const url = new URL(window.location.href);
            url.searchParams.set('open', id.replace('maintenanceModal', ''));
            window.history.replaceState({}, '', url);
        }
        function closeModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.remove('open');
            const url = new URL(window.location.href);
            url.searchParams.delete('open');
            window.history.replaceState({}, '', url);
        }
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) closeModal(overlay.id);
            });
        });
        const requestToOpen = new URLSearchParams(window.location.search).get('open');
        if (requestToOpen) openModal('maintenanceModal' + requestToOpen);
    </script>
</body>
</html>
