<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Dorm Portal</title>
    <!-- FontAwesome Icons (same as Admin Dashboard) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Theme base — identical to Admin Dashboard */
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

        /* Sidebar Navigation — identical structure/skin to Admin Dashboard */
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

        /* Info / metric-style cards — same visual language as Admin's key metrics */
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
            text-transform: capitalize;
        }

        /* Main Dashboard Sections */
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
        }

        .card-panel h3 i {
            color: var(--amber);
        }

        /* Quick Actions Grid — identical to Admin Dashboard */
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
            text-decoration: none;
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

        @media (max-width: 860px) {
            .app-container { flex-direction: column; }
            .sidebar {
                width: 100%;
                flex-direction: row;
                align-items: center;
                padding: 16px 20px;
                overflow-x: auto;
            }
            .sidebar-brand { margin-bottom: 0; padding-left: 0; margin-right: 16px; }
            .sidebar-menu { flex-direction: row; }
            .sidebar-footer { padding-top: 0; border-top: none; margin-left: 12px; }
            .quick-actions-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation (same skin as Admin Dashboard; links unchanged) -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <i class="fa-solid fa-building-user"></i>
                <span>Dorm Portal</span>
            </div>
            <nav class="sidebar-menu">
                <a href="/dashboard" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                <a href="/room" class="menu-item {{ request()->is('room*') ? 'active' : '' }}">
                    <i class="fa-solid fa-door-closed"></i> My Room
                </a>
                <a href="/payments" class="menu-item {{ request()->is('payments*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wallet"></i> Payments
                </a>
                <a href="/maintenance" class="menu-item {{ request()->is('maintenance*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wrench"></i> Maintenance
                </a>
                <a href="/profile" class="menu-item {{ request()->is('profile*') ? 'active' : '' }}">
                    <i class="fa-solid fa-circle-user"></i> Profile
                </a>
            </nav>
            <div class="sidebar-footer">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="main-content">
            <!-- Header Bar (same skin as Admin Dashboard) -->
            <header class="top-header">
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="admin-profile-badge">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ strtoupper(auth()->user()->role) }}</span>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-body">
                <div class="welcome-banner">
                    <h1>Welcome, {{ auth()->user()->name }}!</h1>
                    <p>Here's a quick look at your dormitory account.</p>
                </div>

                <!-- Account Info (same card style as Admin's key metrics; informational only) -->
                <section class="metrics-grid">
                    <div class="metric-card">
                        <div class="metric-icon blue"><i class="fa-solid fa-graduation-cap"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">COURSE</span>
                            <div class="metric-value">{{ auth()->user()->course }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon orange"><i class="fa-solid fa-user"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">USERNAME</span>
                            <div class="metric-value">{{ auth()->user()->username }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon purple"><i class="fa-solid fa-id-badge"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">ROLE</span>
                            <div class="metric-value">{{ auth()->user()->role }}</div>
                        </div>
                    </div>
                </section>

                <!-- Quick Actions Panel (same style/behavior as Admin Dashboard) -->
                <div class="card-panel">
                    <h3><i class="fa-solid fa-bolt"></i> Quick Actions</h3>
                    <div class="quick-actions-grid">
                        <a href="/room" class="action-btn">
                            <i class="fa-solid fa-door-closed"></i> My Room
                        </a>
                        <a href="/payments" class="action-btn">
                            <i class="fa-solid fa-wallet"></i> Payments
                        </a>
                        <a href="/maintenance" class="action-btn">
                            <i class="fa-solid fa-wrench"></i> Maintenance
                        </a>
                        <a href="/profile" class="action-btn">
                            <i class="fa-solid fa-circle-user"></i> Profile
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>