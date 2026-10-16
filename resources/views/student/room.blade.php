<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Room - Dorm Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy-deep: #16213E; --navy-mid: #24345C; --navy-soft: #3A4E7A;
            --amber: #F0A857; --amber-soft: #F6C98B; --paper: #FBF8F2;
            --ink: #2A2620; --slate: #8993A8;
            --bg-main: var(--paper); --sidebar-bg: var(--navy-deep); --card-bg: #FFFFFF;
            --text-primary: var(--ink); --text-secondary: var(--slate); --border-color: #E3DFD5;
            --primary-blue: var(--navy-soft); --primary-hover: var(--navy-mid);
            --success-green: #4E9A6B; --warning-orange: var(--amber); --danger-red: #C4573E;
            --purple-accent: #7C6FA6; --teal-accent: #3E8E8A;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-primary); overflow-x: hidden; }
        .app-container { display: flex; min-height: 100vh; }

        .sidebar { width: 260px; background: linear-gradient(180deg, #1B2A4D 0%, #16213E 55%, #101A33 100%); color: #FFF; display: flex; flex-direction: column; padding: 24px 16px; flex-shrink: 0; }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; font-family: 'Fraunces', serif; font-weight: 500; font-size: 1.25rem; margin-bottom: 32px; padding-left: 8px; color: var(--amber); }
        .sidebar-menu { display: flex; flex-direction: column; gap: 8px; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; gap: 12px; color: #B7C0D6; text-decoration: none; padding: 12px 16px; border-radius: 8px; font-weight: 500; font-size: 0.92rem; transition: all 0.2s ease; }
        .menu-item:hover, .menu-item.active { background-color: rgba(240, 168, 87, 0.14); color: #FFF; }
        .menu-item.active { box-shadow: inset 3px 0 0 var(--amber); }
        .sidebar-footer { padding-top: 16px; border-top: 1px solid #334155; }
        .logout-btn { width: 100%; padding: 10px; background: transparent; border: 1px solid #334155; color: #94A3B8; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600; transition: 0.2s; }
        .logout-btn:hover { color: #FFF; background-color: var(--danger-red); border-color: var(--danger-red); }

        .main-content { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .top-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 32px; background-color: #FFF; border-bottom: 1px solid var(--border-color); }
        .search-bar { display: flex; align-items: center; gap: 10px; background-color: var(--paper); border: 1px solid var(--border-color); padding: 10px 16px; border-radius: 20px; width: 360px; color: var(--text-secondary); }
        .search-bar input { border: none; background: transparent; outline: none; width: 100%; font-size: 0.9rem; color: var(--text-primary); }
        .search-bar input::placeholder { color: #B7B2A6; }
        .admin-profile-badge { display: flex; align-items: center; gap: 12px; }
        .avatar { width: 40px; height: 40px; background-color: var(--navy-deep); color: var(--amber); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-family: 'Fraunces', serif; flex-shrink: 0; }
        .user-info { display: flex; flex-direction: column; }
        .user-name { font-size: 0.9rem; font-weight: 600; color: var(--text-primary); }
        .user-role { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.4px; color: var(--text-secondary); }

        .dashboard-body { padding: 32px; overflow-y: auto; }
        .welcome-banner h1 { font-family: 'Fraunces', serif; font-weight: 500; font-size: 1.8rem; color: var(--text-primary); }
        .welcome-banner p { color: var(--text-secondary); margin-top: 4px; margin-bottom: 24px; font-size: 0.92rem; }

        .alert-success { background: #FBEBD4; color: #92400e; padding: 12px 18px; border-radius: 10px; font-size: 13px; margin-bottom: 24px; border: 1px solid var(--amber-soft); display: flex; align-items: center; gap: 10px; }
        .alert-error { background: #F6E2DD; color: #A8412B; padding: 12px 18px; border-radius: 10px; font-size: 13px; margin-bottom: 24px; border: 1px solid rgba(196, 87, 62, 0.3); }
        .alert-error ul { margin-left: 18px; }

        .room-overview-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 18px; box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04); }
        .room-overview-icon { width: 56px; height: 56px; border-radius: 12px; background-color: #FBEBD4; color: var(--warning-orange); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .room-overview-info h2 { font-family: 'Fraunces', serif; font-weight: 500; font-size: 1.25rem; color: var(--text-primary); margin-bottom: 2px; }
        .room-overview-info p { font-size: 0.85rem; color: var(--text-secondary); }
        .room-status-pill { margin-left: auto; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-occupied { background-color: #FBEBD4; color: var(--warning-orange); }

        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .metric-card { background: var(--card-bg); padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04); }
        .metric-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
        .metric-icon.blue { background-color: #EAEEF7; color: var(--primary-blue); }
        .metric-icon.orange { background-color: #FBEBD4; color: var(--warning-orange); }
        .metric-icon.green { background-color: #E1EFE6; color: var(--success-green); }
        .metric-icon.purple { background-color: #EBE7F4; color: var(--purple-accent); }
        .metric-title { font-size: 0.68rem; font-weight: 700; color: var(--text-secondary); letter-spacing: 0.6px; }
        .metric-value { font-family: 'Fraunces', serif; font-size: 1.4rem; font-weight: 600; color: var(--text-primary); margin-top: 4px; text-transform: capitalize; }

        .card-panel { background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04); margin-bottom: 24px; }
        .card-panel h3 { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 8px; margin-bottom: 14px; }
        .card-panel h3 i { color: var(--amber); }
        .panel-hint { font-size: 0.78rem; color: var(--text-secondary); margin: -8px 0 14px; }

        /* Roommates */
        .roommates-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 12px; }
        .roommate-card { display: flex; flex-direction: column; gap: 12px; padding: 14px; background-color: var(--paper); border: 1px solid var(--border-color); border-radius: 10px; transition: all 0.2s ease; }
        .roommate-card:hover { border-color: var(--amber); }
        .roommate-head { display: flex; align-items: center; gap: 12px; }
        .roommate-meta { flex: 1; min-width: 0; }
        .roommate-name { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); }
        .roommate-course { font-size: 0.72rem; color: var(--text-secondary); margin-top: 1px; }
        .you-tag { display: inline-block; margin-left: 6px; padding: 1px 8px; border-radius: 20px; background: #FBEBD4; color: #92400e; font-size: 0.62rem; font-weight: 700; letter-spacing: 0.4px; vertical-align: middle; }
        .task-count { font-size: 0.68rem; font-weight: 700; color: var(--text-secondary); white-space: nowrap; }

        /* Task rows */
        .task-list { display: flex; flex-direction: column; gap: 8px; }
        .task-row { display: flex; align-items: center; gap: 10px; padding: 8px 10px; background: #FFFFFF; border: 1px dashed var(--amber-soft); border-radius: 8px; font-size: 0.78rem; }
        .task-row form { display: contents; }
        .task-row input[type=checkbox] { accent-color: var(--success-green); cursor: pointer; width: 16px; height: 16px; flex-shrink: 0; }
        .task-row input[type=checkbox]:disabled { cursor: not-allowed; opacity: .5; }
        .task-body { flex: 1; min-width: 0; }
        .task-title { font-weight: 600; color: var(--text-primary); word-break: break-word; }
        .task-by { font-size: 0.66rem; color: var(--text-secondary); margin-top: 1px; }
        .task-row.done { background: #E1EFE6; border-color: var(--success-green); border-style: solid; }
        .task-row.done .task-title { text-decoration: line-through; color: var(--text-secondary); }
        .task-del { background: none; border: none; color: var(--text-secondary); cursor: pointer; font-size: 0.8rem; padding: 4px; }
        .task-del:hover { color: var(--danger-red); }
        .task-empty { font-size: 0.75rem; color: var(--text-secondary); padding: 6px 2px; }

        /* Assign form */
        .assign-form { display: grid; grid-template-columns: 1.1fr 2fr 1fr auto; gap: 12px; align-items: end; }
        .form-label { display: block; font-size: 0.72rem; font-weight: 700; color: var(--text-secondary); letter-spacing: 0.4px; margin-bottom: 6px; text-transform: uppercase; }
        .form-control { width: 100%; padding: 10px 12px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 0.85rem; color: var(--text-primary); background: var(--paper); outline: none; }
        .form-control:focus { border-color: var(--amber); }
        .btn-assign { padding: 11px 18px; background: var(--navy-deep); border: 1.5px solid var(--navy-deep); border-radius: 8px; color: #FFF; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease; }
        .btn-assign i { color: var(--amber); }
        .btn-assign:hover { background: var(--navy-mid); border-color: var(--navy-mid); }

        /* Upcoming */
        .schedule-wrap { overflow-x: auto; }
        .schedule-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; min-width: 560px; }
        .schedule-table th, .schedule-table td { padding: 10px 12px; border-bottom: 1px solid var(--border-color); text-align: left; }
        .schedule-table th { font-size: 0.68rem; letter-spacing: 0.6px; color: var(--text-secondary); font-weight: 700; text-transform: uppercase; }
        .schedule-table td.done { text-decoration: line-through; color: var(--text-secondary); }

        .empty-state { text-align: center; color: var(--text-secondary); font-size: 0.88rem; padding: 12px; }

        .amenities-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; }
        .amenity-chip { padding: 12px 16px; background-color: var(--paper); border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 0.85rem; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 10px; }
        .amenity-chip i { color: var(--amber); width: 16px; text-align: center; }

        .quick-actions-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .action-btn { padding: 12px 16px; background-color: var(--paper); border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 0.85rem; font-weight: 600; color: var(--text-primary); cursor: pointer; display: flex; align-items: center; gap: 8px; text-decoration: none; transition: all 0.2s ease; }
        .action-btn:hover { background-color: var(--navy-deep); color: #FFF; border-color: var(--navy-deep); }
        .action-btn:hover i { color: var(--amber); }

        .no-room-card { background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: 12px; padding: 48px; text-align: center; }
        .no-room-card i { font-size: 2rem; color: var(--warning-orange); margin-bottom: 12px; }
        .no-room-card p.title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; }
        .no-room-card p.desc { color: var(--text-secondary); font-size: 0.88rem; }

        @media (max-width: 860px) {
            .app-container { flex-direction: column; }
            .sidebar { width: 100%; flex-direction: row; align-items: center; padding: 16px 20px; overflow-x: auto; }
            .sidebar-brand { margin-bottom: 0; padding-left: 0; margin-right: 16px; }
            .sidebar-menu { flex-direction: row; }
            .sidebar-footer { padding-top: 0; border-top: none; margin-left: 12px; }
            .quick-actions-grid { grid-template-columns: 1fr; }
            .assign-form { grid-template-columns: 1fr; }
            .search-bar { width: 220px; }
        }
    </style>
    @include('student.partials.theme')
</head>
<body>
    <div class="app-container">
        @include('student.partials.sidebar')

        <main class="main-content">
            <header class="top-header">
                <button class="student-menu-toggle" type="button" data-student-sidebar-toggle aria-label="Open navigation"><i class="fa-solid fa-bars"></i></button>
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search...">
                </div>
                @include('student.partials.announcement-bell')
                <div class="admin-profile-badge">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ strtoupper(auth()->user()->role) }}</span>
                    </div>
                </div>
            </header>

            <div class="dashboard-body">
                <div class="welcome-banner">
                    <h1>My Room</h1>
                    <p>View your room assignment, roommates, daily tasks, and amenities</p>
                </div>

                @if(session('success'))
                    <div class="alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert-error">
                        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                {{-- ASSUMPTIONS:
                     - users.room_id is set by the admin when a student is assigned to a room
                     - User::room() belongsTo Room, and Room::students() hasMany User
                       (the admin Rooms page already uses students_count, so this likely exists) --}}
                @if(auth()->user()->room)
                    @php
                        $me    = auth()->user();
                        $room  = $me->room;
                        $today = now();

                        // Everyone the admin placed in this room (+ you, de-duplicated, same order for everyone).
                        $members = collect([$me])
                            ->concat($room->students ?? [])
                            ->unique('id')
                            ->sortBy('id')
                            ->values();

                        // Today's tasks for the whole room, grouped per assigned member.
                        $tasksToday = \App\Models\RoomTask::with('assigner')
                            ->where('room_id', $room->id)
                            ->whereDate('task_date', $today)
                            ->orderBy('is_done')->orderBy('id')
                            ->get()
                            ->groupBy('assigned_to');

                        // Next 7 days (after today).
                        $upcoming = \App\Models\RoomTask::with(['assignee', 'assigner'])
                            ->where('room_id', $room->id)
                            ->whereDate('task_date', '>', $today)
                            ->whereDate('task_date', '<=', $today->copy()->addDays(7))
                            ->orderBy('task_date')->orderBy('id')
                            ->get();
                    @endphp

                    <!-- Room Overview -->
                    <div class="room-overview-card">
                        <div class="room-overview-icon"><i class="fa-solid fa-door-closed"></i></div>
                        <div class="room-overview-info">
                            <h2>Room {{ $room->room_number }}</h2>
                            <p>{{ $room->building ?? 'Main Building' }} · Floor {{ $room->floor ?? '-' }}</p>
                        </div>
                        <div class="room-status-pill status-occupied">Occupied</div>
                    </div>

                    <!-- Room Details -->
                    <section class="metrics-grid">
                        <div class="metric-card">
                            <div class="metric-icon blue"><i class="fa-solid fa-bed"></i></div>
                            <div class="metric-info">
                                <span class="metric-title">ROOM TYPE</span>
                                <div class="metric-value">{{ $room->type ?? 'Standard' }}</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon orange"><i class="fa-solid fa-users"></i></div>
                            <div class="metric-info">
                                <span class="metric-title">CAPACITY</span>
                                <div class="metric-value">{{ $room->capacity ?? '-' }} beds</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon green"><i class="fa-solid fa-user-group"></i></div>
                            <div class="metric-info">
                                <span class="metric-title">OCCUPANTS</span>
                                <div class="metric-value">{{ $members->count() }}</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon purple"><i class="fa-solid fa-peso-sign"></i></div>
                            <div class="metric-info">
                                <span class="metric-title">MONTHLY RATE</span>
                                <div class="metric-value">₱{{ number_format($room->monthly_rate ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </section>

                    <!-- Roommates + today's tasks -->
                    <div class="card-panel">
                        <h3><i class="fa-solid fa-people-roof"></i> Roommates &amp; Today's Tasks</h3>
                        <p class="panel-hint">Roommates are the students your admin assigned to this room. {{ $today->format('l, M j') }}</p>

                        @if($members->count() <= 1)
                            <div class="empty-state" style="padding-top:0">No roommates assigned to your room yet. You can still assign tasks to yourself below.</div>
                        @endif

                        <div class="roommates-grid">
                            @foreach($members as $member)
                                @php
                                    $isYou   = $member->id === $me->id;
                                    $tasks   = $tasksToday->get($member->id, collect());
                                    $doneCnt = $tasks->where('is_done', true)->count();
                                @endphp
                                <div class="roommate-card">
                                    <div class="roommate-head">
                                        <div class="avatar">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                                        <div class="roommate-meta">
                                            <div class="roommate-name">
                                                {{ $member->name }}
                                                @if($isYou)<span class="you-tag">YOU</span>@endif
                                            </div>
                                            <div class="roommate-course">{{ $member->course ?? 'No course listed' }}</div>
                                        </div>
                                        <span class="task-count">{{ $doneCnt }}/{{ $tasks->count() }} done</span>
                                    </div>

                                    <div class="task-list">
                                        @forelse($tasks as $task)
                                            @php $canToggle = in_array($me->id, [$task->assigned_to, $task->assigned_by]); @endphp
                                            <div class="task-row {{ $task->is_done ? 'done' : '' }}">
                                                <form method="POST" action="{{ route('room.tasks.toggle', $task) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="checkbox" {{ $task->is_done ? 'checked' : '' }}
                                                           {{ $canToggle ? '' : 'disabled' }}
                                                           onchange="this.form.submit()"
                                                           aria-label="Mark '{{ $task->title }}' done for {{ $member->name }}">
                                                </form>
                                                <div class="task-body">
                                                    <div class="task-title">{{ $task->title }}</div>
                                                    <div class="task-by">
                                                        Assigned by {{ $task->assigned_by === $me->id ? 'you' : ($task->assigner->name ?? 'a roommate') }}
                                                    </div>
                                                </div>
                                                @if($task->assigned_by === $me->id)
                                                    <form method="POST" action="{{ route('room.tasks.destroy', $task) }}"
                                                          onsubmit="return confirm('Remove this task?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="task-del" title="Remove task"><i class="fa-solid fa-xmark"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="task-empty">No tasks for today.</div>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Assign a task -->
                    <div class="card-panel">
                        <h3><i class="fa-solid fa-list-check"></i> Assign a Task</h3>
                        <form method="POST" action="{{ route('room.tasks.store') }}" class="assign-form">
                            @csrf
                            <div>
                                <label class="form-label" for="assigned_to">Assign to</label>
                                <select name="assigned_to" id="assigned_to" class="form-control" required>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" {{ (string) old('assigned_to', $me->id) === (string) $member->id ? 'selected' : '' }}>
                                            {{ $member->name }}{{ $member->id === $me->id ? ' (Myself)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label" for="title">Task</label>
                                <input type="text" name="title" id="title" class="form-control" maxlength="120"
                                       placeholder="e.g. Sweep & mop the floor" value="{{ old('title') }}" required>
                            </div>
                            <div>
                                <label class="form-label" for="task_date">Date</label>
                                <input type="date" name="task_date" id="task_date" class="form-control"
                                       min="{{ $today->toDateString() }}" value="{{ old('task_date', $today->toDateString()) }}" required>
                            </div>
                            <button type="submit" class="btn-assign"><i class="fa-solid fa-plus"></i> Assign</button>
                        </form>
                    </div>

                    <!-- Upcoming tasks -->
                    @if($upcoming->isNotEmpty())
                        <div class="card-panel">
                            <h3><i class="fa-solid fa-calendar-check"></i> Upcoming Tasks (Next 7 Days)</h3>
                            <div class="schedule-wrap">
                                <table class="schedule-table">
                                    <thead>
                                        <tr><th>Date</th><th>Member</th><th>Task</th><th>Assigned by</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach($upcoming as $task)
                                            <tr>
                                                <td>{{ $task->task_date->format('D, M j') }}</td>
                                                <td>{{ $task->assignee->name ?? '—' }}@if($task->assigned_to === $me->id) (You)@endif</td>
                                                <td class="{{ $task->is_done ? 'done' : '' }}">{{ $task->title }}</td>
                                                <td>{{ $task->assigned_by === $me->id ? 'You' : ($task->assigner->name ?? '—') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Amenities -->
                    <div class="card-panel">
                        <h3><i class="fa-solid fa-star"></i> Room Amenities</h3>
                        <div class="amenities-grid">
                            <div class="amenity-chip"><i class="fa-solid fa-snowflake"></i> Air Conditioning</div>
                            <div class="amenity-chip"><i class="fa-solid fa-wifi"></i> WiFi</div>
                            <div class="amenity-chip"><i class="fa-solid fa-table-cells"></i> Private Window</div>
                            <div class="amenity-chip"><i class="fa-solid fa-shower"></i> Shared Bathroom</div>
                            <div class="amenity-chip"><i class="fa-solid fa-box-archive"></i> Personal Locker</div>
                            <div class="amenity-chip"><i class="fa-solid fa-pen-to-square"></i> Study Desk</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card-panel">
                        <h3><i class="fa-solid fa-bolt"></i> Quick Actions</h3>
                        <div class="quick-actions-grid">
                            <a href="{{ route('maintenance.index') }}" class="action-btn"><i class="fa-solid fa-wrench"></i> Report an Issue</a>
                            <a href="#" class="action-btn"><i class="fa-solid fa-arrows-rotate"></i> Request Room Change</a>
                        </div>
                    </div>

                @else
                    <div class="no-room-card">
                        <i class="fa-solid fa-house-circle-exclamation"></i>
                        <p class="title">No Room Assigned Yet</p>
                        <p class="desc">Please contact the dormitory administrator to get a room assigned to your account.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
    @include('student.partials.announcement-bell-script')
</body>
</html>
