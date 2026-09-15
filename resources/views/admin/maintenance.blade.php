<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Request Details — Admin</title>
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
            --green: #6FAE8C;
            --green-tint: #E7F3ED;
            --red: #D97066;
            --red-tint: #FBEAE8;
            --blue: #5B84C4;
            --blue-tint: #E9EFFA;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Inter', sans-serif; color: var(--ink); }
        body { display: flex; min-height: 100vh; background-color: var(--paper); }

        /* ---------- Sidebar ---------- */
        .sidebar-wrapper { position: relative; flex-shrink: 0; }
        .sidebar {
            width: 260px; height: 100vh; position: sticky; top: 0;
            background: linear-gradient(180deg, #1B2A4D 0%, #16213E 60%, #101A33 100%);
            padding: 30px 0; display: flex; flex-direction: column;
            transition: width 0.25s ease, padding 0.25s ease; overflow: hidden; white-space: nowrap;
        }
        .sidebar.collapsed { width: 78px; padding: 30px 0; }
        .sidebar .logo {
            display: flex; align-items: center; gap: 11px; padding: 0 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 22px;
        }
        .sidebar .logo .key-badge {
            width: 34px; height: 34px; border-radius: 9px;
            background: rgba(240, 168, 87, 0.14); border: 1px solid rgba(240, 168, 87, 0.3);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .sidebar .logo-text { font-family: 'Fraunces', serif; font-weight: 500; font-size: 16.5px; color: var(--paper); }
        .sidebar.collapsed .logo-text { display: none; }
        .sidebar nav { display: flex; flex-direction: column; gap: 2px; }
        .sidebar nav a {
            display: flex; align-items: center; gap: 13px; padding: 12px 24px; margin: 0 10px;
            border-radius: 9px; color: #AEB8D4; text-decoration: none; font-size: 13.5px; font-weight: 500;
            transition: all 0.18s ease;
        }
        .sidebar nav a .link-icon { width: 20px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; color: inherit; }
        .sidebar nav a .link-icon svg { display: block; }
        .sidebar nav a:hover { background-color: rgba(255,255,255,0.06); color: var(--paper); }
        .sidebar nav a.active { background-color: rgba(240, 168, 87, 0.14); color: var(--amber-soft); font-weight: 600; }
        .sidebar.collapsed nav a { justify-content: center; padding: 12px 0; margin: 0 14px; }
        .sidebar.collapsed nav a .link-text { display: none; }
        .sidebar .logout-form { margin-top: auto; padding: 18px 24px 0; }
        .sidebar.collapsed .logout-form { padding: 18px 16px 0; }
        .btn-logout {
            width: 100%; padding: 11px; background-color: transparent; color: #AEB8D4;
            border: 1.5px solid rgba(255,255,255,0.16); border-radius: 8px; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.18s ease;
        }
        .btn-logout:hover { background-color: rgba(240, 90, 90, 0.12); color: #F19A9A; border-color: rgba(240, 90, 90, 0.35); }
        .toggle-btn {
            position: absolute; top: 30px; right: -14px; width: 28px; height: 28px;
            background-color: var(--amber); color: var(--navy-deep); border: none; border-radius: 50%;
            cursor: pointer; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(240, 168, 87, 0.4); transition: background-color 0.15s ease, transform 0.25s ease; z-index: 10;
        }
        .toggle-btn:hover { background-color: var(--amber-soft); }
        .sidebar.collapsed .toggle-btn { transform: rotate(180deg); }

        /* ---------- Main content ---------- */
        .main { flex: 1; padding: 44px 56px 56px; max-width: 1000px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; }
        .back-link {
            display: inline-flex; align-items: center; gap: 6px; color: var(--slate); text-decoration: none;
            font-size: 13px; font-weight: 600; transition: color 0.15s ease;
        }
        .back-link:hover { color: var(--navy-deep); }
        .admin-chip {
            display: flex; align-items: center; gap: 10px; background: #ffffff; border: 1px solid var(--line);
            border-radius: 30px; padding: 6px 16px 6px 6px; box-shadow: 0 2px 8px rgba(22, 33, 62, 0.04);
        }
        .admin-avatar {
            width: 32px; height: 32px; border-radius: 50%; background: var(--navy-deep); color: var(--amber-soft);
            font-family: 'Fraunces', serif; font-weight: 600; font-size: 13px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .admin-info { display: flex; flex-direction: column; line-height: 1.25; }
        .admin-name { font-size: 13px; font-weight: 600; color: var(--navy-deep); }
        .admin-role { font-size: 10.5px; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; }

        .page-head {
            margin-bottom: 28px; display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;
        }
        .page-head .eyebrow-mark { width: 30px; height: 3px; background: var(--amber); margin-bottom: 16px; }
        .main h1 { font-family: 'Fraunces', serif; font-weight: 500; font-size: 26px; color: var(--navy-deep); margin-bottom: 8px; }
        .main p.sub { color: var(--slate); font-size: 14px; }

        .badge {
            display: inline-block; padding: 5px 13px; border-radius: 20px; font-size: 11.5px;
            font-weight: 700; letter-spacing: 0.02em; white-space: nowrap;
        }
        .badge-pending { background: var(--amber-tint); color: #A16A20; }
        .badge-in_progress { background: var(--blue-tint); color: var(--blue); }
        .badge-completed { background: var(--green-tint); color: #3E6E58; }
        .badge-rejected { background: var(--red-tint); color: var(--red); }
        .badge-priority-low { background: #EEF1F6; color: var(--slate); }
        .badge-priority-medium { background: var(--amber-tint); color: #A16A20; }
        .badge-priority-high { background: var(--red-tint); color: var(--red); }

        .alert-success {
            background: var(--green-tint); border: 1px solid var(--green); color: #3E6E58;
            padding: 12px 18px; border-radius: 8px; font-size: 13.5px; margin-bottom: 22px;
        }

        .grid-layout { display: grid; grid-template-columns: 1.5fr 1fr; gap: 22px; align-items: start; }

        .card {
            background: #ffffff; border: 1px solid var(--line); border-radius: 12px; padding: 26px;
        }
        .card + .card { margin-top: 22px; }
        .card .card-title {
            font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate);
            font-weight: 700; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
        }
        .card .card-title::before { content: ""; width: 4px; height: 13px; background-color: var(--amber); border-radius: 2px; }

        .detail-row { display: flex; justify-content: space-between; padding: 11px 0; border-bottom: 1px solid var(--line); font-size: 13.5px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-row .k { color: var(--slate); font-weight: 500; }
        .detail-row .v { color: var(--ink); font-weight: 600; text-align: right; }

        .desc-text { font-size: 13.5px; line-height: 1.7; color: var(--ink); }

        label { display: block; font-size: 12.5px; font-weight: 700; color: var(--navy-deep); margin-bottom: 7px; }
        select, textarea {
            width: 100%; padding: 11px 13px; border: 1.4px solid var(--line); border-radius: 8px;
            font-family: 'Inter', sans-serif; font-size: 13.5px; color: var(--ink); background: var(--paper);
            transition: border-color 0.15s ease;
        }
        select:focus, textarea:focus { outline: none; border-color: var(--amber); }
        textarea { resize: vertical; min-height: 90px; }
        .field { margin-bottom: 18px; }
        .field:last-of-type { margin-bottom: 0; }

        .btn-save {
            width: 100%; padding: 12px; margin-top: 20px; background: var(--navy-deep); color: var(--amber-soft);
            border: none; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 700;
            cursor: pointer; transition: background 0.15s ease;
        }
        .btn-save:hover { background: var(--navy-mid); }

        .btn-delete {
            width: 100%; padding: 12px; margin-top: 10px; background: transparent; color: var(--red);
            border: 1.5px solid var(--red-tint); border-radius: 8px; font-family: 'Inter', sans-serif;
            font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.15s ease;
        }
        .btn-delete:hover { background: var(--red-tint); border-color: var(--red); }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .sidebar {
                width: 100%; height: auto; position: relative; flex-direction: row;
                align-items: center; padding: 16px 20px; overflow-x: auto;
            }
            .sidebar .logo { border-bottom: none; margin-bottom: 0; padding: 0 16px 0 0; }
            .sidebar nav { flex-direction: row; }
            .sidebar .logout-form { margin-top: 0; padding: 0 0 0 12px; }
            .toggle-btn { display: none; }
            .main { padding: 32px 24px 48px; }
            .grid-layout { grid-template-columns: 1fr; }
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
                <a href="{{ route('admin.dashboard') }}">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 10.5 12 3l9 7.5"></path>
                            <path d="M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"></path>
                        </svg>
                    </span>
                    <span class="link-text">Dashboard</span>
                </a>
                <a href="{{ route('admin.students.index') }}">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10 12 5 2 10l10 5 10-5Z"></path>
                            <path d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"></path>
                        </svg>
                    </span>
                    <span class="link-text">Students</span>
                </a>
                <a href="{{ route('admin.rooms.index') }}">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 18v-6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6"></path>
                            <path d="M2 18h20"></path>
                            <path d="M6 10V6.5A1.5 1.5 0 0 1 7.5 5h4A1.5 1.5 0 0 1 13 6.5V10"></path>
                        </svg>
                    </span>
                    <span class="link-text">Rooms</span>
                </a>
                <a href="{{ route('admin.payments.index') }}">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <path d="M2 10h20"></path>
                        </svg>
                    </span>
                    <span class="link-text">Payments</span>
                </a>
                <a href="{{ route('admin.maintenance.index') }}" class="active">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.4-3.4a5 5 0 0 1-6.7 6.7l-6.9 6.9a2.1 2.1 0 0 1-3-3l6.9-6.9a5 5 0 0 1 6.7-6.7z"></path>
                        </svg>
                    </span>
                    <span class="link-text">Maintenance</span>
                </a>
                <a href="/admin/profile">
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
        <div class="topbar">
            <a href="{{ route('admin.maintenance.index') }}" class="back-link">← Back to all requests</a>
            <div class="admin-chip">
                <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="admin-info">
                    <span class="admin-name">{{ auth()->user()->name }}</span>
                    <span class="admin-role">Admin</span>
                </div>
            </div>
        </div>

        <div class="page-head">
            <div>
                <div class="eyebrow-mark"></div>
                <h1>{{ $maintenance->title }}</h1>
                <p class="sub">Submitted {{ $maintenance->created_at->format('M d, Y \a\t g:i A') }}</p>
            </div>
            <span class="badge badge-{{ $maintenance->status }}">
                {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
            </span>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="grid-layout">
            <!-- Left column: details -->
            <div>
                <div class="card">
                    <div class="card-title">Request Info</div>
                    <div class="detail-row">
                        <span class="k">Student</span>
                        <span class="v">{{ $maintenance->user->name ?? '—' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="k">Room</span>
                        <span class="v">{{ $maintenance->room->room_number ?? $maintenance->room->name ?? '—' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="k">Priority</span>
                        <span class="v">
                            <span class="badge badge-priority-{{ $maintenance->priority }}">
                                {{ ucfirst($maintenance->priority) }}
                            </span>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="k">Submitted</span>
                        <span class="v">{{ $maintenance->created_at->format('M d, Y') }}</span>
                    </div>
                    @if ($maintenance->resolved_at)
                        <div class="detail-row">
                            <span class="k">Resolved</span>
                            <span class="v">{{ $maintenance->resolved_at->format('M d, Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="k">Resolved By</span>
                            <span class="v">{{ $maintenance->resolvedBy->name ?? '—' }}</span>
                        </div>
                    @endif
                </div>

                <div class="card">
                    <div class="card-title">Description</div>
                    <p class="desc-text">{{ $maintenance->description }}</p>
                </div>

                @if ($maintenance->admin_notes)
                    <div class="card">
                        <div class="card-title">Admin Notes</div>
                        <p class="desc-text">{{ $maintenance->admin_notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Right column: update form -->
            <div>
                <div class="card">
                    <div class="card-title">Update Request</div>
                    <form action="{{ route('admin.maintenance.update', $maintenance) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="field">
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="pending" @selected($maintenance->status === 'pending')>Pending</option>
                                <option value="in_progress" @selected($maintenance->status === 'in_progress')>In Progress</option>
                                <option value="completed" @selected($maintenance->status === 'completed')>Completed</option>
                                <option value="rejected" @selected($maintenance->status === 'rejected')>Rejected</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="admin_notes">Admin Notes</label>
                            <textarea name="admin_notes" id="admin_notes" placeholder="Add notes for this request...">{{ old('admin_notes', $maintenance->admin_notes) }}</textarea>
                        </div>

                        <button type="submit" class="btn-save">Save Changes</button>
                    </form>

                    <form action="{{ route('admin.maintenance.destroy', $maintenance) }}" method="POST"
                          onsubmit="return confirm('Delete this maintenance request? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('collapsed'));
    </script>

</body>
</html>