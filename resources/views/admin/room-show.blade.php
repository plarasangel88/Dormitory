<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room {{ $room->room_number }} - Dorm Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('admin.partials.theme')
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; }
        .app-container { display: flex; min-height: 100vh; }
        .sidebar { display: flex; flex-direction: column; }
        .main-content { min-width: 0; flex: 1; }
        .top-header { display: flex; justify-content: space-between; align-items: center; }
        .top-header .admin-profile-badge { display: flex !important; flex-direction: row; align-items: center; gap: 10px; flex-shrink: 0; }
        .top-header .avatar { display: flex; align-items: center; justify-content: center; }
        .top-header .user-info { display: flex; flex-direction: column; }
        .dashboard-body { padding: 30px 35px; }
        .detail-heading { display: flex; align-items: center; justify-content: space-between; gap: 18px; flex-wrap: wrap; margin-bottom: 24px; }
        .detail-heading h1 { margin: 0; }
        .detail-heading p { margin: 6px 0 0; color: var(--slate); font-size: 13px; }
        .back-link { display: inline-flex; align-items: center; gap: 8px; border-radius: 9px; padding: 11px 15px; background: var(--navy-deep); color: #fff; text-decoration: none; font-size: 12px; font-weight: 600; }
        .room-summary { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; margin-bottom: 22px; }
        .summary-card, .roster-card { background: #fff; border: 1px solid var(--border-color); border-radius: 14px; padding: 20px; box-shadow: 0 5px 20px #172b4d0f; }
        .summary-label { display: block; color: var(--slate); font-size: 10px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
        .summary-value { display: block; margin-top: 7px; color: var(--navy-deep); font-size: 23px; font-weight: 700; }
        .roster-card h2 { margin: 0 0 6px; color: var(--navy-deep); font-size: 17px; }
        .roster-card > p { margin: 0 0 14px; color: var(--slate); font-size: 12px; }
        .table-responsive { overflow-x: auto; }
        .tenant-table { width: 100%; border-collapse: collapse; }
        .tenant-table th, .tenant-table td { padding: 13px 11px; border-bottom: 1px solid var(--border-color); text-align: left; font-size: 12px; }
        .tenant-table th { background: #f6f7fa; color: var(--slate); font-size: 10px; letter-spacing: .06em; text-transform: uppercase; }
        .tenant-table tr:last-child td { border-bottom: 0; }
        .empty-state { padding: 38px 16px; text-align: center; color: var(--slate); font-size: 13px; }
        .status-pill { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #e1efe6; color: #327049; font-size: 10px; font-weight: 700; text-transform: capitalize; }
        @media (max-width: 850px) { .app-container { flex-direction: column; } .sidebar { width: 100% !important; min-width: 0 !important; min-height: auto !important; height: auto !important; position: relative !important; } .sidebar-menu { flex-direction: row !important; flex-wrap: wrap; } .room-summary { grid-template-columns: 1fr; } .dashboard-body { padding: 22px 16px !important; } }
    </style>
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-brand"><i class="fa-solid fa-building-user"></i><span>Dorm Portal</span></div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a href="{{ route('admin.students.index') }}" class="menu-item"><i class="fa-solid fa-user-graduate"></i> Students</a>
                <a href="{{ route('admin.rooms.index') }}" class="menu-item active"><i class="fa-solid fa-door-closed"></i> Rooms</a>
                <a href="{{ route('admin.payments.index') }}" class="menu-item"><i class="fa-solid fa-wallet"></i> Payments &amp; Billing</a>
                <a href="{{ route('admin.maintenance.index') }}" class="menu-item"><i class="fa-solid fa-wrench"></i> Maintenance</a>
            </nav>
            <div class="sidebar-footer"><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button></form></div>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="admin-page-heading"><strong>Room {{ $room->room_number }}</strong><small>Room assignment and tenant details</small></div>
                <form method="GET" action="{{ route('admin.rooms.index') }}" class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by room number..." aria-label="Search rooms">
                </form>
                <div class="admin-profile-badge"><div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div><div class="user-info"><span class="user-name">{{ auth()->user()->name }}</span><span class="user-role">ADMIN</span></div></div>
            </header>
            <div class="dashboard-body">
                <div class="detail-heading">
                    <div><h1>Room {{ $room->room_number }}</h1><p>Room details and tenants assigned specifically to this room.</p></div>
                    <a class="back-link" href="{{ route('admin.rooms.index') }}"><i class="fa-solid fa-arrow-left"></i> Back to rooms</a>
                </div>

                <section class="room-summary" aria-label="Room summary">
                    <div class="summary-card"><span class="summary-label">Room number</span><strong class="summary-value">{{ $room->room_number }}</strong></div>
                    <div class="summary-card"><span class="summary-label">Bed occupancy</span><strong class="summary-value">{{ $room->students->count() }} / {{ $room->capacity }}</strong></div>
                    <div class="summary-card"><span class="summary-label">Room status</span><strong class="summary-value"><span class="status-pill">{{ $room->status }}</span></strong></div>
                </section>

                <section class="roster-card">
                    <h2><i class="fa-solid fa-users"></i> Tenants in Room {{ $room->room_number }}</h2>
                    <p>This roster includes only students whose room assignment is Room {{ $room->room_number }}.</p>
                    @if ($room->students->isNotEmpty())
                        <div class="table-responsive">
                            <table class="tenant-table">
                                <thead><tr><th>Tenant</th><th>Course</th><th>Email</th><th>Contact number</th><th>Status</th></tr></thead>
                                <tbody>
                                    @foreach ($room->students as $tenant)
                                        <tr>
                                            <td><strong>{{ $tenant->name }}</strong></td>
                                            <td>{{ $tenant->course ?: '—' }}</td>
                                            <td>{{ $tenant->email ?: '—' }}</td>
                                            <td>{{ $tenant->contact_number ?: '—' }}</td>
                                            <td><span class="status-pill">{{ $tenant->status ?: 'active' }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state"><i class="fa-solid fa-bed"></i><br>No tenants are assigned to this room.</div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</body>
</html>
