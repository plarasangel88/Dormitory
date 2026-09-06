<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Room - Dormitory Management System</title>
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
        }
        .sidebar .logo {
            font-size: 19px;
            font-weight: 700;
            color: #14532d;
            padding: 0 26px 24px;
            border-bottom: 1px solid #eef2ef;
            margin-bottom: 20px;
        }
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
        .sidebar .logout-form { margin-top: auto; padding: 0 26px; }
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
        }
        .btn-logout:hover {
            background-color: #fef2f2;
            color: #b91c1c;
            border-color: #fca5a5;
        }

        /* Main content */
        .main { flex: 1; padding: 40px 48px; }
        .main h1 { font-size: 24px; color: #111827; margin-bottom: 6px; font-weight: 700; }
        .main p.sub { color: #6b7280; font-size: 14px; margin-bottom: 32px; }

        .alert-success {
            background: #ecfdf3;
            color: #15803d;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 24px;
            border: 1px solid #bbf7d0;
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
            border: 1px solid #e5efe9;
            border-radius: 14px;
            padding: 28px;
            margin-bottom: 32px;
            display: flex;
            gap: 28px;
            align-items: center;
        }
        .room-icon {
            width: 72px;
            height: 72px;
            background-color: #ecfdf3;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            flex-shrink: 0;
        }
        .room-main-info h2 {
            font-size: 20px;
            color: #14532d;
            margin-bottom: 4px;
        }
        .room-main-info p {
            font-size: 13px;
            color: #6b7280;
        }
        .room-status {
            margin-left: auto;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .status-occupied { background-color: #ecfdf3; color: #15803d; }
        .status-vacant { background-color: #f3f4f6; color: #6b7280; }

        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        .info-card {
            background: #ffffff;
            border: 1px solid #e5efe9;
            border-left: 4px solid #22c55e;
            border-radius: 10px;
            padding: 18px 20px;
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
            font-size: 16px;
            font-weight: 700;
            color: #14532d;
        }

        /* Section title */
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

        /* Roommates */
        .roommates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        .roommate-card {
            background: #ffffff;
            border: 1px solid #e5efe9;
            border-radius: 12px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .roommate-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: #22c55e;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .roommate-name { font-size: 14px; font-weight: 600; color: #111827; }
        .roommate-course { font-size: 12px; color: #9ca3af; margin-top: 2px; }

        .empty-state {
            background: #ffffff;
            border: 1px dashed #d1d5db;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            color: #9ca3af;
            font-size: 14px;
            margin-bottom: 32px;
        }

        /* Amenities */
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 14px;
            margin-bottom: 32px;
        }
        .amenity-chip {
            background: #ffffff;
            border: 1px solid #e5efe9;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 10px;
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
            color: #15803d;
            border: 1.5px solid #22c55e;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.18s ease;
        }
        .btn-outline:hover {
            background-color: #ecfdf3;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">🏢 Dorm Portal</div>
        <nav>
            <a href="/dashboard">🏠 Dashboard</a>
            <a href="/room" class="active">🛏️ My Room</a>
            <a href="/payments">💳 Payments</a>
            <a href="/maintenance">🔧 Maintenance</a>
            <a href="/profile">👤 Profile</a>
        </nav>
        <div class="logout-form">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main content -->
    <div class="main">
        <h1>My Room 🛏️</h1>
        <p class="sub">View your room assignment, roommates, and amenities</p>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- ASSUMPTION: auth()->user()->room is a relationship returning the assigned Room model.
             If the student has no room assigned yet, show a message instead of the room details. --}}
        @if(auth()->user()->room)
            @php $room = auth()->user()->room; @endphp

            <!-- Room Overview -->
            <div class="room-card">
                <div class="room-icon">🛏️</div>
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
                <p style="font-size: 15px; font-weight: 600; color: #374151; margin-bottom: 6px;">No Room Assigned Yet</p>
                <p>Please contact the dormitory administrator to get a room assigned to your account.</p>
            </div>
        @endif

    </div>

</body>
</html>