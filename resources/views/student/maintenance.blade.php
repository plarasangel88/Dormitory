<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - Dorm Portal</title>
    <!-- FontAwesome Icons (same as Student Dashboard) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Theme base — identical to Student Dashboard */
            --navy-deep: #16213E;
            --navy-mid: #24345C;
            --navy-soft: #3A4E7A;
            --amber: #F0A857;
            --amber-soft: #F6C98B;
            --paper: #FBF8F2;
            --ink: #2A2620;
            --slate: #8993A8;

            --bg-main: var(--paper);
            --card-bg: #FFFFFF;
            --text-primary: var(--ink);
            --text-secondary: var(--slate);
            --border-color: #E3DFD5;

            --primary-blue: var(--navy-soft);
            --success-green: #4E9A6B;
            --warning-orange: var(--amber);
            --danger-red: #C4573E;
            --purple-accent: #7C6FA6;
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

        .app-container { display: flex; min-height: 100vh; }

        /* Sidebar Navigation — identical structure/skin to Student Dashboard */
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

        .sidebar-menu { display: flex; flex-direction: column; gap: 8px; flex-grow: 1; }

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

        .menu-item:hover, .menu-item.active { background-color: rgba(240, 168, 87, 0.14); color: #FFF; }
        .menu-item.active { box-shadow: inset 3px 0 0 var(--amber); }

        .sidebar-footer { padding-top: 16px; border-top: 1px solid #334155; }

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

        .logout-btn:hover { color: #FFF; background-color: var(--danger-red); border-color: var(--danger-red); }

        .main-content { flex: 1; display: flex; flex-direction: column; min-width: 0; }

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

        .search-bar input { border: none; background: transparent; outline: none; width: 100%; font-size: 0.9rem; color: var(--text-primary); }
        .search-bar input::placeholder { color: #B7B2A6; }

        .admin-profile-badge { display: flex; align-items: center; gap: 12px; }

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

        .user-info { display: flex; flex-direction: column; }
        .user-name { font-size: 0.9rem; font-weight: 600; color: var(--text-primary); }
        .user-role { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.4px; color: var(--text-secondary); }

        .dashboard-body { padding: 32px; overflow-y: auto; }

        .welcome-banner h1 { font-family: 'Fraunces', serif; font-weight: 500; font-size: 1.8rem; color: var(--text-primary); }
        .welcome-banner p { color: var(--text-secondary); margin-top: 4px; margin-bottom: 24px; font-size: 0.92rem; }

        .alert-success {
            background: #FBEBD4;
            color: #7A4C12;
            border: 1px solid var(--amber-soft);
            border-left: 4px solid var(--amber);
            padding: 13px 18px;
            border-radius: 9px;
            font-size: 13.5px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-error {
            background: #FDF0EF;
            color: #9B3B37;
            border: 1px solid #F3C9C6;
            border-left: 4px solid var(--danger-red);
            padding: 13px 18px;
            border-radius: 9px;
            font-size: 13.5px;
            margin-bottom: 22px;
        }
        .alert-error strong { display: flex; align-items: center; gap: 8px; }
        .alert-error ul { margin-left: 22px; margin-top: 6px; }

        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }

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

        .metric-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
        .metric-icon.blue { background-color: #EAEEF7; color: var(--primary-blue); }
        .metric-icon.orange { background-color: #FBEBD4; color: var(--warning-orange); }
        .metric-icon.green { background-color: #E1EFE6; color: var(--success-green); }
        .metric-icon.purple { background-color: #EBE7F4; color: var(--purple-accent); }

        .metric-title { font-size: 0.68rem; font-weight: 700; color: var(--text-secondary); letter-spacing: 0.6px; }
        .metric-value { font-family: 'Fraunces', serif; font-size: 1.4rem; font-weight: 600; color: var(--text-primary); margin-top: 4px; }

        .card-panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        .card-panel h3 { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
        .card-panel h3 i { color: var(--amber); }

        .maintenance-layout { display: grid; grid-template-columns: 370px 1fr; gap: 20px; align-items: start; }

        .form-group { margin-bottom: 17px; }
        .form-group:last-of-type { margin-bottom: 0; }
        .form-group label { display: block; font-size: 12.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 7px; }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 11px 13px;
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background-color: #ffffff;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(240, 168, 87, 0.18);
        }
        .form-group textarea { resize: vertical; min-height: 96px; }
        .form-hint { font-size: 11.5px; color: var(--text-secondary); margin-top: 6px; line-height: 1.5; }

        .btn-submit {
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
            margin-top: 8px;
        }
        .btn-submit:hover { background-color: var(--navy-mid); }

        .history-card { padding: 0; overflow: hidden; }
        .history-card h3 { padding: 20px 20px 0; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: var(--paper); }
        th {
            text-align: left;
            padding: 13px 18px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-secondary);
            font-weight: 700;
            border-bottom: 1px solid var(--border-color);
        }
        td { padding: 15px 18px; font-size: 13px; color: var(--text-primary); border-bottom: 1px solid var(--border-color); vertical-align: top; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background-color: var(--paper); }

        .title-cell { font-weight: 600; }
        .desc-cell { color: var(--text-secondary); max-width: 260px; }

        .badge { display: inline-block; padding: 4px 11px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: capitalize; white-space: nowrap; }
        .badge-pending      { background-color: #FBEBD4; color: #8A5A17; }
        .badge-in_progress  { background-color: #EAEEF7; color: #34497D; }
        .badge-resolved, .badge-completed { background-color: #E1EFE6; color: #2F6A45; }

        .badge-priority-low    { background-color: #F1F4F0; color: #55725D; }
        .badge-priority-medium { background-color: #FBEBD4; color: #8A5A17; }
        .badge-priority-high   { background-color: #FBE7E5; color: #9B3B37; }

        .empty-row td { text-align: center; padding: 46px 18px; color: var(--text-secondary); font-size: 13px; }
        .empty-row tr:hover { background: none; }

        @media (max-width: 1080px) {
            .maintenance-layout { grid-template-columns: 1fr; }
        }
        @media (max-width: 860px) {
            .app-container { flex-direction: column; }
            .sidebar { width: 100%; flex-direction: row; align-items: center; padding: 16px 20px; overflow-x: auto; }
            .sidebar-brand { margin-bottom: 0; padding-left: 0; margin-right: 16px; }
            .sidebar-menu { flex-direction: row; }
            .sidebar-footer { padding-top: 0; border-top: none; margin-left: 12px; }
            .search-bar { width: 220px; }
            .history-card { overflow-x: auto; }
        }
    </style>
    @include('student.partials.theme')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation (same skin as Student Dashboard; links unchanged) -->
        @include('student.partials.sidebar')

        <!-- Main Workspace -->
        <main class="main-content">
            <!-- Header Bar (same skin as Student Dashboard) -->
            @include('student.partials.page-header', ['title' => 'Maintenance', 'subtitle' => 'Submit a request and follow its status.'])

            <!-- Dashboard Content -->
            <div class="dashboard-body">
                <div class="welcome-banner">
                    <div class="welcome-content">
                        <div class="eyebrow">Your Dormitory, Your Space</div>
                        <h1>Maintenance</h1>
                        <p>Report an issue in your room and track its status.</p>
                    </div>
                    <div class="welcome-date">
                        <span><i class="fa-regular fa-calendar"></i> Today's Date</span>
                        <strong>{{ now()->format('F d, Y') }}</strong>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert-error">
                        <strong><i class="fa-solid fa-triangle-exclamation"></i> Please fix the following:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($selectedRequest)
                    <div class="card-panel" style="margin-bottom: 22px;">
                        <h3><i class="fa-solid fa-clipboard-list"></i> Request Details</h3>
                        <p><strong>{{ \Illuminate\Support\Str::startsWith($selectedRequest->title, '[') ? \Illuminate\Support\Str::before(\Illuminate\Support\Str::after($selectedRequest->title, '['), ']') : 'Other' }}</strong> &middot; {{ ucfirst($selectedRequest->priority) }} priority</p>
                        <p style="margin-top: 8px;">{{ $selectedRequest->description }}</p>
                        <p style="margin-top: 8px;">Status: {{ str_replace('_', ' ', ucfirst($selectedRequest->status)) }} · Submitted {{ $selectedRequest->created_at->format('M d, Y') }}</p>
                    </div>
                @endif

                <!-- Summary metrics -->
                <section class="metrics-grid">
                    <div class="metric-card">
                        <div class="metric-icon blue"><i class="fa-solid fa-list-check"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">TOTAL REQUESTS</span>
                            <div class="metric-value">{{ $totalCount }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon orange"><i class="fa-solid fa-hourglass-half"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">PENDING</span>
                            <div class="metric-value">{{ $pendingCount }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon purple"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">IN PROGRESS</span>
                            <div class="metric-value">{{ $inProgressCount }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon green"><i class="fa-solid fa-circle-check"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">RESOLVED</span>
                            <div class="metric-value">{{ $resolvedCount }}</div>
                        </div>
                    </div>
                </section>

                <div class="maintenance-layout">
                    <div class="card-panel">
                        <h3><i class="fa-solid fa-wrench"></i> Report an Issue</h3>
                        <form action="{{ route('maintenance.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="category" name="category" required>
                                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select category</option>
                                    <option value="Electrical" {{ old('category') == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                    <option value="Plumbing" {{ old('category') == 'Plumbing' ? 'selected' : '' }}>Plumbing</option>
                                    <option value="Furniture" {{ old('category') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                    <option value="Air Conditioning" {{ old('category') == 'Air Conditioning' ? 'selected' : '' }}>Air Conditioning</option>
                                    <option value="Wifi/Internet" {{ old('category') == 'Wifi/Internet' ? 'selected' : '' }}>Wifi/Internet</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select id="priority" name="priority" required>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" placeholder="Describe the issue in detail" required>{{ old('description') }}</textarea>
                                <div class="form-hint">Include when it started and anything that might help staff diagnose it faster.</div>
                            </div>

                            <button type="submit" class="btn-submit">Submit Request</button>
                        </form>
                    </div>

                    <div class="card-panel history-card">
                        <h3><i class="fa-solid fa-clock-rotate-left"></i> Your Requests</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $req)
                                    <tr>
                                        <td>{{ $req->created_at->format('M d, Y') }}</td>
                                        <td>{{ \Illuminate\Support\Str::startsWith($req->title, '[') ? \Illuminate\Support\Str::before(\Illuminate\Support\Str::after($req->title, '['), ']') : 'Other' }}</td>
                                        <td><div class="desc-cell">{{ \Illuminate\Support\Str::limit($req->description, 120) }}</div></td>
                                        <td><span class="badge badge-priority-{{ $req->priority }}">{{ $req->priority }}</span></td>
                                        <td><span class="badge badge-{{ $req->status }}">{{ str_replace('_', ' ', $req->status) }}</span></td>
                                        <td><a href="{{ route('maintenance.show', $req) }}">View</a></td>
                                    </tr>
                                @empty
                                    <tr class="empty-row">
                                        <td colspan="6">No maintenance requests yet. Use the form to report an issue.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include('student.partials.announcement-bell-script')
</body>
</html>
