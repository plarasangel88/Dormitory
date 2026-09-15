<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Dormitory Management</title>
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
            --amber-tint: #FCEEDA;
            --amber-deep: #B4741F;
            --paper: #FBF8F2;
            --ink: #2A2620;
            --slate: #8993A8;
            --line: #E7E2D6;
            --green: #1F9D55;
            --green-tint: #E7F6ED;
            --red: #D64545;
            --red-tint: #FCE9E9;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            color: var(--ink);
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: var(--paper);
        }

        /* ---------- Sidebar ---------- */
        .sidebar-wrapper { position: relative; flex-shrink: 0; }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: sticky;
            top: 0;
            background: linear-gradient(180deg, #1B2A4D 0%, #16213E 60%, #101A33 100%);
            padding: 30px 0;
            display: flex;
            flex-direction: column;
            transition: width 0.25s ease, padding 0.25s ease;
            overflow: hidden;
            white-space: nowrap;
        }
        .sidebar.collapsed { width: 78px; padding: 30px 0; }

        .sidebar .logo {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 22px;
        }
        .sidebar .logo .key-badge {
            width: 34px; height: 34px;
            border-radius: 9px;
            background: rgba(240, 168, 87, 0.14);
            border: 1px solid rgba(240, 168, 87, 0.3);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar .logo-text {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 16.5px;
            color: var(--paper);
        }
        .sidebar.collapsed .logo-text { display: none; }

        .sidebar nav { display: flex; flex-direction: column; gap: 2px; }
        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 24px;
            margin: 0 10px;
            border-radius: 9px;
            color: #AEB8D4;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.18s ease;
        }
        .sidebar nav a .link-icon {
            width: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .sidebar nav a .link-icon svg { display: block; }
        .sidebar nav a:hover { background-color: rgba(255,255,255,0.06); color: var(--paper); }
        .sidebar nav a.active {
            background-color: rgba(240, 168, 87, 0.14);
            color: var(--amber-soft);
            font-weight: 600;
        }
        .sidebar.collapsed nav a { justify-content: center; padding: 12px 0; margin: 0 14px; }
        .sidebar.collapsed nav a .link-text { display: none; }

        .sidebar .logout-form { margin-top: auto; padding: 18px 24px 0; }
        .sidebar.collapsed .logout-form { padding: 18px 16px 0; }
        .btn-logout {
            width: 100%;
            padding: 11px;
            background-color: transparent;
            color: #AEB8D4;
            border: 1.5px solid rgba(255,255,255,0.16);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.18s ease;
        }
        .btn-logout:hover {
            background-color: rgba(240, 90, 90, 0.12);
            color: #F19A9A;
            border-color: rgba(240, 90, 90, 0.35);
        }

        .toggle-btn {
            position: absolute;
            top: 30px; right: -14px;
            width: 28px; height: 28px;
            background-color: var(--amber);
            color: var(--navy-deep);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(240, 168, 87, 0.4);
            transition: background-color 0.15s ease, transform 0.25s ease;
            z-index: 10;
        }
        .toggle-btn:hover { background-color: var(--amber-soft); }
        .sidebar.collapsed .toggle-btn { transform: rotate(180deg); }

        /* ---------- Main content ---------- */
        .main { flex: 1; padding: 44px 56px 56px; max-width: 1180px; }

        /* ---------- Topbar (admin badge) ---------- */
        .topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 22px;
        }
        .admin-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 30px;
            padding: 6px 16px 6px 6px;
            box-shadow: 0 2px 8px rgba(22, 33, 62, 0.04);
        }
        .admin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--navy-deep);
            color: var(--amber-soft);
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .admin-info { display: flex; flex-direction: column; line-height: 1.25; }
        .admin-name { font-size: 13px; font-weight: 600; color: var(--navy-deep); }
        .admin-role {
            font-size: 10.5px;
            color: var(--slate);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .page-head { margin-bottom: 30px; }
        .page-head .eyebrow-mark { width: 30px; height: 3px; background: var(--amber); margin-bottom: 16px; }
        .main h1 { font-family: 'Fraunces', serif; font-weight: 500; font-size: 28px; color: var(--navy-deep); margin-bottom: 8px; }
        .main p.sub { color: var(--slate); font-size: 14px; }

        .alert-success {
            background: var(--green-tint);
            color: var(--green);
            border: 1px solid rgba(31,157,85,0.25);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 22px;
        }
        .alert-error {
            background: var(--red-tint);
            color: var(--red);
            border: 1px solid rgba(214,69,69,0.25);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 22px;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 14px;
            flex-wrap: wrap;
        }
        .search-box {
            display: flex;
            align-items: center;
            gap: 9px;
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 9px 15px;
            min-width: 280px;
        }
        .search-box svg { flex-shrink: 0; color: var(--slate); }
        .search-box input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--ink);
            background: transparent;
        }
        .btn-add {
            background: var(--navy-deep);
            color: var(--paper);
            border: none;
            border-radius: 10px;
            padding: 11px 20px;
            font-family: 'Inter', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background-color 0.18s ease;
        }
        .btn-add svg { flex-shrink: 0; }
        .btn-add:hover { background: var(--navy-mid); }

        /* Table card */
        .card-table {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: var(--paper);
            text-align: left;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--slate);
            font-weight: 600;
            padding: 14px 22px;
            border-bottom: 1px solid var(--line);
        }
        tbody td {
            padding: 15px 22px;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
            font-size: 13.5px;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fcfaf6; }

        .student-cell { display: flex; align-items: center; gap: 13px; }
        .avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: var(--amber-tint);
            color: var(--amber-deep);
            font-family: 'Fraunces', serif;
            font-weight: 600;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .student-name { font-weight: 600; color: var(--navy-deep); }
        .payment-sub { color: var(--slate); font-size: 12px; margin-top: 1px; }

        .amount-cell { font-weight: 600; color: var(--navy-deep); }
        .method-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            background: var(--paper);
            color: var(--slate);
            border: 1px solid var(--line);
            text-transform: capitalize;
        }

        .badge-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }
        .badge-paid { background: var(--green-tint); color: var(--green); }
        .badge-pending { background: var(--amber-tint); color: var(--amber-deep); }
        .badge-overdue { background: var(--red-tint); color: var(--red); }

        .action-btn {
            border: none;
            background: transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px;
            border-radius: 7px;
            cursor: pointer;
            transition: background-color 0.15s ease;
            color: var(--slate);
        }
        .action-btn:hover { background: var(--paper); }
        .action-btn.edit:hover { color: var(--navy-deep); }
        .action-btn.delete:hover { color: var(--red); }
        .action-btn svg { display: block; }

        .empty-state { text-align: center; padding: 60px 20px; color: var(--slate); font-size: 13.5px; }

        .pagination-wrap { margin-top: 18px; display: flex; justify-content: flex-end; }
        .pagination-wrap nav { font-size: 13px; }

        /* ---------- Custom modal (no Bootstrap) ---------- */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(22, 33, 62, 0.45);
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 20px;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: #ffffff;
            border-radius: 14px;
            width: 100%;
            max-width: 440px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 50px rgba(22, 33, 62, 0.25);
        }
        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
        }
        .modal-header h5 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 18px;
            color: var(--navy-deep);
        }
        .modal-close {
            background: none;
            border: none;
            font-size: 18px;
            color: var(--slate);
            cursor: pointer;
            line-height: 1;
        }
        .modal-body { padding: 20px 24px; }
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--navy-deep);
            margin-bottom: 6px;
        }
        .form-control, .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 13.5px;
            color: var(--ink);
            outline: none;
            transition: border-color 0.15s ease;
        }
        .form-control:focus, .form-select:focus { border-color: var(--amber); }
        .field-error {
            color: var(--red);
            font-size: 11.5px;
            margin-top: 5px;
        }
        .form-row { display: flex; gap: 12px; }
        .form-row .form-group { flex: 1; }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px 22px;
        }
        .btn-light {
            background: var(--paper);
            border: 1px solid var(--line);
            color: var(--ink);
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-save {
            background: var(--navy-deep);
            border: none;
            color: var(--paper);
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-save:hover { background: var(--navy-mid); }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar {
                width: 100%; height: auto; position: relative;
                flex-direction: row; align-items: center;
                padding: 16px 20px; overflow-x: auto;
            }
            .sidebar.collapsed { width: 100%; }
            .sidebar .logo { border-bottom: none; margin-bottom: 0; padding: 0 16px 0 0; }
            .sidebar nav { flex-direction: row; }
            .sidebar .logout-form { margin-top: 0; padding: 0 0 0 12px; }
            .toggle-btn { display: none; }
            .main { padding: 32px 24px 48px; }
            .topbar { justify-content: flex-start; margin-bottom: 16px; }
            .form-row { flex-direction: column; gap: 0; }
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar-wrapper">
        <div class="sidebar" id="sidebar">
            <button class="toggle-btn" id="toggleBtn" title="Toggle sidebar">◀</button>
            <div class="logo">
                <div class="key-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="15" r="4"></circle>
                        <path d="M10.5 12.5L19 4M19 4h-4M19 4v4"></path>
                    </svg>
                </div>
                <span class="logo-text">Dorm Portal</span>
            </div>
            <nav>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 10.5 12 3l9 7.5"></path>
                            <path d="M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"></path>
                        </svg>
                    </span>
                    <span class="link-text">Dashboard</span>
                </a>
                <a href="{{ route('admin.students.index') }}">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10 12 5 2 10l10 5 10-5Z"></path>
                            <path d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"></path>
                        </svg>
                    </span>
                    <span class="link-text">Students</span>
                </a>
                <a href="{{ route('admin.rooms.index') }}">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 18v-6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6"></path>
                            <path d="M2 18h20"></path>
                            <path d="M6 10V6.5A1.5 1.5 0 0 1 7.5 5h4A1.5 1.5 0 0 1 13 6.5V10"></path>
                        </svg>
                    </span>
                    <span class="link-text">Rooms</span>
                </a>
                <a href="{{ route('admin.payments.index') }}" class="active">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <path d="M2 10h20"></path>
                        </svg>
                    </span>
                    <span class="link-text">Payments</span>
                </a>
                <a href="/admin/maintenance">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.4-3.4a5 5 0 0 1-6.7 6.7l-6.9 6.9a2.1 2.1 0 0 1-3-3l6.9-6.9a5 5 0 0 1 6.7-6.7z"></path>
                        </svg>
                    </span>
                    <span class="link-text">Maintenance</span>
                </a>
                <a href="/admin/profile">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-1.5a5 5 0 0 0-5-5H9a5 5 0 0 0-5 5V21"></path>
                            <circle cx="12" cy="7.5" r="4"></circle>
                        </svg>
                    </span>
                    <span class="link-text">Profile</span>
                </a>
            </nav>
            <div class="logout-form">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main content --}}
    <div class="main">
        <div class="topbar">
            <div class="admin-chip">
                <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="admin-info">
                    <span class="admin-name">{{ auth()->user()->name }}</span>
                    <span class="admin-role">Admin</span>
                </div>
            </div>
        </div>

        <div class="page-head">
            <div class="eyebrow-mark"></div>
            <h1>Manage Payments</h1>
            <p class="sub">View, record, edit, and remove student payments.</p>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="toolbar">
            <form method="GET" class="search-box">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student or reference no...">
            </form>

            <button type="button" class="btn-add" onclick="openModal('addPaymentModal')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14"></path>
                </svg>
                Add Payment
            </button>
        </div>

        <div class="card-table">
            <table>
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
                    @forelse ($payments as $payment)
                        @php
                            $statusClasses = [
                                'paid'    => 'badge-paid',
                                'pending' => 'badge-pending',
                                'overdue' => 'badge-overdue',
                            ];
                        @endphp
                        <tr>
                            <td>
                                <div class="student-cell">
                                    <div class="avatar">{{ strtoupper(substr($payment->student->name ?? '?', 0, 1)) }}</div>
                                    <div>
                                        <div class="student-name">{{ $payment->student->name ?? 'Unknown Student' }}</div>
                                        <div class="payment-sub">{{ $payment->reference_number ?? 'No reference' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="amount-cell">₱{{ number_format($payment->amount, 2) }}</td>
                            <td><span class="method-pill">{{ str_replace('_', ' ', $payment->payment_method) }}</span></td>
                            <td>{{ \Illuminate\Support\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                            <td>
                                <span class="badge-status {{ $statusClasses[$payment->status] ?? 'badge-pending' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="action-btn edit" title="Edit"
                                        onclick="openModal('editPaymentModal{{ $payment->id }}')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z"></path>
                                    </svg>
                                </button>

                                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline"
                                      onsubmit="return confirm('Delete this payment record? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Delete">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18"></path>
                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                            <path d="M10 11v6M14 11v6"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Edit Payment Modal --}}
                        <div class="modal-overlay" id="editPaymentModal{{ $payment->id }}">
                            <div class="modal-box">
                                <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5>Edit Payment</h5>
                                        <button type="button" class="modal-close" onclick="closeModal('editPaymentModal{{ $payment->id }}')">✕</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="form-label">Student</label>
                                            <select name="student_id" class="form-select" required>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}" {{ $payment->student_id == $student->id ? 'selected' : '' }}>
                                                        {{ $student->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label class="form-label">Amount</label>
                                                <input type="number" step="0.01" name="amount" class="form-control" value="{{ $payment->amount }}" min="0" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Payment Date</label>
                                                <input type="date" name="payment_date" class="form-control" value="{{ \Illuminate\Support\Carbon::parse($payment->payment_date)->format('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label class="form-label">Method</label>
                                                <select name="payment_method" class="form-select">
                                                    <option value="cash" {{ $payment->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                                                    <option value="gcash" {{ $payment->payment_method === 'gcash' ? 'selected' : '' }}>GCash</option>
                                                    <option value="bank_transfer" {{ $payment->payment_method === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                    <option value="other" {{ $payment->payment_method === 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select">
                                                    <option value="paid" {{ $payment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                    <option value="pending" {{ $payment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="overdue" {{ $payment->status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Reference Number</label>
                                            <input type="text" name="reference_number" class="form-control" value="{{ $payment->reference_number }}" maxlength="50">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Remarks</label>
                                            <input type="text" name="remarks" class="form-control" value="{{ $payment->remarks }}">
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
                                <div class="empty-state">No payments found.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $payments->links() }}
        </div>
    </div>

    {{-- Add Payment Modal --}}
    <div class="modal-overlay" id="addPaymentModal">
        <div class="modal-box">
            <form action="{{ route('admin.payments.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Add New Payment</h5>
                    <button type="button" class="modal-close" onclick="closeModal('addPaymentModal')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Student</label>
                        <select name="student_id" class="form-select" required>
                            <option value="">Select a student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Amount</label>
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" min="0" required>
                            @error('amount')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Payment Date</label>
                            <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date') }}" required>
                            @error('payment_date')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="gcash" {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>GCash</option>
                                <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="other" {{ old('payment_method') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="paid" {{ old('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="overdue" {{ old('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Reference Number</label>
                        <input type="text" name="reference_number" class="form-control" value="{{ old('reference_number') }}" maxlength="50">
                        @error('reference_number')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Remarks</label>
                        <input type="text" name="remarks" class="form-control" value="{{ old('remarks') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-light" onclick="closeModal('addPaymentModal')">Cancel</button>
                    <button type="submit" class="btn-save">Add Payment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

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

        @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('addPaymentModal'));
        @endif
    </script>

</body>
</html>