<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f6f9f7; display: flex; min-height: 100vh; color: #1f2937; }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #e5efe9;
            padding: 28px 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 12px rgba(0,0,0,0.02);
            transition: width 0.25s ease, padding 0.25s ease;
            overflow: hidden;
            white-space: nowrap;
        }
        .sidebar.collapsed { width: 76px; padding: 28px 0; }

        .sidebar .logo {
            font-size: 19px;
            font-weight: 700;
            color: #14532d;
            padding: 0 26px 24px;
            border-bottom: 1px solid #eef2ef;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.2s ease;
        }
        .sidebar.collapsed .logo-text { display: none; }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 26px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.18s ease;
        }
        .sidebar nav a:hover { background-color: #f0faf3; color: #15803d; }
        .sidebar nav a.active {
            background-color: #ecfdf3;
            color: #15803d;
            border-left: 3px solid #22c55e;
            font-weight: 600;
        }
        .sidebar.collapsed nav a .link-text { display: none; }
        .sidebar.collapsed nav a { justify-content: center; padding: 13px 0; }

        .sidebar .logout-form { margin-top: auto; padding: 0 26px; }
        .sidebar.collapsed .logout-form { padding: 0 16px; }
        .btn-logout {
            width: 100%;
            padding: 11px;
            background-color: #ffffff;
            color: #6b7280;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s ease;
            white-space: nowrap;
            overflow: hidden;
        }
        .btn-logout:hover { background-color: #fef2f2; color: #b91c1c; border-color: #fca5a5; }

        .toggle-btn {
            position: absolute;
            top: 28px;
            right: -14px;
            width: 28px;
            height: 28px;
            background-color: #22c55e;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(34, 197, 94, 0.3);
            transition: background-color 0.15s ease, transform 0.25s ease;
            z-index: 10;
        }
        .toggle-btn:hover { background-color: #15803d; }
        .sidebar.collapsed .toggle-btn { transform: rotate(180deg); }

        .sidebar-wrapper { position: relative; }

        /* Main content */
        .main { flex: 1; padding: 40px 48px; transition: margin 0.25s ease; }
        .main h1 { font-size: 24px; color: #111827; margin-bottom: 6px; font-weight: 700; }
        .main p.sub { color: #6b7280; font-size: 14px; margin-bottom: 32px; }

        /* Alerts */
        .alert-success {
            background: #ecfdf3;
            color: #15803d;
            border: 1px solid #bbf7d0;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 24px;
        }
        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 24px;
        }
        .alert-error ul { margin-left: 18px; margin-top: 4px; }

        /* Info cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 18px;
            margin-bottom: 40px;
        }
        .info-card {
            background: #ffffff;
            border: 1px solid #e5efe9;
            border-left: 4px solid #22c55e;
            border-radius: 10px;
            padding: 20px 22px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(34, 197, 94, 0.08);
        }
        .info-card .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #9ca3af;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .info-card .value { font-size: 17px; font-weight: 700; color: #14532d; }

        /* Section title */
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #14532d;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title::before {
            content: "";
            width: 4px;
            height: 16px;
            background-color: #22c55e;
            border-radius: 2px;
        }

        /* Layout: form + history */
        .payments-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 24px;
            align-items: start;
            margin-bottom: 40px;
        }
        @media (max-width: 900px) {
            .payments-layout { grid-template-columns: 1fr; }
        }

        /* Form card */
        .form-card {
            background: #ffffff;
            border: 1px solid #e5efe9;
            border-radius: 12px;
            padding: 24px;
        }
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: all 0.15s ease;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }
        .form-group textarea { resize: vertical; min-height: 70px; }
        .form-hint { font-size: 11.5px; color: #9ca3af; margin-top: 5px; }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #22c55e;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.15s ease;
            margin-top: 6px;
        }
        .btn-submit:hover { background-color: #15803d; }

        /* History card */
        .history-card {
            background: #ffffff;
            border: 1px solid #e5efe9;
            border-radius: 12px;
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: #f9fbfa; }
        th {
            text-align: left;
            padding: 12px 18px;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #9ca3af;
            font-weight: 700;
            border-bottom: 1px solid #eef2ef;
        }
        td {
            padding: 14px 18px;
            font-size: 13px;
            color: #374151;
            border-bottom: 1px solid #eef2ef;
        }
        tr:last-child td { border-bottom: none; }
        .amount-cell { font-weight: 700; color: #14532d; }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: capitalize;
        }
        .badge-pending { background-color: #fef9c3; color: #854d0e; }
        .badge-verified { background-color: #ecfdf3; color: #15803d; }
        .badge-rejected { background-color: #fef2f2; color: #b91c1c; }

        .empty-row td { text-align: center; padding: 40px 18px; color: #9ca3af; font-size: 13px; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <div class="sidebar" id="sidebar">
            <button class="toggle-btn" id="toggleBtn" title="Toggle sidebar">◀</button>
            <div class="logo">
                🏢 <span class="logo-text">Dorm Portal</span>
            </div>
            <nav>
                <a href="/dashboard">🏠 <span class="link-text">Dashboard</span></a>
                <a href="/room">🛏️ <span class="link-text">My Room</span></a>
                <a href="/payments" class="active">💳 <span class="link-text">Payments</span></a>
                <a href="/maintenance">🔧 <span class="link-text">Maintenance</span></a>
                <a href="/profile">👤 <span class="link-text">Profile</span></a>
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
        <h1>Payments 💳</h1>
        <p class="sub">Submit a payment and track your dormitory dues.</p>

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

        <div class="info-grid">
            <div class="info-card">
                <div class="label">Monthly Rate</div>
                <div class="value">₱{{ number_format($monthlyRate, 2) }}</div>
            </div>
            <div class="info-card">
                <div class="label">Total Verified Paid</div>
                <div class="value">₱{{ number_format($totalPaid, 2) }}</div>
            </div>
            <div class="info-card">
                <div class="label">Pending Submissions</div>
                <div class="value">{{ $pendingCount }}</div>
            </div>
        </div>

        <div class="payments-layout">
            <div>
                <div class="section-title">Submit a Payment</div>
                <div class="form-card">
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
                                    <td><span class="badge badge-{{ $payment->status }}">{{ $payment->status }}</span></td>
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

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('collapsed'));
    </script>

</body>
</html>