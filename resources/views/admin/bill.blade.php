<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Billing - Dorm Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f7f5ef; color: #252a34; font: 15px Arial, sans-serif; }
        .shell { display: flex; min-height: 100vh; }
        .sidebar { width: 230px; flex: 0 0 230px; padding: 24px 14px; background: #16213e; color: white; }
        .brand { display: block; color: #f0a857; font-size: 20px; font-weight: bold; text-decoration: none; margin: 4px 8px 28px; }
        .nav a { display: block; padding: 12px; margin: 5px 0; border-radius: 7px; color: #d7dced; text-decoration: none; }
        .nav a:hover, .nav a.active { background: #2b3959; color: white; }
        .logout { margin-top: 30px; }
        .logout button { width: 100%; padding: 10px; border: 1px solid #51607e; border-radius: 7px; background: transparent; color: white; cursor: pointer; }
        main { min-width: 0; flex: 1; padding: 30px; }
        h1 { margin: 0 0 7px; font-size: 27px; }
        .sub { color: #697386; margin: 0 0 24px; }
        .card { background: white; border: 1px solid #e2dfd6; border-radius: 10px; padding: 20px; margin-bottom: 22px; }
        .card h2 { margin: 0 0 16px; font-size: 18px; }
        .form-grid { display: grid; grid-template-columns: repeat(3, minmax(140px, 1fr)); gap: 14px; }
        label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: bold; }
        input, select { width: 100%; min-height: 40px; padding: 8px 10px; border: 1px solid #cfd3dc; border-radius: 6px; background: white; }
        .check { display: flex; gap: 8px; align-items: center; margin: 16px 0; }
        .check input { width: auto; min-height: auto; }
        button.primary { padding: 10px 16px; border: 0; border-radius: 6px; background: #16213e; color: white; font-weight: bold; cursor: pointer; }
        .alert { padding: 12px 14px; border-radius: 7px; margin: 14px 0; }
        .success { background: #e5f3e9; color: #24633b; }
        .error { background: #fff0ed; color: #933d32; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        th, td { padding: 11px 9px; border-bottom: 1px solid #ece9e2; text-align: left; }
        th { color: #697386; font-size: 12px; text-transform: uppercase; }
        .actions { display: flex; gap: 7px; align-items: center; }
        .actions button { padding: 7px 9px; border: 1px solid #cfd3dc; background: white; border-radius: 5px; cursor: pointer; }
        .actions .delete { color: #a63f36; }
        .pill { display: inline-block; padding: 5px 9px; border-radius: 20px; background: #fff1d9; color: #805514; }
        .pill.paid { background: #e4f3e8; color: #24633b; }
        dialog { width: min(460px, calc(100% - 24px)); border: 0; border-radius: 10px; padding: 22px; box-shadow: 0 12px 40px #0003; }
        dialog::backdrop { background: #101a3380; }
        dialog form { display: grid; gap: 12px; }
        .dialog-actions { display: flex; justify-content: flex-end; gap: 8px; }
        @media (max-width: 760px) { .shell { display: block; } .sidebar { width: 100%; } .nav { display: flex; flex-wrap: wrap; } .nav a { padding: 9px; } main { padding: 18px 12px; } .form-grid { grid-template-columns: 1fr; } }
    </style>
    @include('admin.partials.theme')
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-building-user"></i> Dorm Portal</a>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="{{ route('admin.students.index') }}"><i class="fa-solid fa-user-graduate"></i> Students</a>
            <a href="{{ route('admin.rooms.index') }}"><i class="fa-solid fa-door-closed"></i> Rooms</a>
            <a class="active" href="{{ route('admin.payments.index') }}"><i class="fa-solid fa-wallet"></i> Payments &amp; Billing</a>
            <a href="{{ route('admin.maintenance.index') }}"><i class="fa-solid fa-wrench"></i> Maintenance</a>
        </nav>
        <form class="logout" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"><i class="fa-solid fa-right-from-bracket"></i> Log out</button>
        </form>
    </aside>

    <main>
        <header class="top-header">
            <div class="admin-page-heading"><strong>Billing</strong><small>Create and review monthly room bills</small></div>
            <div class="admin-profile-badge">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-info"><span class="user-name">{{ auth()->user()->name }}</span><span class="user-role">ADMIN</span></div>
            </div>
        </header>
        <div class="welcome-banner">
            <div class="banner-feature-name" role="heading" aria-level="1">Billing Management</div>
            <p>Create room bills for rent, electricity, and water. Students can view balances under Payments.</p>
        </div>

        @if (session('success')) <div class="alert success">{{ session('success') }}</div> @endif
        @if ($errors->any())
            <div class="alert error"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <section class="card">
            <h2>Create or update bills for a room</h2>
            <form action="{{ route('admin.bills.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div>
                        <label for="roomSelect">Room</label>
                        <select name="room_id" id="roomSelect" required>
                            @forelse ($rooms as $room)
                                <option value="{{ $room->id }}" data-rate="{{ $room->monthly_rate ?? 0 }}" @selected(old('room_id') == $room->id)>
                                    Room {{ $room->room_number }} ({{ $room->students_count }} students)
                                </option>
                            @empty
                                <option value="">No rooms available</option>
                            @endforelse
                        </select>
                    </div>
                    <div><label for="billingMonth">Billing month</label><input id="billingMonth" type="month" name="billing_month" value="{{ old('billing_month', $month->format('Y-m')) }}" required></div>
                    <div><label for="dueDate">Due date</label><input id="dueDate" type="date" name="due_date" value="{{ old('due_date') }}"></div>
                    <div><label for="rentInput">Rent per student</label><input id="rentInput" type="number" step="0.01" min="0" name="rent" value="{{ old('rent') }}" required></div>
                    <div><label for="electricity">Electricity (room total)</label><input id="electricity" type="number" step="0.01" min="0" name="electricity" value="{{ old('electricity', 0) }}" required></div>
                    <div><label for="water">Water (room total)</label><input id="water" type="number" step="0.01" min="0" name="water" value="{{ old('water', 0) }}" required></div>
                </div>
                <label class="check"><input type="checkbox" name="split" value="1" @checked(old('split', '1'))> Split electricity and water evenly among assigned students</label>
                <button class="primary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save bills</button>
            </form>
        </section>

        <section class="card">
            <form method="GET" style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:14px">
                <h2 style="margin:0">Bills for {{ $month->format('F Y') }}</h2>
                <input aria-label="Filter billing month" type="month" name="month" value="{{ $month->format('Y-m') }}" onchange="this.form.submit()">
            </form>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Student</th><th>Room</th><th>Rent</th><th>Electricity</th><th>Water</th><th>Total</th><th>Due date</th><th>Balance</th><th>Actions</th></tr></thead>
                    <tbody>
                    @forelse ($bills as $bill)
                        <tr>
                            <td>{{ $bill->student->name ?? 'Unknown student' }}</td>
                            <td>{{ $bill->room->room_number ?? '—' }}</td>
                            <td>₱{{ number_format($bill->rent, 2) }}</td>
                            <td>₱{{ number_format($bill->electricity, 2) }}</td>
                            <td>₱{{ number_format($bill->water, 2) }}</td>
                            <td><strong>₱{{ number_format($bill->total, 2) }}</strong></td>
                            <td>{{ $bill->due_date?->format('M d, Y') ?? '—' }}</td>
                            <td><span class="pill {{ $bill->balance <= 0 ? 'paid' : '' }}">{{ $bill->balance <= 0 ? 'Settled' : '₱'.number_format($bill->balance, 2) }}</span></td>
                            <td class="actions">
                                <button type="button" onclick="document.getElementById('editBill{{ $bill->id }}').showModal()" aria-label="Edit bill"><i class="fa-solid fa-pen"></i></button>
                                <form action="{{ route('admin.bills.destroy', $bill) }}" method="POST" onsubmit="return confirm('Delete this bill?')">
                                    @csrf @method('DELETE')
                                    <button class="delete" type="submit" aria-label="Delete bill"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9">No bills for this month yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        @foreach ($bills as $bill)
            <dialog id="editBill{{ $bill->id }}">
                <form action="{{ route('admin.bills.update', $bill) }}" method="POST">
                    @csrf @method('PUT')
                    <h2>Edit {{ $bill->student->name ?? 'student bill' }} · {{ $month->format('F Y') }}</h2>
                    <div><label>Rent</label><input type="number" step="0.01" min="0" name="rent" value="{{ $bill->rent }}" required></div>
                    <div><label>Electricity</label><input type="number" step="0.01" min="0" name="electricity" value="{{ $bill->electricity }}" required></div>
                    <div><label>Water</label><input type="number" step="0.01" min="0" name="water" value="{{ $bill->water }}" required></div>
                    <div><label>Due date</label><input type="date" name="due_date" value="{{ $bill->due_date?->format('Y-m-d') }}"></div>
                    <div class="dialog-actions">
                        <button type="button" onclick="this.closest('dialog').close()">Cancel</button>
                        <button class="primary" type="submit">Save changes</button>
                    </div>
                </form>
            </dialog>
        @endforeach
    </main>
</div>
<script>
    const roomSelect = document.getElementById('roomSelect');
    const rentInput = document.getElementById('rentInput');
    function setRoomRent() {
        const option = roomSelect?.selectedOptions[0];
        if (option && !rentInput.value) rentInput.value = option.dataset.rate || '0';
    }
    roomSelect?.addEventListener('change', () => { rentInput.value = roomSelect.selectedOptions[0]?.dataset.rate || '0'; });
    setRoomRent();
</script>
</body>
</html>
