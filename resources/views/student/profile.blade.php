<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
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
        .sidebar nav a .link-icon svg { display: block; }
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
        .sidebar.collapsed .toggle-btn { transform: rotate(180deg); }

        /* ---------- Main content ---------- */
        .main {
            flex: 1;
            padding: 44px 56px 56px;
            max-width: 1180px;
        }

        .page-head { margin-bottom: 30px; }
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

        /* ---------- Alerts ---------- */
        .alert-success {
            background: var(--amber-tint);
            color: #7A4C12;
            border: 1px solid var(--amber-soft);
            border-left: 4px solid var(--amber);
            padding: 13px 18px;
            border-radius: 9px;
            font-size: 13.5px;
            margin-bottom: 22px;
        }
        .alert-error {
            background: #FDF0EF;
            color: #9B3B37;
            border: 1px solid #F3C9C6;
            border-left: 4px solid #D4675F;
            padding: 13px 18px;
            border-radius: 9px;
            font-size: 13.5px;
            margin-bottom: 22px;
        }
        .alert-error ul { margin-left: 18px; }

        /* ---------- Section title ---------- */
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

        /* ---------- Profile card ---------- */
        .profile-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 30px;
            max-width: 540px;
        }

        .profile-identity {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--line);
        }
        .profile-avatar {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background-color: var(--navy-deep);
            color: var(--amber-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Fraunces', serif;
            font-size: 26px;
            font-weight: 500;
            flex-shrink: 0;
        }
        .profile-identity .who {
            font-family: 'Fraunces', serif;
            font-size: 19px;
            font-weight: 500;
            color: var(--navy-deep);
        }
        .profile-identity .where {
            font-size: 13px;
            color: var(--slate);
            margin-top: 3px;
        }

        /* ---------- Form ---------- */
        .form-group { margin-bottom: 17px; }
        .form-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--navy-deep);
            margin-bottom: 7px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 11px 13px;
            border: 1.5px solid var(--line);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--ink);
            background-color: #ffffff;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(240, 168, 87, 0.18);
        }

        /* ---------- Read-only rows ---------- */
        .account-facts {
            margin-top: 26px;
            padding-top: 6px;
            border-top: 1px solid var(--line);
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 13px 0;
            border-bottom: 1px solid var(--line);
            font-size: 13.5px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-row .label {
            color: var(--slate);
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 600;
        }
        .info-row .value {
            color: var(--navy-deep);
            font-weight: 600;
        }

        .btn-save {
            margin-top: 24px;
            width: 100%;
            padding: 12px;
            background-color: var(--navy-deep);
            color: var(--paper);
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }
        .btn-save:hover { background-color: var(--navy-soft); }

        :focus-visible {
            outline: 2px solid var(--amber);
            outline-offset: 2px;
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
            .profile-card { padding: 24px; }
        }
    </style>
    @include('student.partials.theme')
</head>
<body>

    @include('student.partials.sidebar')

    <!-- Main content -->
    <div class="main">
        @include('student.partials.page-header', ['title' => 'My Profile', 'subtitle' => 'Manage your account information.'])
        <div class="welcome-banner">
            <div class="welcome-content">
                <div class="eyebrow">Your Dormitory, Your Space</div>
                <h1>My Profile</h1>
                <p>Manage your personal details and account information.</p>
            </div>
            <div class="welcome-date">
                <span><i class="fa-regular fa-calendar"></i> Today's Date</span>
                <strong>{{ now()->format('F d, Y') }}</strong>
            </div>
        </div>
        <div class="profile-card profile-landscape">
            <aside class="profile-summary">
                <h2 class="profile-summary-title">Profile overview</h2>
                <div class="profile-identity">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="who">{{ auth()->user()->name }}</div>
                        <div class="where">{{ auth()->user()->course }}</div>
                    </div>
                </div>

                <div class="account-facts">
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
                </div>
            </aside>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <h2 class="profile-form-title">Edit personal information</h2>

                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
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
                        @foreach(['Information Technology', 'Education', 'Criminology', 'Office Administration', 'Political Science', 'Communication'] as $course)
                            <option value="{{ $course }}" {{ old('course', auth()->user()->course) == $course ? 'selected' : '' }}>
                                {{ $course }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number', auth()->user()->contact_number) }}" placeholder="e.g. 0917 123 4567">
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>

    @include('student.partials.announcement-bell-script')

</body>
</html>
