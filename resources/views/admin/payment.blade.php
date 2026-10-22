<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Dorm Portal</title>
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

        .amount-cell { font-weight: 600; color: var(--navy-deep); }

        .method-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            background: var(--paper);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            text-transform: capitalize;
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            display: inline-block;
        }

        .status-pill.paid { background-color: #E1EFE6; color: #327049; }
        .status-pill.pending { background-color: #FBEBD4; color: #A9721F; }
        .status-pill.overdue { background-color: #F6E2DD; color: #A8412B; }

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
        }

        .icon-btn:hover { background-color: var(--navy-deep); color: #FFF; border-color: var(--navy-deep); }
        .icon-btn.delete:hover { background-color: var(--danger-red); border-color: var(--danger-red); color: #FFF; }
        .icon-btn.verify { color: #278451; border-color: #b9dfc8; background: #edf8f1; }
        .icon-btn.verify:hover { color: #fff; background: #278451; border-color: #278451; }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .payment-tabs { display: flex; gap: 8px; margin: 0 0 20px; }
        .payment-tab {
            display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px;
            border: 1px solid var(--border-color); border-radius: 8px; background: #FFF;
            color: var(--text-secondary); font-size: 0.85rem; font-weight: 600; text-decoration: none;
        }
        .payment-tab.active { background: var(--navy-deep); border-color: var(--navy-deep); color: #FFF; }
        .billing-form-grid { display: grid; grid-template-columns: repeat(3, minmax(150px, 1fr)); gap: 14px; }
        .billing-check { display: flex; align-items: center; gap: 8px; margin: 14px 0; font-size: 0.82rem; color: var(--text-secondary); }
        .billing-check input { width: auto; }
        .billing-form-grid input, .billing-form-grid select { width: 100%; }

        .pagination-wrap { margin-top: 18px; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
        .pagination-pages { display: flex; align-items: center; gap: 6px; }
        .pagination-page { min-width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; padding: 0 10px; border: 1px solid var(--border-color); border-radius: 8px; background: #fff; color: var(--navy-deep); font-size: 12px; font-weight: 600; text-decoration: none; }
        .pagination-page:hover { border-color: var(--amber); background: var(--paper); }
        .pagination-page.current { border-color: var(--navy-deep); background: var(--navy-deep); color: #fff; }
        .pagination-summary { color: var(--text-secondary); font-size: 12px; }
        .gcash-qr-preview { margin: 0 0 14px; }
        .gcash-qr-preview summary { width: fit-content; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 8px; background: #fff; color: var(--navy-deep); cursor: pointer; font-size: 12px; font-weight: 600; list-style: none; }
        .gcash-qr-preview summary::-webkit-details-marker { display: none; }
        .gcash-qr-preview[open] summary { margin-bottom: 12px; }
        .gcash-qr-preview img { display: block; max-width: 180px; max-height: 180px; object-fit: contain; border: 1px solid var(--border-color); border-radius: 12px; padding: 8px; background: #fff; }
        .data-table tr[hidden] { display: none !important; }
        .older-transactions-wrap { display: flex; justify-content: center; padding: 14px 0 2px; }
        .older-transactions-toggle { padding: 9px 14px; border: 1px solid var(--border-color); border-radius: 9px; background: #fff; color: var(--navy-deep); cursor: pointer; font-size: 12px; font-weight: 600; }
        .older-transactions-toggle:hover { border-color: var(--amber); background: var(--paper); }
        .transaction-history-tools { display: flex; align-items: center; justify-content: flex-end; gap: 8px; flex-wrap: wrap; }
        .transaction-history-tools select { min-height: 38px; padding: 7px 10px; color: var(--navy-deep); font-size: 11px !important; }
        .history-page-link { padding: 9px 12px; border: 1px solid var(--border-color); border-radius: 9px; background: #fff; color: var(--navy-deep); font-size: 11px; font-weight: 600; text-decoration: none; white-space: nowrap; }
        .history-page-link:hover { border-color: var(--amber); background: var(--paper); }
        @media (max-width: 700px) { .transaction-history-tools { justify-content: flex-start; } }

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
            max-width: 440px;
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
        }

        .form-control:focus, .form-select:focus { border-color: var(--amber); }

        .field-error { color: var(--danger-red); font-size: 0.72rem; margin-top: 5px; }

        .form-row { display: flex; gap: 12px; }
        .form-row .form-group { flex: 1; }

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
            .form-row { flex-direction: column; gap: 0; }
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
                <div class="admin-page-heading"><strong>{{ $section === 'billing' ? 'Billing' : 'Payments' }}</strong><small>Manage student charges and transactions</small></div>
                @if ($section === 'payments')
                <form method="GET" class="search-bar" role="search">
                    <input type="hidden" name="section" value="payments">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student or reference no..." aria-label="Search payments">
                    <button type="submit" aria-label="Search payments"><i class="fa-solid fa-arrow-right"></i></button>
                </form>
                @else
                    <div></div>
                @endif
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
                    <div class="banner-feature-name" role="heading" aria-level="1">{{ $section === 'billing' ? 'Billing Management' : 'Payments Management' }}</div>
                    <p>{{ $section === 'billing' ? 'Create monthly room bills and track each student’s outstanding balance.' : 'Review student payments, update their status, and remove incorrect records.' }}</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
                @endif

                <nav class="payment-tabs" aria-label="Payment sections">
                    <a class="payment-tab {{ $section === 'payments' ? 'active' : '' }}" href="{{ route('admin.payments.index', ['section' => 'payments']) }}"><i class="fa-solid fa-wallet"></i> Payment Records</a>
                    <a class="payment-tab {{ $section === 'billing' ? 'active' : '' }}" href="{{ route('admin.payments.index', ['section' => 'billing', 'month' => $month->format('Y-m')]) }}"><i class="fa-solid fa-file-invoice-dollar"></i> Billing</a>
                </nav>

                @if ($section === 'billing')
                <section class="card-panel" style="margin-bottom:20px">
                    <div class="panel-header"><h3><i class="fa-solid fa-plus"></i> Create or update room bills</h3></div>
                    <form action="{{ route('admin.bills.store') }}" method="POST">
                        @csrf
                        <div class="billing-form-grid">
                            <div class="form-group">
                                <label class="form-label" for="roomSelect">Room</label>
                                <select name="room_id" id="roomSelect" class="form-select" required>
                                    @forelse ($rooms as $room)
                                        <option value="{{ $room->id }}" data-rate="{{ $room->monthly_rate ?? 0 }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            Room {{ $room->room_number }} ({{ $room->students_count }} students)
                                        </option>
                                    @empty
                                        <option value="">No rooms available</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group"><label class="form-label" for="billingMonth">Billing month</label><input id="billingMonth" type="month" name="billing_month" class="form-control" value="{{ old('billing_month', $month->format('Y-m')) }}" required></div>
                            <div class="form-group"><label class="form-label" for="dueDate">Due date</label><input id="dueDate" type="date" name="due_date" class="form-control" value="{{ old('due_date') }}"></div>
                            <div class="form-group"><label class="form-label" for="rentInput">Rent per student</label><input id="rentInput" type="number" step="0.01" min="0" name="rent" class="form-control" value="{{ old('rent') }}" required></div>
                            <div class="form-group"><label class="form-label" for="electricity">Electricity (room total)</label><input id="electricity" type="number" step="0.01" min="0" name="electricity" class="form-control" value="{{ old('electricity', 0) }}" required></div>
                            <div class="form-group"><label class="form-label" for="water">Water (room total)</label><input id="water" type="number" step="0.01" min="0" name="water" class="form-control" value="{{ old('water', 0) }}" required></div>
                        </div>
                        <label class="billing-check"><input type="checkbox" name="split" value="1" {{ old('split', '1') ? 'checked' : '' }}> Split electricity and water evenly among assigned students</label>
                        <button class="btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save bills</button>
                    </form>
                </section>

                <section class="card-panel">
                    <div class="panel-header">
                        <h3><i class="fa-solid fa-file-invoice-dollar"></i> Bills for {{ $month->format('F Y') }}</h3>
                        <form method="GET" action="{{ route('admin.payments.index') }}">
                            <input type="hidden" name="section" value="billing">
                            <input type="month" name="month" class="form-control" value="{{ $month->format('Y-m') }}" onchange="this.form.submit()" aria-label="Billing month">
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead><tr><th>Student</th><th>Room</th><th>Rent</th><th>Electricity</th><th>Water</th><th>Total</th><th>Due date</th><th>Balance</th><th>Actions</th></tr></thead>
                            <tbody>
                            @forelse ($bills as $bill)
                                <tr>
                                    <td>{{ $bill->student->name ?? 'Unknown student' }}</td>
                                    <td>{{ $bill->room->room_number ?? '—' }}</td>
                                    <td>₱{{ number_format($bill->rent, 2) }}</td>
                                    <td>₱{{ number_format($bill->electricity, 2) }}</td>
                                    <td>₱{{ number_format($bill->water, 2) }}</td>
                                    <td class="amount-cell">₱{{ number_format($bill->total, 2) }}</td>
                                    <td>
                                        {{ $bill->due_date?->format('M d, Y') ?? '—' }}
                                        @if ($bill->due_date?->isBefore(today()) && $bill->reminderBalance() > 0)
                                            <div style="color:#9b3b37;font-size:11px;font-weight:700">Overdue</div>
                                        @endif
                                    </td>
                                    <td><span class="status-pill {{ $bill->balance <= 0 ? 'paid' : 'pending' }}">{{ $bill->balance <= 0 ? 'Settled' : '₱'.number_format($bill->balance, 2) }}</span></td>
                                    <td>
                                        <button type="button" class="icon-btn edit" onclick="openModal('editBill{{ $bill->id }}')" aria-label="Edit bill"><i class="fa-solid fa-pen"></i></button>
                                        <form action="{{ route('admin.bills.destroy', $bill) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this bill?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="icon-btn delete" aria-label="Delete bill"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9"><div class="empty-state">No bills for this month yet.</div></td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                @foreach ($bills as $bill)
                    <div class="modal-overlay" id="editBill{{ $bill->id }}">
                        <div class="modal-card">
                            <form action="{{ route('admin.bills.update', $bill) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header"><h3><i class="fa-solid fa-pen"></i> Edit bill for {{ $bill->student->name ?? 'student' }}</h3><button type="button" class="modal-close" onclick="closeModal('editBill{{ $bill->id }}')">×</button></div>
                                <div class="modal-body">
                                    <div class="form-group"><label class="form-label">Rent</label><input type="number" step="0.01" min="0" name="rent" class="form-control" value="{{ $bill->rent }}" required></div>
                                    <div class="form-group"><label class="form-label">Electricity</label><input type="number" step="0.01" min="0" name="electricity" class="form-control" value="{{ $bill->electricity }}" required></div>
                                    <div class="form-group"><label class="form-label">Water</label><input type="number" step="0.01" min="0" name="water" class="form-control" value="{{ $bill->water }}" required></div>
                                    <div class="form-group"><label class="form-label">Due date</label><input type="date" name="due_date" class="form-control" value="{{ $bill->due_date?->format('Y-m-d') }}"></div>
                                </div>
                                <div class="modal-footer"><button type="button" class="btn-light" onclick="closeModal('editBill{{ $bill->id }}')">Cancel</button><button type="submit" class="btn-save">Save changes</button></div>
                            </form>
                        </div>
                    </div>
                @endforeach
                @else
                <section class="card-panel" style="margin-bottom:20px">
                    <div class="panel-header"><h3><i class="fa-brands fa-google-wallet"></i> Student GCash QR</h3></div>
                    <p class="row-sub" style="margin-bottom:14px">Upload the official dormitory GCash QR. Students will see it when they choose GCash.</p>
                    @if ($gcashQrUrl)
                        <details class="gcash-qr-preview">
                            <summary><i class="fa-regular fa-eye"></i> Show current GCash QR</summary>
                            <img src="{{ $gcashQrUrl }}" alt="Current dormitory GCash QR">
                        </details>
                    @endif
                    <form action="{{ route('admin.payments.gcash-qr') }}" method="POST" enctype="multipart/form-data" class="form-row">
                        @csrf
                        <div class="form-group"><label class="form-label" for="gcash_qr">{{ $gcashQrUrl ? 'Replace QR image' : 'Upload QR image' }}</label><input id="gcash_qr" name="gcash_qr" type="file" class="form-control" accept="image/png,image/jpeg,image/webp" required></div>
                        <div class="form-group" style="align-self:end"><button class="btn-save" type="submit"><i class="fa-solid fa-upload"></i> Save GCash QR</button></div>
                    </form>
                </section>
                <div class="card-panel">
                    <div class="panel-header">
                        <h3><i class="fa-solid fa-file-invoice-dollar"></i> Payment Records</h3>
                        <div class="transaction-history-tools" aria-label="Transaction history controls">
                            <select id="transactionStatusFilter" aria-label="Filter transactions by status">
                                <option value="all">All statuses</option>
                                <option value="pending">Pending</option>
                                <option value="verified">Verified</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <select id="transactionDateOrder" aria-label="Sort transactions by date">
                                <option value="newest">Newest first</option>
                                <option value="oldest">Oldest first</option>
                            </select>
                            @if ($payments->count() > 5)
                                <button type="button" class="older-transactions-toggle" id="olderTransactionsToggle" aria-expanded="false">
                                    See older transactions ({{ $payments->count() - 5 }} more)
                                </button>
                            @endif
                            @if ($payments->previousPageUrl())
                                <a class="history-page-link" href="{{ $payments->previousPageUrl() }}">Newer page</a>
                            @endif
                            @if ($payments->nextPageUrl())
                                <a class="history-page-link" href="{{ $payments->nextPageUrl() }}">Older page</a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $paymentIndex => $payment)
                                    @php
                                        $statusClasses = [
                                            'verified' => 'paid',
                                            'rejected' => 'overdue',
                                            'pending' => 'pending',
                                        ];
                                    @endphp
                                    <tr data-transaction-row data-transaction-status="{{ $payment->status }}" data-transaction-date="{{ ($payment->payment_date ?? $payment->created_at)?->format('Y-m-d H:i:s') }}" @if ($paymentIndex >= 5) hidden @endif>
                                        <td>
                                            <div class="row-cell">
                                                <div class="row-avatar">{{ strtoupper(substr($payment->user->name ?? '?', 0, 1)) }}</div>
                                                <div>
                                                    <div class="row-title">{{ $payment->user->name ?? 'Unknown Student' }}</div>
                                                    <div class="row-sub">Transaction: {{ $payment->reference_number ?? 'No reference' }}</div>
                                                    @if ($payment->provider_reference)<div class="row-sub">Provider: {{ $payment->provider_reference }}</div>@endif
                                                    @if ($payment->bill)
                                                        <div class="row-sub">{{ ucfirst($payment->applies_to) }} · {{ $payment->bill->billing_month->format('F Y') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="amount-cell">₱{{ number_format($payment->amount, 2) }}</td>
                                        <td><span class="method-pill">{{ $payment->method }}</span></td>
                                        <td>{{ ($payment->payment_date ?? $payment->created_at)?->format('M d, Y') }}</td>
                                        <td>
                                            <span class="status-pill {{ $statusClasses[$payment->status] ?? 'pending' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($payment->status === 'pending')
                                                <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="icon-btn verify" title="Verify payment" aria-label="Verify payment">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="icon-btn edit" title="Edit"
                                                    onclick="openModal('editPaymentModal{{ $payment->id }}')">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            @if ($payment->status !== 'verified')
                                            <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline"
                                                  onsubmit="return confirm('Delete this payment record? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="icon-btn delete" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Edit Payment Modal --}}
                                    <div class="modal-overlay" id="editPaymentModal{{ $payment->id }}">
                                        <div class="modal-card">
                                            <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h3><i class="fa-solid fa-pen"></i> Edit Payment</h3>
                                                    <button type="button" class="modal-close" onclick="closeModal('editPaymentModal{{ $payment->id }}')">✕</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="form-label">Student</label>
                                                        <select name="user_id" class="form-select" required>
                                                            @foreach ($students as $student)
                                                                <option value="{{ $student->id }}" {{ $payment->user_id == $student->id ? 'selected' : '' }}>
                                                                    {{ $student->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label class="form-label">Amount</label>
                                                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ $payment->amount }}" min="0.01" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Payment Date</label>
                                                            <input type="date" class="form-control" value="{{ ($payment->payment_date ?? $payment->created_at)?->format('Y-m-d') }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label class="form-label">Method</label>
                                                            <select name="method" class="form-select" required>
                                                                <option value="Cash" {{ $payment->method === 'Cash' ? 'selected' : '' }}>Cash</option>
                                                                <option value="GCash" {{ $payment->method === 'GCash' ? 'selected' : '' }}>GCash</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="verified" {{ $payment->status === 'verified' ? 'selected' : '' }}>Verified</option>
                                                                <option value="pending" {{ $payment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="rejected" {{ $payment->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Reference Number</label>
                                                        <input type="text" name="reference_number" class="form-control" value="{{ $payment->reference_number }}" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn-light" onclick="closeModal('editPaymentModal{{ $payment->id }}')">Cancel</button>
                                                    <button type="submit" class="btn-save">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">No payments found. Records appear here once students submit payments.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) overlay.classList.remove('open');
            });
        });

        const transactionRows = [...document.querySelectorAll('[data-transaction-row]')];
        const transactionStatusFilter = document.getElementById('transactionStatusFilter');
        const transactionDateOrder = document.getElementById('transactionDateOrder');
        const olderTransactionsToggle = document.getElementById('olderTransactionsToggle');
        let showOlderTransactions = false;

        const renderTransactions = () => {
            const status = transactionStatusFilter?.value ?? 'all';
            const direction = transactionDateOrder?.value === 'oldest' ? 1 : -1;
            const matchingRows = transactionRows
                .filter(row => status === 'all' || row.dataset.transactionStatus === status)
                .sort((first, second) => direction * first.dataset.transactionDate.localeCompare(second.dataset.transactionDate));
            const tbody = transactionRows[0]?.parentElement;
            matchingRows.forEach(row => tbody?.append(row));
            const visibleRows = showOlderTransactions ? matchingRows : matchingRows.slice(0, 5);
            transactionRows.forEach(row => { row.hidden = !visibleRows.includes(row); });

            if (olderTransactionsToggle) {
                const olderCount = Math.max(0, matchingRows.length - 5);
                olderTransactionsToggle.hidden = olderCount === 0;
                olderTransactionsToggle.setAttribute('aria-expanded', String(showOlderTransactions));
                olderTransactionsToggle.textContent = showOlderTransactions
                    ? 'Show fewer transactions'
                    : `See older transactions (${olderCount} more)`;
            }
        };

        transactionStatusFilter?.addEventListener('change', () => { showOlderTransactions = false; renderTransactions(); });
        transactionDateOrder?.addEventListener('change', () => { showOlderTransactions = false; renderTransactions(); });
        olderTransactionsToggle?.addEventListener('click', () => { showOlderTransactions = !showOlderTransactions; renderTransactions(); });
        renderTransactions();
    </script>
</body>
</html>
