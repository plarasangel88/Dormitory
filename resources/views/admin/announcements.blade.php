<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Announcements - Dorm Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('admin.partials.theme')
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; }
        .app-container { display: flex; min-height: 100vh; }
        .sidebar { display: flex; flex-direction: column; }
        .main-content { min-width: 0; flex: 1; }
        .top-header { display: flex; justify-content: space-between; align-items: center; }
        .admin-profile-badge { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .admin-profile-badge .avatar { display: flex; align-items: center; justify-content: center; }
        .admin-profile-badge .user-info { display: flex; flex-direction: column; }
        .dashboard-body { padding: 30px 35px; }
        .welcome-banner { display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; }
        .welcome-banner p { margin: 6px 0 0; color: #d3dbea; font-size: 13px; }
        .announcement-stats { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin-bottom: 22px; }
        .announcement-stat, .announcement-panel { background: #fff; border: 1px solid var(--border-color); border-radius: 14px; box-shadow: 0 5px 20px #172b4d0f; }
        .announcement-stat { padding: 18px 20px; }
        .announcement-stat span { display: block; color: var(--slate); font-size: 10px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
        .announcement-stat strong { display: block; margin-top: 6px; color: var(--navy-deep); font-size: 24px; }
        .announcement-layout { display: grid; grid-template-columns: minmax(280px, .85fr) minmax(0, 1.4fr); gap: 14px; align-items: start; }
        .announcement-panel { padding: 16px; }
        .announcement-panel h2 { margin: 0 0 6px; color: var(--navy-deep); font-size: 16px; }
        .panel-description { margin: 0 0 12px; color: var(--slate); font-size: 12px; line-height: 1.5; }
        .form-group { margin-bottom: 10px; }
        .form-group label { display: block; margin-bottom: 7px; color: var(--ink); font-size: 12px; font-weight: 600; }
        .form-control { width: 100%; padding: 11px 12px; border: 1px solid var(--border-color); border-radius: 9px; background: #fff; color: var(--ink); font: inherit; font-size: 13px; }
        .form-control:focus { border-color: var(--amber); outline: 3px solid #f3b33d2e; }
        textarea.form-control { min-height: 120px; resize: vertical; line-height: 1.5; }
        .pin-option { display: flex; align-items: center; gap: 8px; margin: 3px 0 12px; color: var(--ink); font-size: 12px; }
        .pin-option input { accent-color: var(--navy-deep); }
        .submit-button, .delete-button { display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: 0; border-radius: 9px; cursor: pointer; font: inherit; font-size: 12px; font-weight: 700; }
        .submit-button { width: 100%; padding: 12px 16px; background: var(--navy-deep); color: #fff; }
        .submit-button:hover { background: var(--navy-mid); }
        .announcement-list { display: flex; flex-direction: column; gap: 8px; }
        .announcement-entry { padding: 13px; border: 1px solid var(--border-color); border-radius: 11px; background: #fff; }
        .announcement-entry-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .announcement-entry h3 { margin: 0; color: var(--navy-deep); font-size: 14px; line-height: 1.5; overflow-wrap: anywhere; }
        .announcement-meta { margin-top: 5px; color: var(--slate); font-size: 10px; }
        .announcement-message { margin: 13px 0 0; color: var(--ink); font-size: 12px; line-height: 1.7; white-space: pre-wrap; overflow-wrap: anywhere; }
        .announcement-badges { display: flex; align-items: center; gap: 8px; flex: 0 0 auto; }
        .pinned-badge { padding: 4px 8px; border-radius: 999px; background: #fbead3; color: #8d5b16; font-size: 9px; font-weight: 700; }
        .delete-button { padding: 7px 9px; background: #f9e8e5; color: #a8412b; }
        .delete-button:hover { background: #a8412b; color: #fff; }
        .empty-state { padding: 38px 16px; text-align: center; color: var(--slate); font-size: 13px; }
        .empty-state i { display: block; margin-bottom: 11px; color: var(--amber); font-size: 24px; }
        .field-error { margin-top: 6px; color: #a8412b; font-size: 11px; }
        .alert { margin-bottom: 18px; padding: 12px 15px; border-radius: 9px; font-size: 12px; }
        .alert-success { background: #e1efe6; color: #327049; }
        .alert-error { background: #f6e2dd; color: #a8412b; }
        .pagination-wrap { margin-top: 18px; }
        @media (max-width: 950px) { .announcement-layout { grid-template-columns: 1fr; } }
        @media (max-width: 600px) { .dashboard-body { padding: 18px 14px; } .announcement-stats { gap: 10px; } .announcement-stat { padding: 15px; } .announcement-panel { padding: 17px; } .announcement-entry-header { flex-direction: column; } }
    </style>
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <a class="sidebar-brand" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-building-user"></i><span>Dorm Portal</span></a>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a href="{{ route('admin.announcements.index') }}" class="menu-item active"><i class="fa-solid fa-bullhorn"></i> Announcements</a>
                <a href="{{ route('admin.students.index') }}" class="menu-item"><i class="fa-solid fa-user-graduate"></i> Students</a>
                <a href="{{ route('admin.rooms.index') }}" class="menu-item"><i class="fa-solid fa-door-closed"></i> Rooms</a>
                <a href="{{ route('admin.payments.index') }}" class="menu-item"><i class="fa-solid fa-wallet"></i> Payments &amp; Billing</a>
                <a href="{{ route('admin.maintenance.index') }}" class="menu-item"><i class="fa-solid fa-wrench"></i> Maintenance</a>
            </nav>
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="admin-page-heading"><strong>Announcements</strong><small>Publish updates and review announcement history</small></div>
                @include('admin.partials.notification-bell')
                <div class="admin-profile-badge">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info"><span class="user-name">{{ auth()->user()->name }}</span><span class="user-role">ADMIN</span></div>
                </div>
            </header>

            <div class="dashboard-body">
                <div class="welcome-banner">
                    <div>
                        <div class="banner-feature-name" role="heading" aria-level="1">Announcement Center</div>
                        <p>Create announcements for residents and review everything previously posted.</p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
                @endif

                <section class="announcement-stats" aria-label="Announcement totals">
                    <div class="announcement-stat"><span>All announcements</span><strong>{{ $totalAnnouncements }}</strong></div>
                    <div class="announcement-stat"><span>Pinned announcements</span><strong>{{ $pinnedAnnouncements }}</strong></div>
                </section>

                <div class="announcement-layout">
                    <section class="announcement-panel" id="new-announcement">
                        <h2><i class="fa-solid fa-pen-to-square"></i> New announcement</h2>
                        <p class="panel-description">Post a message that will appear in the residents’ announcement feed.</p>
                        <form action="{{ route('admin.announcements.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Announcement title</label>
                                <input class="form-control" id="title" name="title" type="text" value="{{ old('title') }}" maxlength="150" required>
                                @error('title') <div class="field-error">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label for="body">Message</label>
                                <textarea class="form-control" id="body" name="body" maxlength="2000" required>{{ old('body') }}</textarea>
                                @error('body') <div class="field-error">{{ $message }}</div> @enderror
                            </div>
                            <label class="pin-option"><input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }}> Pin this announcement to the top</label>
                            <button class="submit-button" type="submit"><i class="fa-solid fa-paper-plane"></i> Post announcement</button>
                        </form>
                    </section>

                    <section class="announcement-panel" aria-labelledby="announcement-history-title">
                        <h2 id="announcement-history-title"><i class="fa-solid fa-clock-rotate-left"></i> Announcement history</h2>
                        <p class="panel-description">Newest announcements appear first. Pinned items stay at the top.</p>
                        <div class="announcement-list">
                            @forelse ($announcements as $announcement)
                                <article class="announcement-entry">
                                    <div class="announcement-entry-header">
                                        <div>
                                            <h3>{{ $announcement->title }}</h3>
                                            <div class="announcement-meta">Posted by {{ $announcement->author?->name ?? 'Admin' }} · {{ $announcement->created_at->diffForHumans() }}</div>
                                        </div>
                                        <div class="announcement-badges">
                                            @if ($announcement->is_pinned)
                                                <span class="pinned-badge"><i class="fa-solid fa-thumbtack"></i> PINNED</span>
                                            @endif
                                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Delete this announcement? Residents will no longer see it.');">
                                                @csrf
                                                <button class="delete-button" type="submit" aria-label="Delete {{ $announcement->title }}"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="announcement-message">{{ $announcement->body }}</p>
                                </article>
                            @empty
                                <div class="empty-state"><i class="fa-solid fa-bullhorn"></i>No announcements have been posted yet.</div>
                            @endforelse
                        </div>
                        <div class="pagination-wrap">{{ $announcements->links() }}</div>
                    </section>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
