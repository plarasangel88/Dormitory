<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Dorm Portal</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Theme base */
            --navy-deep: #16213E;
            --navy-mid: #24345C;
            --navy-soft: #3A4E7A;
            --amber: #F0A857;
            --amber-soft: #F6C98B;
            --amber-tint: #FBEBD4;
            --amber-deep: #A9721F;
            --paper: #FBF8F2;
            --ink: #2A2620;
            --slate: #8993A8;

            /* Mapped app tokens */
            --bg-main: var(--paper);
            --sidebar-bg: var(--navy-deep);
            --card-bg: #FFFFFF;
            --text-primary: var(--ink);
            --text-secondary: var(--slate);
            --border-color: #E3DFD5;

            /* Status & Accent Colors */
            --primary-blue: var(--navy-soft);
            --primary-hover: var(--navy-mid);
            --success-green: #4E9A6B;
            --warning-orange: var(--amber);
            --danger-red: #C4573E;
            --purple-accent: #7C6FA6;
            --teal-accent: #3E8E8A;
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

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Navigation */
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

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

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

        .menu-item:hover, .menu-item.active {
            background-color: rgba(240, 168, 87, 0.14);
            color: #FFF;
        }

        .menu-item.active {
            box-shadow: inset 3px 0 0 var(--amber);
        }

        .sidebar-footer {
            padding-top: 16px;
            border-top: 1px solid #334155;
        }

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

        .logout-btn:hover {
            color: #FFF;
            background-color: var(--danger-red);
            border-color: var(--danger-red);
        }

        /* Main Area */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 32px;
            background-color: #FFF;
            border-bottom: 1px solid var(--border-color);
            gap: 16px;
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
            max-width: 100%;
            color: var(--text-secondary);
        }

        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        .search-bar input::placeholder {
            color: #B7B2A6;
        }

        .admin-profile-badge {
            display: flex;
            align-items: center;
            gap: 12px;
        }

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

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            color: var(--text-secondary);
        }

        /* Page Container */
        .dashboard-body {
            padding: 32px;
            overflow-y: auto;
        }

        .welcome-banner {
            margin-bottom: 24px;
        }

        .welcome-banner h1 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 1.8rem;
            color: var(--text-primary);
        }

        .welcome-banner p {
            color: var(--text-secondary);
            margin-top: 4px;
            font-size: 0.92rem;
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #E1EFE6;
            color: #327049;
            border: 1px solid rgba(78, 154, 107, 0.3);
        }

        .alert-error {
            background: #F6E2DD;
            color: #A8412B;
            border: 1px solid rgba(196, 87, 62, 0.3);
        }

        /* Panels */
        .card-panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .card-panel h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-panel h3 i {
            color: var(--amber);
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .data-table th, .data-table td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .data-table th {
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover { background: #FCFAF6; }

        .row-cell { display: flex; align-items: center; gap: 12px; }

        .row-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--amber-tint);
            color: var(--amber-deep);
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .row-title { font-weight: 600; color: var(--navy-deep); }
        .row-sub { color: var(--text-secondary); font-size: 0.75rem; margin-top: 1px; }

        .amount-cell { font-weight: 600; color: var(--navy-deep); }

        .method-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            background: var(--paper);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            text-transform: capitalize;
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            display: inline-block;
        }

        .status-pill.paid { background-color: #E1EFE6; color: #327049; }
        .status-pill.pending { background-color: #FBEBD4; color: #A9721F; }
        .status-pill.overdue { background-color: #F6E2DD; color: #A8412B; }

        .icon-btn {
            padding: 7px 9px;
            border: 1px solid var(--border-color);
            background-color: var(--paper);
            color: var(--text-secondary);
            border-radius: 6px;
            font-size: 0.78rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
        }

        .icon-btn:hover { background-color: var(--navy-deep); color: #FFF; border-color: var(--navy-deep); }
        .icon-btn.delete:hover { background-color: var(--danger-red); border-color: var(--danger-red); color: #FFF; }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .pagination-wrap { margin-top: 18px; display: flex; justify-content: flex-end; }
        .pagination-wrap nav { font-size: 0.8rem; }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(22, 33, 62, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-overlay.open { display: flex; }

        .modal-card {
            background: var(--paper);
            border-radius: 16px;
            width: 100%;
            max-width: 440px;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            box-shadow: 0 30px 70px -28px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header h3 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 1.15rem;
            color: var(--navy-deep);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-header h3 i { color: var(--amber); }

        .modal-close {
            background: none;
            border: none;
            font-size: 1rem;
            color: var(--text-secondary);
            cursor: pointer;
            line-height: 1;
        }

        .modal-body { padding: 20px 24px; }

        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--navy-deep);
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--text-primary);
            background: #FFF;
            outline: none;
            transition: border-color 0.15s ease;
        }

        .form-control:focus, .form-select:focus { border-color: var(--amber); }

        .field-error { color: var(--danger-red); font-size: 0.72rem; margin-top: 5px; }

        .form-row { display: flex; gap: 12px; }
        .form-row .form-group { flex: 1; }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px 22px;
        }

        .btn-light {
            background: #FFF;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-light:hover { background: #F0ECE2; }

        .btn-save {
            background: var(--navy-deep);
            border: none;
            color: var(--paper);
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save:hover { background: var(--navy-mid); }

        /* Responsive */
        @media (max-width: 1024px) {
            .app-container { flex-direction: column; }
            .sidebar { width: 100%; }
            .sidebar-menu { flex-direction: row; flex-wrap: wrap; }
            .top-header { flex-wrap: wrap; }
            .search-bar { width: 100%; }
            .dashboard-body { padding: 24px 20px; }
            .form-row { flex-direction: column; gap: 0; }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <i class="fa-solid fa-building-user"></i>
                <span>Dorm Portal</span>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                <a href="{{ route('admin.students.index') }}" class="menu-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate"></i> Students
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="menu-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-door-closed"></i> Rooms
                </a>
                <a href="{{ route('admin.payments.index') }}" class="menu-item {{ request()->is('admin/payments*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wallet"></i> Payments
                </a>
                <a href="/admin/maintenance" class="menu-item {{ request()->is('admin/maintenance*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wrench"></i> Maintenance
                </a>
                <a href="/admin/profile" class="menu-item {{ request()->is('admin/profile*') ? 'active' : '' }}">
                    <i class="fa-solid fa-circle-user"></i> Profile
                </a>
            </nav>
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="main-content">
            <!-- Header Bar -->
            <header class="top-header">
                <form method="GET" class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student or reference no...">
                </form>
                <div class="admin-profile-badge">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">ADMIN</span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="dashboard-body">
                <div class="welcome-banner">
                    <h1>Manage Payments</h1>
                    <p>Review student payments, update their status, and remove incorrect records.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
                @endif

                <div class="card-panel">
                    <div class="panel-header">
                        <h3><i class="fa-solid fa-file-invoice-dollar"></i> Payment Records</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    @php
                                        $statusClasses = [
                                            'paid'    => 'paid',
                                            'pending' => 'pending',
                                            'overdue' => 'overdue',
                                        ];
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="row-cell">
                                                <div class="row-avatar">{{ strtoupper(substr($payment->student->name ?? '?', 0, 1)) }}</div>
                                                <div>
                                                    <div class="row-title">{{ $payment->student->name ?? 'Unknown Student' }}</div>
                                                    <div class="row-sub">{{ $payment->reference_number ?? 'No reference' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="amount-cell">₱{{ number_format($payment->amount, 2) }}</td>
                                        <td><span class="method-pill">{{ str_replace('_', ' ', $payment->payment_method) }}</span></td>
                                        <td>{{ \Illuminate\Support\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                        <td>
                                            <span class="status-pill {{ $statusClasses[$payment->status] ?? 'pending' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="icon-btn edit" title="Edit"
                                                    onclick="openModal('editPaymentModal{{ $payment->id }}')">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline"
                                                  onsubmit="return confirm('Delete this payment record? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="icon-btn delete" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Edit Payment Modal --}}
                                    <div class="modal-overlay" id="editPaymentModal{{ $payment->id }}">
                                        <div class="modal-card">
                                            <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h3><i class="fa-solid fa-pen"></i> Edit Payment</h3>
                                                    <button type="button" class="modal-close" onclick="closeModal('editPaymentModal{{ $payment->id }}')">✕</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="form-label">Student</label>
                                                        <select name="student_id" class="form-select" required>
                                                            @foreach ($students as $student)
                                                                <option value="{{ $student->id }}" {{ $payment->student_id == $student->id ? 'selected' : '' }}>
                                                                    {{ $student->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label class="form-label">Amount</label>
                                                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ $payment->amount }}" min="0" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Payment Date</label>
                                                            <input type="date" name="payment_date" class="form-control" value="{{ \Illuminate\Support\Carbon::parse($payment->payment_date)->format('Y-m-d') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label class="form-label">Method</label>
                                                            <select name="payment_method" class="form-select">
                                                                <option value="cash" {{ $payment->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                                                                <option value="gcash" {{ $payment->payment_method === 'gcash' ? 'selected' : '' }}>GCash</option>
                                                                <option value="bank_transfer" {{ $payment->payment_method === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                                <option value="other" {{ $payment->payment_method === 'other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="paid" {{ $payment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                                <option value="pending" {{ $payment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="overdue" {{ $payment->status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Reference Number</label>
                                                        <input type="text" name="reference_number" class="form-control" value="{{ $payment->reference_number }}" maxlength="50">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Remarks</label>
                                                        <input type="text" name="remarks" class="form-control" value="{{ $payment->remarks }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn-light" onclick="closeModal('editPaymentModal{{ $payment->id }}')">Cancel</button>
                                                    <button type="submit" class="btn-save">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">No payments found. Records appear here once students submit payments.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) overlay.classList.remove('open');
            });
        });
    </script>
</body>
</html>