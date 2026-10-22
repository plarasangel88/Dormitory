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

        .maintenance-layout { display: grid; grid-template-columns: minmax(300px, 0.8fr) minmax(0, 1.2fr); gap: 14px; align-items: start; }
        .maintenance-layout > .card-panel { min-width: 0; }

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

        .history-card { padding: 0; overflow: hidden; min-width: 0; }
        .history-card h3 { padding: 20px 20px 0; margin-bottom: 12px; }
        .history-table-wrap { width: 100%; overflow-x: auto; }
        .history-card table { width: 100%; table-layout: fixed; }
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

        .message-thread { display: grid; gap: 10px; max-height: 300px; overflow-y: auto; padding: 12px; border: 1px solid var(--border-color); border-radius: 10px; background: #f8f9fb; }
        .maintenance-message { max-width: 88%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 11px; background: #fff; }
        .maintenance-message.is-mine { justify-self: end; border-color: #d8e3f1; background: #edf3fb; }
        .maintenance-message-meta { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 5px; color: var(--text-secondary); font-size: 10px; }
        .maintenance-message-body { margin: 0; color: var(--text-primary); font-size: 12px; line-height: 1.55; overflow-wrap: anywhere; white-space: pre-wrap; }
        .message-empty { margin: 0; color: var(--text-secondary); font-size: 12px; text-align: center; }
        .message-form { display: grid; gap: 9px; margin-top: 12px; }
        .message-form textarea { width: 100%; min-height: 76px; padding: 11px 13px; resize: vertical; border: 1.5px solid var(--border-color); border-radius: 8px; background: #fff; color: var(--text-primary); font: 14px 'Inter', sans-serif; }
        .message-form textarea:focus { outline: none; border-color: var(--amber); box-shadow: 0 0 0 3px rgba(240, 168, 87, 0.18); }
        .message-form .btn-submit { width: auto; justify-self: end; margin-top: 0; padding: 10px 16px; }
        .conversation-card { margin-bottom: 22px; }
        .conversation-card h3 { margin-bottom: 12px; }
        .conversation-subtitle { margin: -6px 0 12px; color: var(--text-secondary); font-size: 12px; }
        .message-action-form { margin: 0; }
        .message-count { width: 100%; min-height: 36px; display: inline-flex; align-items: center; justify-content: center; gap: 7px; padding: 7px 9px; border: 1px solid #d8deea; border-radius: 8px; background: #fff; color: var(--navy-deep); font: 600 11px 'Inter', sans-serif; white-space: nowrap; cursor: pointer; transition: background .15s ease, border-color .15s ease; }
        .message-count:hover { border-color: var(--navy-mid); background: #f3f6fa; }
        .message-count i { color: var(--navy-soft); }

        @media (max-width: 1050px) {
            .maintenance-layout { grid-template-columns: 1fr; }
        }
        @media (max-width: 860px) {
            .app-container { flex-direction: column; }
            .sidebar { width: 100%; flex-direction: row; align-items: center; padding: 16px 20px; overflow-x: auto; }
            .sidebar-brand { margin-bottom: 0; padding-left: 0; margin-right: 16px; }
            .sidebar-menu { flex-direction: row; }
            .sidebar-footer { padding-top: 0; border-top: none; margin-left: 12px; }
            .search-bar { width: 220px; }
            .history-card table { min-width: 700px; }
        }
    </style>
    @include('student.partials.theme')
    <style>
        .maintenance-page .top-header, .maintenance-page .student-shared-header { min-height: 58px; padding: 6px 16px !important; }
        .maintenance-page .student-shared-header .header-left, .maintenance-page .student-shared-header .header-right { gap: 9px; }
        .maintenance-page .dashboard-body { padding: 12px 18px !important; }
        .maintenance-page .welcome-banner { display: none !important; }
        .maintenance-page .metrics-grid { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; gap: 9px; margin: 0 0 12px; }
        .maintenance-page .metric-card { min-height: 66px; padding: 9px 11px; gap: 9px; border-radius: 10px; }
        .maintenance-page .metric-icon { width: 34px; height: 34px; flex-basis: 34px; border-radius: 8px; font-size: 14px; }
        .maintenance-page .metric-title { font-size: 9px; line-height: 1.25; }
        .maintenance-page .metric-value { margin-top: 2px; font-size: 18px; line-height: 1.15; }
        .maintenance-page .maintenance-layout { grid-template-columns: minmax(300px, .8fr) minmax(0, 1.2fr); gap: 14px; }
        .maintenance-page .maintenance-layout > .card-panel { padding: 14px; }
        .maintenance-page .card-panel h3 { margin-bottom: 10px; font-size: 15px; }
        .maintenance-page .form-group { margin-bottom: 9px; }
        .maintenance-page .form-group label { margin-bottom: 4px; font-size: 11px; }
        .maintenance-page .form-group select,
        .maintenance-page .form-group textarea { padding: 8px 10px; border-radius: 7px; font-size: 12px; }
        .maintenance-page .form-group select { min-height: 36px; }
        .maintenance-page .form-group textarea { min-height: 64px; }
        .maintenance-page .form-hint { margin-top: 4px; font-size: 10px; line-height: 1.35; }
        .maintenance-page .btn-submit { min-height: 36px; margin-top: 3px; padding: 8px 12px; border-radius: 7px; font-size: 12px; }
        .maintenance-page .history-card h3 { padding: 14px 14px 0; margin-bottom: 8px; }
        .maintenance-page .history-card th { padding: 8px 5px; font-size: 9px; letter-spacing: .03em; }
        .maintenance-page .history-card td { padding: 8px 5px; font-size: 10px; line-height: 1.35; }
        .maintenance-page .history-card th:nth-child(1), .maintenance-page .history-card td:nth-child(1) { width: 13%; white-space: nowrap; }
        .maintenance-page .history-card th:nth-child(2), .maintenance-page .history-card td:nth-child(2) { width: 14%; }
        .maintenance-page .history-card th:nth-child(3), .maintenance-page .history-card td:nth-child(3) { width: 20%; }
        .maintenance-page .history-card th:nth-child(4), .maintenance-page .history-card td:nth-child(4) { width: 14%; }
        .maintenance-page .history-card th:nth-child(5), .maintenance-page .history-card td:nth-child(5) { width: 15%; }
        .maintenance-page .history-card th:nth-child(6), .maintenance-page .history-card td:nth-child(6) { width: 24%; }
        .maintenance-page .badge { padding: 3px 7px; font-size: 9px; }
        .maintenance-page .message-count { min-height: 30px; gap: 4px; padding: 5px 6px; font-size: 9px; }
        .maintenance-page .message-thread { max-height: 190px; gap: 7px; padding: 9px; }
        .maintenance-page .maintenance-message { padding: 7px 9px; }
        .maintenance-page .message-form { grid-template-columns: minmax(0, 1fr) auto; align-items: end; gap: 8px 10px; margin-top: 12px; }
        .maintenance-page .message-form label,
        .maintenance-page .message-form .field-error { grid-column: 1 / -1; }
        .maintenance-page .message-form label { margin: 0 0 -2px; color: var(--text-primary); font-size: 12px; font-weight: 600; }
        .maintenance-page .message-form textarea { grid-column: 1; min-width: 0; min-height: 44px; height: 44px; padding: 10px 12px; font-size: 13px; line-height: 1.4; }
        .maintenance-page .message-form .field-error { margin: -2px 0 0; color: #9b3b37; font-size: 11px; }
        .maintenance-page .message-form .btn-submit { grid-column: 2; grid-row: 2; align-self: stretch; min-height: 44px; padding: 8px 14px; white-space: nowrap; }
        .maintenance-page .conversation-card { margin-bottom: 12px; padding: 14px; }
        .maintenance-page .conversation-card h3 { margin-bottom: 8px; }
        .maintenance-page .conversation-subtitle { margin: -4px 0 8px; font-size: 10px; }
        .maintenance-page .alert-success, .maintenance-page .alert-error { margin-bottom: 10px; padding: 9px 12px; font-size: 11px; }

        @media (max-width: 1050px) {
            .maintenance-page .top-header, .maintenance-page .student-shared-header { min-height: 56px; padding: 6px 12px !important; }
            .maintenance-page .dashboard-body { padding: 12px 14px !important; }
            .maintenance-page .maintenance-layout { grid-template-columns: 1fr; }
        }
        @media (max-width: 900px) {
            .maintenance-page .metrics-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
        }
        @media (max-width: 600px) {
            .maintenance-page .dashboard-body { padding: 10px 10px !important; }
            .maintenance-page .maintenance-layout { gap: 10px; }
            .maintenance-page .maintenance-layout > .card-panel { padding: 12px; }
            .maintenance-page .history-card th, .maintenance-page .history-card td { padding: 7px 5px; }
            .maintenance-page .message-form { grid-template-columns: minmax(0, 1fr); }
            .maintenance-page .message-form textarea,
            .maintenance-page .message-form .btn-submit { grid-column: 1; }
            .maintenance-page .message-form .btn-submit { grid-row: auto; justify-self: stretch; width: 100%; }
        }
    </style>
</head>
<body class="maintenance-page">
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
                    <section class="card-panel conversation-card" aria-labelledby="maintenanceConversationTitle">
                        <h3 id="maintenanceConversationTitle"><i class="fa-solid fa-comments"></i> Messages with the Admin</h3>
                        <p class="conversation-subtitle">Conversation for this maintenance request.</p>
                        <div class="message-thread" aria-live="polite">
                            @forelse($selectedRequest->messages as $message)
                                <article class="maintenance-message {{ (int) $message->user_id === (int) auth()->id() ? 'is-mine' : '' }}">
                                    <div class="maintenance-message-meta">
                                        <strong>{{ (int) $message->user_id === (int) auth()->id() ? 'You' : ($message->user->name ?? 'Dorm Admin') }}</strong>
                                        <time datetime="{{ $message->created_at->toIso8601String() }}">{{ $message->created_at->format('M d, g:i A') }}</time>
                                    </div>
                                    <p class="maintenance-message-body">{{ $message->body }}</p>
                                </article>
                            @empty
                                <p class="message-empty">No messages yet. Send a message to contact the dorm administrator.</p>
                            @endforelse
                        </div>
                        <form class="message-form" method="POST" action="{{ route('maintenance.messages.store', $selectedRequest) }}">
                            @csrf
                            <label for="maintenanceMessage">Your message</label>
                            <textarea id="maintenanceMessage" name="body" maxlength="2000" required placeholder="Write a message about this request...">{{ old('body') }}</textarea>
                            @error('body') <div class="field-error">{{ $message }}</div> @enderror
                            <button type="submit" class="btn-submit"><i class="fa-solid fa-paper-plane"></i> Send Message</button>
                        </form>
                    </section>
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
                        <div class="history-table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Messages</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $req)
                                    <tr>
                                        <td>{{ $req->created_at->format('M d, Y') }}</td>
                                        <td>{{ \Illuminate\Support\Str::startsWith($req->title, '[') ? \Illuminate\Support\Str::before(\Illuminate\Support\Str::after($req->title, '['), ']') : 'Other' }}</td>
                                        <td><div class="desc-cell">{{ \Illuminate\Support\Str::limit($req->description, 120) }}</div></td>
                                        <td><span class="badge badge-priority-{{ $req->priority }}">{{ $req->priority }}</span></td>
                                        <td>
                                            <span class="badge badge-{{ $req->status }}">{{ str_replace('_', ' ', $req->status) }}</span>
                                            @if ($req->due_at)
                                                <small class="form-hint">Target: {{ $req->due_at->format('M d, Y') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <form class="message-action-form" method="GET" action="{{ route('maintenance.show', $req) }}">
                                                <button class="message-count" type="submit" aria-label="Open {{ $req->messages_count }} messages for this request">
                                                    <i class="fa-solid fa-comments" aria-hidden="true"></i> Messages ({{ $req->messages_count }})
                                                </button>
                                            </form>
                                        </td>
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
            </div>
        </main>
    </div>
    @include('student.partials.announcement-bell-script')
</body>
</html>
