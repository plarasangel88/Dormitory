<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments - Dormitory Management System</title>
    <style>
        :root {
            --green-900: #0f3d24;
            --green-700: #166534;
            --green-600: #15803d;
            --green-500: #16a34a;
            --green-100: #dcfce7;
            --green-50: #f0fdf4;
            --gray-900: #111827;
            --gray-700: #374151;
            --gray-500: #6b7280;
            --gray-400: #9ca3af;
            --gray-200: #e5e7eb;
            --gray-100: #f3f4f6;
            --border: #e2e8e4;
            --amber-50: #fffbeb;
            --amber-700: #b45309;
            --amber-200: #fde68a;
            --red-50: #fef2f2;
            --red-700: #b91c1c;
            --red-200: #fecaca;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f7f9f8; display: flex; min-height: 100vh; color: var(--gray-900); }

        /* Sidebar (same as dashboard) */
        .sidebar {
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            transition: width 0.2s ease;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }
        .sidebar.collapsed { width: 80px; }
        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px 26px;
            border-bottom: 1px solid var(--border);
        }
        .brand-mark {
            width: 36px;
            height: 36px;
            background-color: var(--green-700);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            flex-shrink: 0;
        }
        .brand-text { font-size: 15px; font-weight: 700; color: var(--green-900); line-height: 1.2; }
        .brand-text small { display: block; font-size: 11px; font-weight: 500; color: var(--gray-400); margin-top: 1px; }
        .sidebar.collapsed .brand-text { display: none; }
        .nav-section { padding: 20px 16px; flex: 1; }
        .nav-label {
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;
            color: var(--gray-400); padding: 0 10px; margin-bottom: 8px;
        }
        .sidebar.collapsed .nav-label { display: none; }
        .sidebar nav a {
            display: flex; align-items: center; gap: 12px; padding: 11px 10px; margin-bottom: 2px;
            color: var(--gray-500); text-decoration: none; font-size: 13.5px; font-weight: 500;
            border-radius: 8px; transition: all 0.15s ease;
        }
        .sidebar nav a .nav-icon { width: 20px; text-align: center; flex-shrink: 0; font-size: 15px; }
        .sidebar nav a:hover { background-color: var(--green-50); color: var(--green-700); }
        .sidebar nav a.active { background-color: var(--green-700); color: #ffffff; font-weight: 600; }
        .sidebar.collapsed nav a { justify-content: center; padding: 11px 0; }
        .sidebar.collapsed nav a .link-text { display: none; }
        .sidebar-footer { padding: 16px; border-top: 1px solid var(--border); }
        .sidebar.collapsed .sidebar-footer { padding: 16px 10px; }
        .btn-logout {
            width: 100%; padding: 10px; background-color: #ffffff; color: var(--gray-500);
            border: 1px solid var(--gray-200); border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: all 0.15s ease; white-space: nowrap; overflow: hidden;
        }
        .btn-logout:hover { background-color: #fef2f2; color: #b91c1c; border-color: #fecaca; }
        .toggle-btn {
            position: absolute; top: 24px; right: -13px; width: 26px; height: 26px;
            background-color: #ffffff; color: var(--green-700); border: 1px solid var(--border);
            border-radius: 50%; cursor: pointer; font-size: 11px; display: flex; align-items: center;
            justify-content: center; box-shadow: 0 1px 4px rgba(0,0,0,0.08); transition: transform 0.2s ease; z-index: 10;
        }
        .sidebar.collapsed .toggle-btn { transform: rotate(180deg); }

        /* Main column */
        .content-column { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .topbar {
            background-color: #ffffff; border-bottom: 1px solid var(--border); padding: 18px 40px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-title { font-size: 16px; font-weight: 700; color: var(--gray-900); }
        .topbar-title span { color: var(--gray-400); font-weight: 500; font-size: 13px; display: block; margin-top: 2px; }
        .topbar-user { display: flex; align-items: center; gap: 12px; }
        .topbar-avatar {
            width: 38px; height: 38px; border-radius: 50%; background-color: var(--green-700);
            color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700;
        }
        .topbar-user-name { font-size: 13.5px; font-weight: 600; color: var(--gray-900); }
        .topbar-user-role { font-size: 12px; color: var(--gray-400); text-transform: capitalize; }

        .main { flex: 1; padding: 36px 40px; }

        .alert-success {
            background: var(--green-50); color: var(--green-700); padding: 12px 18px; border-radius: 8px;
            font-size: 13px; margin-bottom: 24px; border: 1px solid var(--green-100);
        }
        .alert-error {
            background: var(--red-50); color: var(--red-700); padding: 12px 18px; border-radius: 8px;
            font-size: 13px; margin-bottom: 24px; border: 1px solid var(--red-200);
        }
        .alert-error ul { margin-left: 18px; margin-top: 4px; }

        /* Summary cards */
        .summary-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 36px;
        }
        .summary-card { background: #ffffff; border: 1px solid var(--border); border-radius: 10px; padding: 20px 22px; }
        .summary-card .label {
            font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gray-400);
            margin-bottom: 10px; font-weight: 700;
        }
        .summary-card .value { font-size: 20px; font-weight: 700; color: var(--gray-900); }
        .summary-card .value.accent { color: var(--green-700); }
        .summary-card .value.warn { color: var(--amber-700); }

        .section-title {
            font-size: 14px; font-weight: 700; color: var(--gray-900); margin-bottom: 16px;
            padding-bottom: 10px; border-bottom: 1px solid var(--border);
        }

        /* Layout: form + history side by side */
        .payments-layout {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 28px;
            align-items: start;
        }
        @media (max-width: 900px) {
            .payments-layout { grid-template-columns: 1fr; }
        }

        /* Payment form */
        .payment-form-card { background: #ffffff; border: 1px solid var(--border); border-radius: 10px; padding: 24px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 12.5px; font-weight: 600; color: var(--gray-700); margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 10px 12px; border: 1.5px solid var(--gray-200); border-radius: 7px;
            font-size: 13.5px; outline: none; font-family: inherit; transition: all 0.15s ease;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: var(--green-500); box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.1);
        }
        .form-group textarea { resize: vertical; min-height: 70px; }
        .form-hint { font-size: 11.5px; color: var(--gray-400); margin-top: 5px; }
        .btn-submit {
            width: 100%; padding: 12px; background-color: var(--green-700); color: #ffffff; border: none;
            border-radius: 8px; font-size: 13.5px; font-weight: 700; cursor: pointer; transition: background-color 0.15s ease; margin-top: 6px;
        }
        .btn-submit:hover { background-color: var(--green-900); }

        /* Payment history table */
        .history-card { background: #ffffff; border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: var(--gray-100); }
        th {
            text-align: left; padding: 12px 18px; font-size: 11.5px; text-transform: uppercase;
            letter-spacing: 0.04em; color: var(--gray-500); font-weight: 700; border-bottom: 1px solid var(--border);
        }
        td { padding: 14px 18px; font-size: 13px; color: var(--gray-700); border-bottom: 1px solid var(--border); }
        tr:last-child td { border-bottom: none; }
        .amount-cell { font-weight: 700; color: var(--gray-900); }

        .badge {
            display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11px;
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em;
        }
        .badge-pending { background-color: var(--amber-50); color: var(--amber-700); }
        .badge-verified { background-color: var(--green-50); color: var(--green-700); }
        .badge-rejected { background-color: var(--red-50); color: var(--red-700); }

        .empty-row td {
            text-align: center; padding: 40px 18px; color: var(--gray-400); font-size: 13px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="toggle-btn" id="toggleBtn" title="Toggle sidebar">◀</button>
        <div class="brand">
            <div class="brand-mark">DP</div>
            <div class="brand-text">Dorm Portal<small>Student Panel</small></div>
        </div>
        <div class="nav-section">
            <div class="nav-label">Menu</div>
            <nav>
                <a href="/dashboard"><span class="nav-icon">▦</span><span class="link-text">Dashboard</span></a>
                <a href="/room"><span class="nav-icon">▤</span><span class="link-text">My Room</span></a>
                <a href="/payments" class="active"><span class="nav-icon">▥</span><span class="link-text">Payments</span></a>
                <a href="/maintenance"><span class="nav-icon">▧</span><span class="link-text">Maintenance</span></a>
                <a href="/profile"><span class="nav-icon">▨</span><span class="link-text">Profile</span></a>
            </nav>
        </div>
        <div class="sidebar-footer">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </div>

    <!-- Content column -->
    <div class="content-column">
        <div class="topbar">
            <div class="topbar-title">
                Payments
                <span>Submit and track your dormitory payments</span>
            </div>
            <div class="topbar-user">
                <div style="text-align: right;">
                    <div class="topbar-user-name">{{ auth()->user()->name }}</div>
                    <div class="topbar-user-role">{{ auth()->user()->role }}</div>
                </div>
                <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            </div>
        </div>

        <div class="main">

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-error">
                    <strong>Please fix the following:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Summary -->
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="label">Monthly Rate</div>
                    <div class="value">₱{{ number_format($monthlyRate, 2) }}</div>
                </div>
                <div class="summary-card">
                    <div class="label">Total Verified Paid</div>
                    <div class="value accent">₱{{ number_format($totalPaid, 2) }}</div>
                </div>
                <div class="summary-card">
                    <div class="label">Pending Submissions</div>
                    <div class="value warn">{{ $pendingCount }}</div>
                </div>
            </div>

            <div class="payments-layout">

                <!-- Payment Form -->
                <div>
                    <div class="section-title">Submit a Payment</div>
                    <div class="payment-form-card">
                        <form action="{{ route('payments.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="amount">Amount (₱)</label>
                                <input type="number" id="amount" name="amount" step="0.01" min="1" placeholder="e.g. 3500.00" value="{{ old('amount') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="method">Payment Method</label>
                                <select id="method" name="method" required>
                                    <option value="" disabled {{ old('method') ? '' : 'selected' }}>Select method</option>
                                    <option value="GCash" {{ old('method') == 'GCash' ? 'selected' : '' }}>GCash</option>
                                    <option value="Bank Transfer" {{ old('method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="Cash" {{ old('method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="reference_number">Reference Number</label>
                                <input type="text" id="reference_number" name="reference_number" placeholder="e.g. GC1234567890" value="{{ old('reference_number') }}" required>
                                <div class="form-hint">Found in your GCash/bank transaction receipt.</div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes (optional)</label>
                                <textarea id="notes" name="notes" placeholder="e.g. Payment for September rent">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit" class="btn-submit">Submit Payment</button>
                        </form>
                    </div>
                </div>

                <!-- Payment History -->
                <div>
                    <div class="section-title">Payment History</div>
                    <div class="history-card">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Reference No.</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                        <td class="amount-cell">₱{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ $payment->method }}</td>
                                        <td>{{ $payment->reference_number }}</td>
                                        <td>
                                            <span class="badge badge-{{ $payment->status }}">
                                                {{ $payment->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-row">
                                        <td colspan="5">No payments submitted yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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