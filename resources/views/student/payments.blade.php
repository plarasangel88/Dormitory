<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
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
            margin-bottom: 26px;
        }
        .alert-error {
            background: #FDF0EF;
            color: #9B3B37;
            border: 1px solid #F3C9C6;
            border-left: 4px solid #D4675F;
            padding: 13px 18px;
            border-radius: 9px;
            font-size: 13.5px;
            margin-bottom: 26px;
        }
        .alert-error ul { margin-left: 18px; margin-top: 5px; }

        /* ---------- Info cards ---------- */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 44px;
        }
        .info-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-left: 4px solid var(--amber);
            border-radius: 10px;
            padding: 20px 22px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(22, 33, 62, 0.07);
        }
        .info-card .label {
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--slate);
            margin-bottom: 8px;
            font-weight: 600;
        }
        .info-card .value {
            font-family: 'Fraunces', serif;
            font-size: 18px;
            font-weight: 500;
            color: var(--navy-deep);
        }

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

        /* ---------- Layout: form + history ---------- */
        .payments-layout {
            display: grid;
            grid-template-columns: 370px 1fr;
            gap: 24px;
            align-items: start;
            margin-bottom: 20px;
        }

        /* ---------- Form card ---------- */
        .form-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 26px;
        }
        .form-group { margin-bottom: 17px; }
        .form-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--navy-deep);
            margin-bottom: 7px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
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
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(240, 168, 87, 0.18);
        }
        .form-group input[readonly] {
            background-color: #F7F4ED;
            color: var(--slate);
            cursor: not-allowed;
        }
        .form-group textarea { resize: vertical; min-height: 74px; }
        .form-hint {
            font-size: 11.5px;
            color: var(--slate);
            margin-top: 6px;
            line-height: 1.5;
        }
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
        .btn-submit:hover { background-color: var(--navy-soft); }

        /* ---------- History card ---------- */
        .history-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: #F7F4ED; }
        th {
            text-align: left;
            padding: 13px 18px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--slate);
            font-weight: 700;
            border-bottom: 1px solid var(--line);
        }
        td {
            padding: 15px 18px;
            font-size: 13px;
            color: var(--ink);
            border-bottom: 1px solid var(--line);
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background-color: #FCFAF6; }
        .amount-cell {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 14.5px;
            color: var(--navy-deep);
        }
        .ref-cell { color: var(--slate); }

        .badge {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .badge-pending  { background-color: var(--amber-tint); color: #8A5A17; }
        .badge-verified { background-color: #E4EDE4; color: #35603B; }
        .badge-rejected { background-color: #FBE7E5; color: #9B3B37; }

        .empty-row td {
            text-align: center;
            padding: 46px 18px;
            color: var(--slate);
            font-size: 13px;
        }
        .empty-row tr:hover { background: none; }

        :focus-visible {
            outline: 2px solid var(--amber);
            outline-offset: 2px;
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 1000px) {
            .payments-layout { grid-template-columns: 1fr; }
        }
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
            .history-card { overflow-x: auto; }
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
                <a href="/dashboard">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 10.5 12 3l9 7.5"></path>
                            <path d="M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"></path>
                        </svg>
                    </span>
                    <span class="link-text">Dashboard</span>
                </a>
                <a href="/room">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 18v-6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6"></path>
                            <path d="M2 18h20"></path>
                            <path d="M6 10V6.5A1.5 1.5 0 0 1 7.5 5h4A1.5 1.5 0 0 1 13 6.5V10"></path>
                        </svg>
                    </span>
                    <span class="link-text">My Room</span>
                </a>
                <a href="/payments" class="active">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <path d="M2 10h20"></path>
                        </svg>
                    </span>
                    <span class="link-text">Payments</span>
                </a>
                <a href="/maintenance">
                    <span class="link-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.4-3.4a5 5 0 0 1-6.7 6.7l-6.9 6.9a2.1 2.1 0 0 1-3-3l6.9-6.9a5 5 0 0 1 6.7-6.7z"></path>
                        </svg>
                    </span>
                    <span class="link-text">Maintenance</span>
                </a>
                <a href="/profile">
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
        <div class="page-head">
            <div class="eyebrow-mark"></div>
            <h1>Payments</h1>
            <p class="sub">Hi {{ auth()->user()->name }}, submit a payment and track your dormitory dues.</p>
        </div>

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
                <div class="label">Student</div>
                <div class="value">{{ auth()->user()->name }}</div>
            </div>
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
                            <label for="student_name">Student Name</label>
                            <input type="text" id="student_name" value="{{ auth()->user()->name }}" readonly>
                            <div class="form-hint">Auto-filled from your account — this payment will be recorded under your name.</div>
                        </div>

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
                                    <td class="ref-cell">{{ $payment->reference_number }}</td>
                                    <td><span class="badge badge-{{ $payment->status }}">{{ $payment->status }}</span></td>
                                </tr>
                            @empty
                                <tr class="empty-row">
                                    <td colspan="5">No payments yet. Submit one using the form to start your record.</td>
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