<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f5f7; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding: 24px 0;
            display: flex;
            flex-direction: column;
        }
        .sidebar .logo {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            padding: 0 24px 24px;
            border-bottom: 1px solid #eee;
            margin-bottom: 16px;
        }
        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.15s ease;
        }
        .sidebar nav a:hover {
            background-color: #f4f5f7;
            color: #2c3e50;
        }
        .sidebar nav a.active {
            background-color: #f0f1f3;
            color: #111827;
            border-left: 3px solid #6b7280;
            font-weight: 600;
        }
        .sidebar .logout-form { margin-top: auto; padding: 0 24px; }
        .btn-logout {
            width: 100%;
            padding: 10px;
            background-color: #ffffff;
            color: #6b7280;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .btn-logout:hover {
            background-color: #f3f4f6;
            color: #111827;
            border-color: #9ca3af;
        }

        /* Main content */
        .main { flex: 1; padding: 32px 40px; }
        .main h1 { font-size: 22px; color: #111827; margin-bottom: 4px; }
        .main p.sub { color: #6b7280; font-size: 14px; margin-bottom: 28px; }

        /* Profile card */
        .profile-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 28px;
            max-width: 500px;
        }
        .profile-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background-color: #6b7280;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f1f3;
            font-size: 14px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-row .label { color: #9ca3af; }
        .info-row .value { color: #1f2937; font-weight: 600; }

        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #dcdfe6;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #6b7280;
            box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.15);
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .alert-error ul { margin-left: 16px; }

        .btn-save {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .btn-save:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">🏢 Dorm Portal</div>
        <nav>
            <a href="/dashboard">🏠 Dashboard</a>
            <a href="/room">🛏️ My Room</a>
            <a href="/payments">💳 Payments</a>
            <a href="/maintenance">🔧 Maintenance</a>
            <a href="/profile" class="active">👤 Profile</a>
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
        <h1>My Profile</h1>
        <p class="sub">View and update your account information</p>

        <div class="profile-card">
            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                </div>

                <div class="form-group">
                    <label for="course">Course</label>
                    <select id="course" name="course">
                        @foreach(['BS Information Technology', 'BS Computer Science', 'BS Information Systems', 'BS Business Administration'] as $course)
                            <option value="{{ $course }}" {{ old('course', auth()->user()->course) == $course ? 'selected' : '' }}>
                                {{ $course }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="info-row">
                    <span class="label">Username</span>
                    <span class="value">{{ auth()->user()->username }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Role</span>
                    <span class="value" style="text-transform: capitalize;">{{ auth()->user()->role }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Member Since</span>
                    <span class="value">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>

</body>
</html>