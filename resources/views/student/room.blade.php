<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Room - Dormitory Management System</title>
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
            --paper: #FBF8F2;
            --ink: #2A2620;
            --slate: #8993A8;
            --line: #E7E2D6;
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
        .sidebar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

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
        .sidebar.collapsed {
            width: 78px;
            padding: 30px 0;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 22px;
        }
        .sidebar .logo .key-badge {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(240, 168, 87, 0.14);
            border: 1px solid rgba(240, 168, 87, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .sidebar .logo-text {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 16.5px;
            color: var(--paper);
            transition: opacity 0.2s ease;
        }
        .sidebar.collapsed .logo-text { display: none; }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
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
            color: inherit;
        }
        .sidebar nav a .link-icon svg {
            display: block;
        }
        .sidebar nav a:hover {
            background-color: rgba(255,255,255,0.06);
            color: var(--paper);
        }
        .sidebar nav a.active {
            background-color: rgba(240, 168, 87, 0.14);
            color: var(--amber-soft);
            font-weight: 600;
        }
        .sidebar.collapsed nav a {
            justify-content: center;
            padding: 12px 0;
            margin: 0 14px;
        }
        .sidebar.collapsed nav a .link-text { display: none; }

        .sidebar .logout-form {
            margin-top: auto;
            padding: 18px 24px 0;
        }
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
            white-space: nowrap;
            overflow: hidden;
        }
        .btn-logout:hover {
            background-color: rgba(240, 90, 90, 0.12);
            color: #F19A9A;
            border-color: rgba(240, 90, 90, 0.35);
        }

        .toggle-btn {
            position: absolute;
            top: 30px;
            right: -14px;
            width: 28px;
            height: 28px;
            background-color: var(--amber);
            color: var(--navy-deep);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(240, 168, 87, 0.4);
            transition: background-color 0.15s ease, transform 0.25s ease;
            z-index: 10;
        }
        .toggle-btn:hover { background-color: var(--amber-soft); }
        .sidebar.collapsed ~ .toggle-btn,
        .sidebar.collapsed .toggle-btn { transform: rotate(180deg); }

        /* ---------- Main content ---------- */
        .main {
            flex: 1;
            padding: 44px 56px 56px;
            max-width: 1180px;
        }

        .page-head {
            margin-bottom: 34px;
        }
        .page-head .eyebrow-mark {
            width: 30px;
            height: 3px;
            background: var(--amber);
            margin-bottom: 16px;
        }
        .main h1 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 28px;
            color: var(--navy-deep);
            margin-bottom: 8px;
        }
        .main p.sub {
            color: var(--slate);
            font-size: 14px;
        }

        .alert-success {
            background: var(--amber-tint);
            color: #92400e;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 24px;
            border: 1px solid var(--amber-soft);
        }
        .alert-warning {
            background: #fffbeb;
            color: #92400e;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 24px;
            border: 1px solid #fde68a;
        }

        /* Room overview card */
        .room-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 28px;
            margin-bottom: 32px;
            display: flex;
            gap: 24px;
            align-items: center;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .room-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(22, 33, 62, 0.07);
        }
        .room-icon {
            width: 68px;
            height: 68px;
            background-color: var(--amber-tint);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .room-main-info h2 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 20px;
            color: var(--navy-deep);
            margin-bottom: 4px;
        }
        .room-main-info p {
            font-size: 13px;
            color: var(--slate);
        }
        .room-status {
            margin-left: auto;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .status-occupied { background-color: var(--amber-tint); color: #92400e; }
        .status-vacant { background-color: #f3f4f6; color: var(--slate); }

        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 44px;
        }
        .info-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-left: 4px solid var(--amber);
            border-radius: 10px;
            padding: 20px 22px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(22, 33, 62, 0.07);
        }
        .info-card .label {
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--slate);
            margin-bottom: 8px;
            font-weight: 600;
        }
        .info-card .value {
            font-family: 'Fraunces', serif;
            font-size: 18px;
            font-weight: 500;
            color: var(--navy-deep);
        }

        /* Section title */
        .section-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--navy-deep);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .section-title::before {
            content: "";
            width: 4px;
            height: 15px;
            background-color: var(--amber);
            border-radius: 2px;
        }

        /* Roommates */
        .roommates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 44px;
        }
        .roommate-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.18s ease;
        }
        .roommate-card:hover {
            border-color: var(--amber);
            box-shadow: 0 10px 22px rgba(22, 33, 62, 0.07);
            transform: translateY(-2px);
        }
        .roommate-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: var(--navy-deep);
            color: var(--amber-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Fraunces', serif;
            font-size: 15px;
            font-weight: 600;
            flex-shrink: 0;
        }
        .roommate-name { font-size: 14px; font-weight: 600; color: var(--navy-deep); }
        .roommate-course { font-size: 12px; color: var(--slate); margin-top: 2px; }

        .empty-state {
            background: #ffffff;
            border: 1px dashed var(--line);
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            color: var(--slate);
            font-size: 14px;
            margin-bottom: 44px;
        }

        /* Amenities */
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 14px;
            margin-bottom: 44px;
        }
        .amenity-chip {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.18s ease;
        }
        .amenity-chip:hover {
            border-color: var(--amber);
            transform: translateY(-2px);
        }

        /* Request room change */
        .action-bar {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }
        .btn-outline {
            padding: 12px 22px;
            background-color: #ffffff;
            color: var(--navy-deep);
            border: 1.5px solid var(--amber);
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.18s ease;
        }
        .btn-outline:hover {
            background-color: var(--amber-tint);
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                flex-direction: row;
                align-items: center;
                padding: 16px 20px;
                overflow-x: auto;
            }
            .sidebar.collapsed { width: 100%; }
            .sidebar .logo { border-bottom: none; margin-bottom: 0; padding: 0 16px 0 0; }
            .sidebar nav { flex-direction: row; }
            .sidebar .logout-form { margin-top: 0; padding: 0 0 0 12px; }
            .toggle-btn { display: none; }
            .main { padding: 32px 24px 48px; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
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
                <a href="/dashboard">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 10.5 12 3l9 7.5"></path>
                            <path d="M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"></path>
                        </svg>
                    </span>
                    <span class="link-text">Dashboard</span>
                </a>
                <a href="/room" class="active">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 18v-6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6"></path>
                            <path d="M2 18h20"></path>
                            <path d="M6 10V6.5A1.5 1.5 0 0 1 7.5 5h4A1.5 1.5 0 0 1 13 6.5V10"></path>
                        </svg>
                    </span>
                    <span class="link-text">My Room</span>
                </a>
                <a href="/payments">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <path d="M2 10h20"></path>
                        </svg>
                    </span>
                    <span class="link-text">Payments</span>
                </a>
                <a href="/maintenance">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.4-3.4a5 5 0 0 1-6.7 6.7l-6.9 6.9a2.1 2.1 0 0 1-3-3l6.9-6.9a5 5 0 0 1 6.7-6.7z"></path>
                        </svg>
                    </span>
                    <span class="link-text">Maintenance</span>
                </a>
                <a href="/profile">
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
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main">
        <div class="page-head">
            <div class="eyebrow-mark"></div>
            <h1>My Room</h1>
            <p class="sub">View your room assignment, roommates, and amenities</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- ASSUMPTION: auth()->user()->room is a relationship returning the assigned Room model.
             If the student has no room assigned yet, show a message instead of the room details. --}}
        @if(auth()->user()->room)
            @php $room = auth()->user()->room; @endphp

            <!-- Room Overview -->
            <div class="room-card">
                <div class="room-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 18v-6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6"></path>
                        <path d="M2 18h20"></path>
                        <path d="M6 10V6.5A1.5 1.5 0 0 1 7.5 5h4A1.5 1.5 0 0 1 13 6.5V10"></path>
                    </svg>
                </div>
                <div class="room-main-info">
                    <h2>Room {{ $room->room_number }}</h2>
                    <p>{{ $room->building ?? 'Main Building' }} · Floor {{ $room->floor ?? '-' }}</p>
                </div>
                <div class="room-status status-occupied">Occupied</div>
            </div>

            <!-- Room Details -->
            <div class="info-grid">
                <div class="info-card">
                    <div class="label">Room Type</div>
                    <div class="value">{{ $room->type ?? 'Standard' }}</div>
                </div>
                <div class="info-card">
                    <div class="label">Capacity</div>
                    <div class="value">{{ $room->capacity ?? '-' }} beds</div>
                </div>
                <div class="info-card">
                    <div class="label">Occupants</div>
                    <div class="value">{{ $room->occupants_count ?? ($room->roommates->count() + 1) }}</div>
                </div>
                <div class="info-card">
                    <div class="label">Monthly Rate</div>
                    <div class="value">₱{{ number_format($room->monthly_rate ?? 0, 2) }}</div>
                </div>
            </div>

            <!-- Roommates -->
            <div class="section-title">Roommates</div>
            @if($room->roommates && $room->roommates->count() > 0)
                <div class="roommates-grid">
                    @foreach($room->roommates as $roommate)
                        <div class="roommate-card">
                            <div class="roommate-avatar">
                                {{ strtoupper(substr($roommate->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="roommate-name">{{ $roommate->name }}</div>
                                <div class="roommate-course">{{ $roommate->course }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">You currently have no roommates assigned.</div>
            @endif

            <!-- Amenities -->
            <div class="section-title">Room Amenities</div>
            <div class="amenities-grid">
                <div class="amenity-chip">❄️ Air Conditioning</div>
                <div class="amenity-chip">📶 WiFi</div>
                <div class="amenity-chip">🪟 Private Window</div>
                <div class="amenity-chip">🚿 Shared Bathroom</div>
                <div class="amenity-chip">🗄️ Personal Locker</div>
                <div class="amenity-chip">🛌 Study Desk</div>
            </div>

            <!-- Actions -->
            <div class="action-bar">
                <a href="/maintenance" class="btn-outline">🔧 Report an Issue</a>
                <a href="#" class="btn-outline">🔄 Request Room Change</a>
            </div>

        @else
            <div class="empty-state" style="padding: 48px;">
                <div style="font-size: 40px; margin-bottom: 12px;">🏠</div>
                <p style="font-size: 15px; font-weight: 600; color: var(--navy-deep); margin-bottom: 6px;">No Room Assigned Yet</p>
                <p>Please contact the dormitory administrator to get a room assigned to your account.</p>
            </div>
        @endif

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