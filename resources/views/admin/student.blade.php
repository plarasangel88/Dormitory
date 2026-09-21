<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Dorm Portal</title>
    <!-- FontAwesome Icons (same as Dashboard) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Theme base — identical to Dashboard */
            --navy-deep: #16213E;
            --navy-mid: #24345C;
            --navy-soft: #3A4E7A;
            --amber: #F0A857;
            --amber-soft: #F6C98B;
            --amber-tint: #FCEEDA;
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
            --success-tint: #E1EFE6;
            --warning-orange: var(--amber);
            --danger-red: #C4573E;
            --danger-tint: #F6E2DD;
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

        /* Sidebar Navigation — copied from Dashboard */
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

        .search-bar button {
            border: none;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
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

        /* Body Container */
        .dashboard-body {
            padding: 32px;
            overflow-y: auto;
        }

        .welcome-banner {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 16px;
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

        .alert-success {
            background-color: var(--success-tint);
            color: #327049;
            border: 1px solid rgba(78, 154, 107, 0.3);
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Danger alert variant — used for room-capacity / validation errors */
        .alert-danger {
            background-color: var(--danger-tint);
            color: #A8412B;
            border: 1px solid rgba(196, 87, 62, 0.3);
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 14px;
            flex-wrap: wrap;
        }

        .toolbar .search-bar {
            width: 320px;
        }

        .btn-add {
            padding: 12px 20px;
            background-color: var(--navy-deep);
            color: #FFF;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-add:hover {
            background-color: var(--navy-mid);
        }

        .btn-add i {
            color: var(--amber);
        }

        /* Card panel (from Dashboard) used to wrap the table */
        .card-panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        .card-panel h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .card-panel h3 i {
            color: var(--amber);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th, .data-table td {
            padding: 14px 12px;
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

        .data-table tbody tr:hover {
            background-color: #FCFAF6;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .student-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .student-email {
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin-top: 1px;
        }

        /* Clickable student box (avatar + name + email) */
        .student-cell.clickable {
            cursor: pointer;
            padding: 8px 12px;
            margin: -8px -12px;
            border-radius: 10px;
            transition: background-color 0.15s ease;
        }

        .student-cell.clickable:hover,
        .student-cell.clickable:focus-visible {
            background-color: var(--amber-tint);
            outline: none;
        }

        .student-cell.clickable:hover .student-name,
        .student-cell.clickable:focus-visible .student-name {
            color: #B4741F;
        }

        .contact-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-primary);
        }

        .contact-cell i {
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        .room-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--navy-deep);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1.5px solid var(--amber-soft);
            padding-bottom: 1px;
            transition: color 0.15s ease, border-color 0.15s ease;
        }

        .room-link:hover {
            color: #B4741F;
            border-color: var(--amber);
        }

        .room-link i { font-size: 0.75rem; }

        .text-unassigned {
            color: var(--text-secondary);
            font-style: italic;
            font-size: 0.82rem;
        }

        /* Status pill, matching Dashboard's pill language */
        .status-pill {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pill.active { background-color: var(--success-tint); color: #327049; }
        .status-pill.inactive { background-color: var(--danger-tint); color: #A8412B; }
        .status-pill i { font-size: 0.6rem; }

        /* Action buttons, matching Dashboard's table-btn language */
        .table-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-btn {
            padding: 7px 10px;
            border: none;
            background-color: var(--navy-deep);
            color: #FFF;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .table-btn.secondary {
            background-color: var(--paper);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .table-btn.danger {
            background-color: var(--paper);
            color: var(--danger-red);
            border: 1px solid var(--danger-tint);
        }

        .table-btn:hover { background-color: var(--navy-mid); }
        .table-btn.secondary:hover { background-color: #F0ECE2; }
        .table-btn.danger:hover { background-color: var(--danger-tint); }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .empty-state i {
            font-size: 1.8rem;
            color: var(--border-color);
            display: block;
            margin-bottom: 10px;
        }

        .pagination-wrap {
            margin-top: 18px;
            display: flex;
            justify-content: flex-end;
            font-size: 0.85rem;
        }

        /* Modal styles, matching Dashboard's modal language */
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

        .modal-overlay.open {
            display: flex;
        }

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
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-header h3 i { color: var(--amber); }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.1rem;
            color: var(--text-secondary);
            cursor: pointer;
            line-height: 1;
        }

        .modal-body {
            padding: 20px 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            color: var(--text-primary);
            background: #FFF;
            outline: none;
            transition: border-color 0.15s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--amber);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px 22px;
        }

        .btn-light {
            padding: 10px 18px;
            background-color: #FFF;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-light:hover { background-color: var(--paper); }

        .btn-save {
            padding: 10px 18px;
            background-color: var(--navy-deep);
            border: none;
            color: var(--paper);
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save:hover { background-color: var(--navy-mid); }

        /* View-student modal */
        .detail-hero {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-hero .avatar {
            width: 52px;
            height: 52px;
            font-size: 1.3rem;
        }

        .detail-hero .detail-name {
            font-family: 'Fraunces', serif;
            font-size: 1.15rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .detail-hero .detail-email {
            color: var(--text-secondary);
            font-size: 0.8rem;
            margin-top: 2px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 11px 0;
            border-bottom: 1px dashed var(--border-color);
            font-size: 0.85rem;
        }

        .detail-row:last-child { border-bottom: none; }

        .detail-row .detail-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .detail-row .detail-label i {
            color: var(--amber);
            width: 14px;
            text-align: center;
        }

        .detail-row .detail-value {
            color: var(--text-primary);
            font-weight: 500;
            text-align: right;
        }

        @media (max-width: 1024px) {
            .toolbar { flex-direction: column; align-items: stretch; }
            .toolbar .search-bar { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation (identical to Dashboard) -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <i class="fa-solid fa-building-user"></i>
                <span>Dorm Portal</span>
            </div>
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
                <a href="/admin/payments" class="menu-item {{ request()->is('admin/payments*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wallet"></i> Payments
                </a>
                <a href="/admin/maintenance" class="menu-item {{ request()->is('admin/maintenance*') ? 'active' : '' }}">
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
            <!-- Header Bar (identical to Dashboard) -->
            <header class="top-header">
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search student name, room #, or ID...">
                </div>
                <div class="admin-profile-badge">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">ADMIN</span>
                    </div>
                </div>
            </header>

            <div class="dashboard-body">
                <div class="welcome-banner">
                    <div>
                        <h1>Manage Students</h1>
                        <p>View, add, edit, and remove student records.</p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                @endif

                {{-- Top-of-page fallback: shows the room-capacity error even if the
                     auto-reopen script below doesn't fire for some reason. --}}
                @error('room_id')
                    <div class="alert-danger"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</div>
                @enderror

                <div class="toolbar">
                    <form method="GET" class="search-bar">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email...">
                        <button type="submit" title="Search"><i class="fa-solid fa-arrow-right"></i></button>
                    </form>

                    <button type="button" class="btn-add" onclick="openModal('addStudentModal')">
                        <i class="fa-solid fa-user-plus"></i> Add Student
                    </button>
                </div>

                <div class="card-panel">
                    <h3><i class="fa-solid fa-user-graduate"></i> Student Records</h3>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Contact</th>
                                    <th>Room</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr>
                                        <td>
                                            <div class="student-cell clickable" role="button" tabindex="0"
                                                 title="View student information"
                                                 onclick="openModal('viewStudentModal{{ $student->id }}')"
                                                 onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); openModal('viewStudentModal{{ $student->id }}'); }">
                                                <div class="avatar">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                                                <div>
                                                    <div class="student-name">{{ $student->name }}</div>
                                                    <div class="student-email">{{ $student->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="contact-cell">
                                                <i class="fa-solid fa-phone"></i> {{ $student->contact_number ?? '—' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($student->room)
                                                <a href="{{ route('admin.rooms.show', $student->room) }}" class="room-link">
                                                    <i class="fa-solid fa-door-closed"></i> {{ $student->room->room_number }}
                                                </a>
                                            @else
                                                <span class="text-unassigned">Unassigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-pill {{ $student->status === 'active' ? 'active' : 'inactive' }}">
                                                <i class="fa-solid fa-circle"></i> {{ ucfirst($student->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <button type="button" class="table-btn secondary" title="Edit"
                                                        onclick="openModal('editStudentModal{{ $student->id }}')">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>

                                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" style="display:inline"
                                                      onsubmit="return confirm('Delete this student?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="table-btn danger" title="Delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- View Modal -->
                                    <div class="modal-overlay" id="viewStudentModal{{ $student->id }}">
                                        <div class="modal-card">
                                            <div class="modal-header">
                                                <h3><i class="fa-solid fa-id-card"></i> Student Information</h3>
                                                <button type="button" class="modal-close" onclick="closeModal('viewStudentModal{{ $student->id }}')">✕</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="detail-hero">
                                                    <div class="avatar">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                                                    <div>
                                                        <div class="detail-name">{{ $student->name }}</div>
                                                        <div class="detail-email">{{ $student->email }}</div>
                                                    </div>
                                                </div>

                                                <div class="detail-row">
                                                    <span class="detail-label"><i class="fa-solid fa-phone"></i> Contact</span>
                                                    <span class="detail-value">{{ $student->contact_number ?? '—' }}</span>
                                                </div>
                                                <div class="detail-row">
                                                    <span class="detail-label"><i class="fa-solid fa-door-closed"></i> Room</span>
                                                    <span class="detail-value">
                                                        @if ($student->room)
                                                            <a href="{{ route('admin.rooms.show', $student->room) }}" class="room-link">
                                                                {{ $student->room->room_number }}
                                                            </a>
                                                        @else
                                                            <span class="text-unassigned">Unassigned</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="detail-row">
                                                    <span class="detail-label"><i class="fa-solid fa-circle-half-stroke"></i> Status</span>
                                                    <span class="detail-value">
                                                        <span class="status-pill {{ $student->status === 'active' ? 'active' : 'inactive' }}">
                                                            <i class="fa-solid fa-circle"></i> {{ ucfirst($student->status) }}
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="detail-row">
                                                    <span class="detail-label"><i class="fa-solid fa-calendar-plus"></i> Registered</span>
                                                    <span class="detail-value">{{ $student->created_at?->format('M d, Y') ?? '—' }}</span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn-light" onclick="closeModal('viewStudentModal{{ $student->id }}')">Close</button>
                                                <button type="button" class="btn-save"
                                                        onclick="closeModal('viewStudentModal{{ $student->id }}'); openModal('editStudentModal{{ $student->id }}')">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal-overlay" id="editStudentModal{{ $student->id }}">
                                        <div class="modal-card">
                                            <form action="{{ route('admin.students.update', $student) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                {{-- Lets the page know which edit modal to reopen if this
                                                     submission comes back with a validation error. --}}
                                                <input type="hidden" name="_editing_student_id" value="{{ $student->id }}">
                                                <div class="modal-header">
                                                    <h3><i class="fa-solid fa-user-pen"></i> Edit Student</h3>
                                                    <button type="button" class="modal-close" onclick="closeModal('editStudentModal{{ $student->id }}')">✕</button>
                                                </div>
                                                <div class="modal-body">
                                                    @error('room_id')
                                                        <div class="alert-danger"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</div>
                                                    @enderror

                                                    <div class="form-group">
                                                        <label class="form-label">Full Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Contact Number</label>
                                                        <input type="text" name="contact_number" class="form-control" value="{{ $student->contact_number }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Room</label>
                                                        <select name="room_id" class="form-select">
                                                            <option value="">Unassigned</option>
                                                            @foreach ($rooms as $room)
                                                                <option value="{{ $room->id }}" {{ $student->room_id == $room->id ? 'selected' : '' }}>
                                                                    {{ $room->room_number }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="active" {{ $student->status === 'active' ? 'selected' : '' }}>Active</option>
                                                            <option value="inactive" {{ $student->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn-light" onclick="closeModal('editStudentModal{{ $student->id }}')">Cancel</button>
                                                    <button type="submit" class="btn-save"><i class="fa-solid fa-check"></i> Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <i class="fa-solid fa-user-slash"></i>
                                                No students found.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pagination-wrap">
                    {{ $students->links() }}
                </div>
            </div>
        </main>
    </div>

    <!-- Add Student Modal -->
    <div class="modal-overlay" id="addStudentModal">
        <div class="modal-card">
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h3><i class="fa-solid fa-user-plus"></i> Add New Student</h3>
                    <button type="button" class="modal-close" onclick="closeModal('addStudentModal')">✕</button>
                </div>
                <div class="modal-body">
                    @error('room_id')
                        <div class="alert-danger"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Room</label>
                        <select name="room_id" class="form-select">
                            <option value="">Unassigned</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->room_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Temporary Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-light" onclick="closeModal('addStudentModal')">Cancel</button>
                    <button type="submit" class="btn-save"><i class="fa-solid fa-user-plus"></i> Add Student</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }
        // Close modal when clicking the dark overlay itself
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) overlay.classList.remove('open');
            });
        });

        // If the page reloaded with a room_id validation error (e.g. room is full),
        // automatically reopen whichever modal the admin was using so they see the alert.
        @if ($errors->has('room_id'))
            @if (old('_editing_student_id'))
                openModal('editStudentModal{{ old('_editing_student_id') }}');
            @else
                openModal('addStudentModal');
            @endif
        @endif
    </script>
</body>
</html>