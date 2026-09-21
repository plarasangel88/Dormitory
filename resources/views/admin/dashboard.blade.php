<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dorm Portal - Admin Dashboard</title>
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

            /* Status & Accent Colors (kept semantic, warmed to fit the palette) */
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

        /* Dashboard Container */
        .dashboard-body {
            padding: 32px;
            overflow-y: auto;
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
            margin-bottom: 24px;
            font-size: 0.92rem;
        }

        /* 8.1 Key Metrics Grid */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .metric-card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        /* Clickable metric cards: same look, plus a hover/focus lift so
           it's obvious these now link somewhere. */
        a.metric-card {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
        }

        a.metric-card:hover,
        a.metric-card:focus-visible {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -10px rgba(22, 33, 62, 0.25);
            border-color: var(--amber-soft);
            outline: none;
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .metric-icon.blue { background-color: #EAEEF7; color: var(--primary-blue); }
        .metric-icon.orange { background-color: #FBEBD4; color: var(--warning-orange); }
        .metric-icon.green { background-color: #E1EFE6; color: var(--success-green); }
        .metric-icon.purple { background-color: #EBE7F4; color: var(--purple-accent); }
        .metric-icon.red { background-color: #F6E2DD; color: var(--danger-red); }
        .metric-icon.teal { background-color: #DFEEED; color: var(--teal-accent); }

        .metric-title {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--text-secondary);
            letter-spacing: 0.6px;
        }

        .metric-value {
            font-family: 'Fraunces', serif;
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-top: 4px;
        }

        .metric-value small {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            font-weight: normal;
            color: var(--text-secondary);
        }

        /* Main Dashboard Sections */
        .dashboard-main-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 24px;
        }

        .card-panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        .margin-top {
            margin-top: 24px;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
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

        /* Quick Actions Grid */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 12px;
        }

        .action-btn {
            padding: 12px 16px;
            background-color: var(--paper);
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background-color: var(--navy-deep);
            color: #FFF;
            border-color: var(--navy-deep);
        }

        .action-btn:hover i {
            color: var(--amber);
        }

        /* 8.2 Activity Feed */
        .live-badge {
            background-color: #E1EFE6;
            color: var(--success-green);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .activity-feed {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 8px;
        }

        .feed-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .feed-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .feed-icon.green { background-color: #E1EFE6; color: var(--success-green); }
        .feed-icon.orange { background-color: #FBEBD4; color: var(--warning-orange); }
        .feed-icon.blue { background-color: #EAEEF7; color: var(--primary-blue); }

        .feed-content p {
            font-size: 0.85rem;
            color: var(--text-primary);
            line-height: 1.3;
        }

        .feed-content small {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* 8.3 Payment Table */
        .view-all-link {
            font-size: 0.8rem;
            color: var(--navy-deep);
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1.5px solid var(--amber);
            padding-bottom: 1px;
        }

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
        }

        .data-table th {
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .data-table tbody tr {
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .data-table tbody tr:hover {
            background-color: var(--paper);
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            display: inline-block;
        }

        .status-pill.pending { background-color: #FBEBD4; color: #A9721F; }
        .status-pill.paid { background-color: #E1EFE6; color: #327049; }
        .status-pill.unpaid { background-color: #F6E2DD; color: #A8412B; }

        .table-btn {
            padding: 6px 12px;
            border: none;
            background-color: var(--navy-deep);
            color: #FFF;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .table-btn.secondary {
            background-color: var(--paper);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .table-btn:hover {
            background-color: var(--navy-mid);
        }

        .table-btn.secondary:hover {
            background-color: #F0ECE2;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(22, 33, 62, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-card {
            background: var(--paper);
            padding: 28px;
            border-radius: 16px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid var(--border-color);
            box-shadow: 0 30px 70px -28px rgba(0, 0, 0, 0.5);
        }

        .modal-card h3 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--text-primary);
        }

        .modal-card p {
            font-size: 0.85rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .qr-placeholder {
            width: 180px;
            height: 180px;
            margin: 18px auto;
            border: 2px dashed var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--slate);
            border-radius: 10px;
            background: #FFFFFF;
        }

        .close-modal-btn {
            padding: 10px 20px;
            background-color: var(--navy-deep);
            color: var(--paper);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 8px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .close-modal-btn:hover {
            background-color: var(--navy-mid);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .dashboard-main-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
            <!-- Header Bar -->
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

            <!-- Dashboard Content -->
            <div class="dashboard-body">
                <div class="welcome-banner">
                    <h1>Welcome, {{ auth()->user()->name }}!</h1>
                    <p>Here's an overview of the dormitory system status today.</p>
                </div>

                <!-- 8.1 Key Metrics Overview (each card now links to its related page) -->
                <section class="metrics-grid">
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
                    <a href="{{ route('admin.rooms.index') }}" class="metric-card">
                        <div class="metric-icon green"><i class="fa-solid fa-chart-pie"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">OCCUPANCY RATE</span>
                            <div class="metric-value">{{ $occupancyRate ?? 0 }}% <small>({{ $occupiedRooms ?? 0 }} Occupied)</small></div>
                        </div>
                    </a>
                    <a href="/admin/payments" class="metric-card">
                        <div class="metric-icon purple"><i class="fa-solid fa-calendar-check"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">MONTHLY BOOKINGS</span>
                            <div class="metric-value">{{ $monthlyBookings ?? 0 }}</div>
                        </div>
                    </a>
                    <a href="/admin/payments?status=pending" class="metric-card">
                        <div class="metric-icon red"><i class="fa-solid fa-clock"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">PENDING PAYMENTS</span>
                            <div class="metric-value">{{ $pendingPayments ?? 0 }}</div>
                        </div>
                    </a>
                    <a href="/admin/payments?status=paid" class="metric-card">
                        <div class="metric-icon teal"><i class="fa-solid fa-peso-sign"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">TOTAL COLLECTED</span>
                            <div class="metric-value">₱{{ number_format($totalCollected ?? 0, 2) }}</div>
                        </div>
                    </a>
                </section>

                <!-- Core Grid -->
                <section class="dashboard-main-grid">
                    <!-- Left Column -->
                    <div class="left-column">
                        <!-- Quick Actions Panel -->
                        <div class="card-panel">
                            <h3><i class="fa-solid fa-bolt"></i> Quick Actions</h3>
                            <div class="quick-actions-grid">
                                <a href="{{ route('admin.students.index') }}" class="action-btn" style="text-decoration:none;">
                                    <i class="fa-solid fa-user-plus"></i> Add Student
                                </a>
                                <a href="{{ route('admin.rooms.index') }}" class="action-btn" style="text-decoration:none;">
                                    <i class="fa-solid fa-door-open"></i> Assign Room
                                </a>
                                <button class="action-btn" onclick="openScanner()" type="button">
                                    <i class="fa-solid fa-qrcode"></i> Scan Payment Code
                                </button>
                                <a href="/admin/payments" class="action-btn" style="text-decoration:none;">
                                    <i class="fa-solid fa-file-invoice"></i> Print Receipt
                                </a>
                            </div>
                        </div>

                        <!-- 8.2 Dormitory Activity Feed -->
                        <div class="card-panel margin-top">
                            <div class="panel-header">
                                <h3><i class="fa-solid fa-stream"></i> Dormitory Activity Feed</h3>
                                <span class="badge live-badge">Live Updates</span>
                            </div>
                            <ul class="activity-feed">
                                @forelse ($activityFeed ?? [] as $activity)
                                    <li class="feed-item">
                                        <span class="feed-icon {{ $activity['color'] ?? 'blue' }}">
                                            <i class="fa-solid {{ $activity['icon'] ?? 'fa-circle-info' }}"></i>
                                        </span>
                                        <div class="feed-content">
                                            <p>{!! $activity['message'] !!}</p>
                                            <small>{{ $activity['time'] }}</small>
                                        </div>
                                    </li>
                                @empty
                                    <li class="feed-item">
                                        <div class="feed-content">
                                            <p>No recent activity.</p>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Right Column: 8.3 Student Payment Monitoring -->
                    <div class="right-column">
                        <div class="card-panel">
                            <div class="panel-header">
                                <h3><i class="fa-solid fa-file-invoice-dollar"></i> Student Payment Monitoring</h3>
                                <a href="/admin/payments" class="view-all-link">View All Records</a>
                            </div>
                            <div class="table-responsive">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Room</th>
                                            <th>Amount Due</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($paymentMonitoring ?? [] as $payment)
                                            <tr onclick="window.location='/admin/payments/{{ $payment->id }}'">
                                                <td><strong>{{ $payment->student_name }}</strong></td>
                                                <td>{{ $payment->room_number ?? 'Unassigned' }}</td>
                                                <td>₱{{ number_format($payment->amount_due, 2) }}</td>
                                                <td>
                                                    <span class="status-pill {{ strtolower($payment->status) }}">
                                                        {{ ucfirst($payment->status) }}
                                                    </span>
                                                </td>
                                                <td onclick="event.stopPropagation()">
                                                    @if (strtolower($payment->status) === 'pending')
                                                        <button class="table-btn" onclick="openScanner()" type="button">
                                                            <i class="fa-solid fa-qrcode"></i> Scan
                                                        </button>
                                                    @elseif (strtolower($payment->status) === 'paid')
                                                        <button class="table-btn secondary" type="button">
                                                            <i class="fa-solid fa-receipt"></i> Print
                                                        </button>
                                                    @else
                                                        <button class="table-btn secondary" type="button">
                                                            <i class="fa-solid fa-bell"></i> Remind
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" style="text-align:center; color: var(--text-secondary);">
                                                    No payment records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Payment Code Scanner Modal (5.3 Admin Code Scan Demo) -->
    <div class="modal-overlay" id="scannerModal">
        <div class="modal-card">
            <h3><i class="fa-solid fa-qrcode"></i> Payment Code Scanner</h3>
            <p>Place student's Payment QR or Barcode in front of camera to process cash confirmation.</p>
            <div class="qr-placeholder">
                <i class="fa-solid fa-barcode"></i>
            </div>
            <button class="close-modal-btn" onclick="closeScanner()">Close Scanner</button>
        </div>
    </div>

    <!-- Embedded Interactivity Scripts -->
    <script>
        function openScanner() {
            document.getElementById('scannerModal').style.display = 'flex';
        }

        function closeScanner() {
            document.getElementById('scannerModal').style.display = 'none';
        }
    </script>
</body>
</html>