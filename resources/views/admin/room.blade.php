<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms - Dorm Portal</title>
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
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
            flex-wrap: wrap;
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

        /* Primary button */
        .action-btn {
            padding: 10px 16px;
            background-color: var(--navy-deep);
            border: 1.5px solid var(--navy-deep);
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #FFF;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .action-btn i { color: var(--amber); }

        .action-btn:hover {
            background-color: var(--navy-mid);
            border-color: var(--navy-mid);
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
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .row-title { font-weight: 600; color: var(--navy-deep); }
        .row-sub { color: var(--text-secondary); font-size: 0.75rem; margin-top: 1px; }

        .status-pill {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            display: inline-block;
        }

        .status-pill.available { background-color: #E1EFE6; color: #327049; }
        .status-pill.occupied { background-color: #FBEBD4; color: #A9721F; }
        .status-pill.full { background-color: #F6E2DD; color: #A8412B; }
        .status-pill.maintenance { background-color: #F6E2DD; color: #A8412B; }

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

        .bed-summary-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 22px; }
        .bed-summary-card { padding: 18px 20px; background: #fff; border: 1px solid var(--border-color); border-radius: 14px; box-shadow: 0 5px 20px #172b4d0f; }
        .bed-summary-label { display: block; color: var(--text-secondary); font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
        .bed-summary-value { display: block; margin-top: 7px; color: var(--navy-deep); font-size: 23px; font-weight: 700; }
        @media (max-width: 760px) { .bed-summary-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 420px) { .bed-summary-grid { grid-template-columns: 1fr; } }

        /* Responsive */
        @media (max-width: 1024px) {
            .app-container { flex-direction: column; }
            .sidebar { width: 100%; }
            .sidebar-menu { flex-direction: row; flex-wrap: wrap; }
            .top-header { flex-wrap: wrap; }
            .search-bar { width: 100%; }
            .dashboard-body { padding: 24px 20px; }
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
                <div class="admin-page-heading"><strong>Rooms</strong><small>Manage dormitory rooms</small></div>
                <form method="GET" class="search-bar" role="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by room number..." aria-label="Search rooms">
                    <button type="submit" aria-label="Search rooms"><i class="fa-solid fa-arrow-right"></i></button>
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
                    <div>
                        <div class="banner-feature-name" role="heading" aria-level="1">Rooms Management</div>
                        <p>View, add, edit, and remove dormitory rooms.</p>
                    </div>
                    <button type="button" class="action-btn" onclick="openModal('addRoomModal')">
                        <i class="fa-solid fa-plus"></i> Add Room
                    </button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
                @endif

                <section class="bed-summary-grid" aria-label="Dormitory bed occupancy summary">
                    <div class="bed-summary-card"><span class="bed-summary-label">Rooms</span><strong class="bed-summary-value">{{ $totalRooms }}</strong></div>
                    <div class="bed-summary-card"><span class="bed-summary-label">Total beds</span><strong class="bed-summary-value">{{ $totalBeds }}</strong></div>
                    <div class="bed-summary-card"><span class="bed-summary-label">Occupied beds ({{ $occupancyRate }}%)</span><strong class="bed-summary-value">{{ $occupiedBeds }}</strong></div>
                    <div class="bed-summary-card"><span class="bed-summary-label">Vacant beds</span><strong class="bed-summary-value">{{ $vacantBeds }}</strong></div>
                </section>

                <div class="card-panel">
                    <div class="panel-header">
                        <h3><i class="fa-solid fa-door-closed"></i> Room Directory</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Room</th>
                                    <th>Capacity</th>
                                    <th>Beds Occupied</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms as $room)
                                    @php
                                        $roomIsFull = $room->students_count >= $room->capacity;
                                        $displayStatus = $room->status === 'maintenance'
                                            ? 'maintenance'
                                            : ($roomIsFull ? 'full' : $room->status);
                                        $statusClasses = [
                                            'available'   => 'available',
                                            'occupied'    => 'occupied',
                                            'full'        => 'full',
                                            'maintenance' => 'maintenance',
                                        ];
                                        $statusLabels = [
                                            'available'   => 'Available',
                                            'occupied'    => 'Occupied',
                                            'full'        => 'Full / Not Available',
                                            'maintenance' => 'Maintenance',
                                        ];
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="row-cell">
                                                <div class="row-avatar">{{ strtoupper(substr($room->room_number, 0, 2)) }}</div>
                                                <div>
                                                    <a href="{{ route('admin.rooms.show', $room) }}" class="row-title" style="text-decoration:none" aria-label="View tenants in room {{ $room->room_number }}">Room {{ $room->room_number }}</a>
                                                    <div class="row-sub">Click to view room details and tenants</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $room->capacity }}</td>
                                        <td>{{ $room->students_count }} / {{ $room->capacity }}</td>
                                        <td>
                                            <span class="status-pill {{ $statusClasses[$displayStatus] ?? 'available' }}">
                                                {{ $statusLabels[$displayStatus] ?? ucfirst($displayStatus) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="icon-btn edit" title="Edit"
                                                    onclick="openModal('editRoomModal{{ $room->id }}')">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" style="display:inline"
                                                  onsubmit="return confirm('Delete room {{ $room->room_number }}? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="icon-btn delete" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Edit Room Modal --}}
                                    <div class="modal-overlay" id="editRoomModal{{ $room->id }}">
                                        <div class="modal-card">
                                            <form action="{{ route('admin.rooms.update', $room) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h3><i class="fa-solid fa-pen"></i> Edit Room</h3>
                                                    <button type="button" class="modal-close" onclick="closeModal('editRoomModal{{ $room->id }}')">✕</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="form-label">Room Number</label>
                                                        <input type="text" name="room_number" class="form-control" value="{{ $room->room_number }}" maxlength="20" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Capacity</label>
                                                        <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" min="1" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Available</option>
                                                            <option value="occupied" {{ $room->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                                                            <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn-light" onclick="closeModal('editRoomModal{{ $room->id }}')">Cancel</button>
                                                    <button type="submit" class="btn-save">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">No rooms found.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Add Room Modal --}}
    <div class="modal-overlay" id="addRoomModal">
        <div class="modal-card">
            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h3><i class="fa-solid fa-plus"></i> Add New Room</h3>
                    <button type="button" class="modal-close" onclick="closeModal('addRoomModal')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Room Number</label>
                        <input type="text" name="room_number" class="form-control" value="{{ old('room_number') }}" maxlength="20" required>
                        @error('room_number')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Capacity</label>
                        <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}" min="1" required>
                        @error('capacity')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ old('status') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-light" onclick="closeModal('addRoomModal')">Cancel</button>
                    <button type="submit" class="btn-save">Add Room</button>
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

        @if ($errors->any())
        // Re-open Add Room modal automatically if validation failed on submit
        document.addEventListener('DOMContentLoaded', () => openModal('addRoomModal'));
        @endif
    </script>
</body>
</html>
