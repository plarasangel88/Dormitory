<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f6f9f7; display: flex; min-height: 100vh; color: #1f2937; }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #e5efe9;
            padding: 28px 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 12px rgba(0,0,0,0.02);
            transition: width 0.25s ease, padding 0.25s ease;
            overflow: hidden;
            white-space: nowrap;
        }
        .sidebar.collapsed {
            width: 76px;
            padding: 28px 0;
        }

        .sidebar .logo {
            font-size: 19px;
            font-weight: 700;
            color: #14532d;
            padding: 0 26px 24px;
            border-bottom: 1px solid #eef2ef;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.2s ease;
        }
        .sidebar.collapsed .logo-text { display: none; }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 26px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.18s ease;
        }
        .sidebar nav a:hover {
            background-color: #f0faf3;
            color: #15803d;
        }
        .sidebar nav a.active {
            background-color: #ecfdf3;
            color: #15803d;
            border-left: 3px solid #22c55e;
            font-weight: 600;
        }
        .sidebar.collapsed nav a .link-text { display: none; }
        .sidebar.collapsed nav a {
            justify-content: center;
            padding: 13px 0;
        }

        .sidebar .logout-form {
            margin-top: auto;
            padding: 0 26px;
        }
        .sidebar.collapsed .logout-form { padding: 0 16px; }
        .btn-logout {
            width: 100%;
            padding: 11px;
            background-color: #ffffff;
            color: #6b7280;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s ease;
            white-space: nowrap;
            overflow: hidden;
        }
        .btn-logout:hover {
            background-color: #fef2f2;
            color: #b91c1c;
            border-color: #fca5a5;
        }

        /* Toggle button */
        .toggle-btn {
            position: absolute;
            top: 28px;
            right: -14px;
            width: 28px;
            height: 28px;
            background-color: #22c55e;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(34, 197, 94, 0.3);
            transition: background-color 0.15s ease, transform 0.25s ease;
            z-index: 10;
        }
        .toggle-btn:hover { background-color: #15803d; }
        .sidebar.collapsed .toggle-btn { transform: rotate(180deg); }

        .sidebar-wrapper {
            position: relative;
        }

        /* Main content */
        .main {
            flex: 1;
            padding: 40px 48px;
            transition: margin 0.25s ease;
        }
        .main h1 {
            font-size: 24px;
            color: #111827;
            margin-bottom: 6px;
            font-weight: 700;
        }
        .main p.sub {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 32px;
        }

        /* Info cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 18px;
            margin-bottom: 40px;
        }
        .info-card {
            background: #ffffff;
            border: 1px solid #e5efe9;
            border-left: 4px solid #22c55e;
            border-radius: 10px;
            padding: 20px 22px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(34, 197, 94, 0.08);
        }
        .info-card .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #9ca3af;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .info-card .value {
            font-size: 17px;
            font-weight: 700;
            color: #14532d;
        }

        /* Quick actions */
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #14532d;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title::before {
            content: "";
            width: 4px;
            height: 16px;
            background-color: #22c55e;
            border-radius: 2px;
        }
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 18px;
        }
        .action-card {
            background: #ffffff;
            border: 1px solid #e5efe9;
            border-radius: 12px;
            padding: 22px;
            text-decoration: none;
            color: #374151;
            transition: all 0.2s ease;
        }
        .action-card:hover {
            border-color: #22c55e;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.12);
            transform: translateY(-3px);
        }
        .action-card .icon {
            font-size: 24px;
            margin-bottom: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background-color: #ecfdf3;
            border-radius: 10px;
        }
        .action-card .title {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }
        .action-card .desc {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <div class="sidebar" id="sidebar">
            <button class="toggle-btn" id="toggleBtn" title="Toggle sidebar">◀</button>
            <div class="logo">
                🏢 <span class="logo-text">Dorm Portal</span>
            </div>
            <nav>
                <a href="/dashboard" class="active">🏠 <span class="link-text">Dashboard</span></a>
                <a href="/room">🛏️ <span class="link-text">My Room</span></a>
                <a href="/payments">💳 <span class="link-text">Payments</span></a>
                <a href="/maintenance">🔧 <span class="link-text">Maintenance</span></a>
                <a href="/profile">👤 <span class="link-text">Profile</span></a>
            </nav>
            <div class="logout-form">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main">
        <h1>Welcome, {{ auth()->user()->name }}! 👋</h1>
        <p class="sub">Here's a quick look at your dormitory account.</p>

        <div class="info-grid">
            <div class="info-card">
                <div class="label">Course</div>
                <div class="value">{{ auth()->user()->course }}</div>
            </div>
            <div class="info-card">
                <div class="label">Username</div>
                <div class="value">{{ auth()->user()->username }}</div>
            </div>
            <div class="info-card">
                <div class="label">Role</div>
                <div class="value" style="text-transform: capitalize;">{{ auth()->user()->role }}</div>
            </div>
        </div>

        <div class="section-title">Quick Actions</div>
        <div class="actions-grid">
            <a href="/room" class="action-card">
                <span class="icon">🛏️</span>
                <div class="title">My Room</div>
                <div class="desc">View room assignment</div>
            </a>
            <a href="/payments" class="action-card">
                <span class="icon">💳</span>
                <div class="title">Payments</div>
                <div class="desc">Check dues & history</div>
            </a>
            <a href="/maintenance" class="action-card">
                <span class="icon">🔧</span>
                <div class="title">Maintenance</div>
                <div class="desc">Report an issue</div>
            </a>
            <a href="/profile" class="action-card">
                <span class="icon">👤</span>
                <div class="title">Profile</div>
                <div class="desc">Update your info</div>
            </a>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>

</body>
</html>