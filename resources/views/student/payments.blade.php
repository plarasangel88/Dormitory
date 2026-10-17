<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments - Dorm Portal</title>
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

        /* Dashboard Container */
        .dashboard-body {
            padding: 32px;
            overflow-y: auto;
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
            margin-bottom: 24px;
            font-size: 0.92rem;
        }

        /* ---------- Alerts ---------- */
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

        /* Metrics grid — identical to Student Dashboard */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

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

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .metric-icon.blue { background-color: #EAEEF7; color: var(--primary-blue); }
        .metric-icon.orange { background-color: #FBEBD4; color: var(--warning-orange); }
        .metric-icon.green { background-color: #E1EFE6; color: var(--success-green); }
        .metric-icon.purple { background-color: #EBE7F4; color: var(--purple-accent); }

        .metric-title {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--text-secondary);
            letter-spacing: 0.6px;
        }

        .metric-value {
            font-family: 'Fraunces', serif;
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-top: 4px;
        }

        /* Card panel — identical to Student Dashboard's Quick Actions panel */
        .card-panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(22, 33, 62, 0.04);
        }

        .card-panel h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .card-panel h3 i { color: var(--amber); }

        /* ---------- Layout: form + history ---------- */
        .payments-layout {
            display: grid;
            grid-template-columns: 370px 1fr;
            gap: 20px;
            align-items: start;
        }

        /* ---------- Form ---------- */
        .form-group { margin-bottom: 17px; }
        .form-group:last-of-type { margin-bottom: 0; }
        .form-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 7px;
        }
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
        .form-group input[readonly] {
            background-color: var(--paper);
            color: var(--text-secondary);
            cursor: not-allowed;
        }
        .form-group textarea { resize: vertical; min-height: 74px; }
        .form-hint {
            font-size: 11.5px;
            color: var(--text-secondary);
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
        .btn-submit:hover { background-color: var(--navy-mid); }

        /* ---------- History table ---------- */
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
        td {
            padding: 15px 18px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-color);
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background-color: var(--paper); }
        .amount-cell {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 14.5px;
            color: var(--navy-deep);
        }
        .ref-cell { color: var(--text-secondary); }
        [hidden] { display: none !important; }
        .history-more-wrap { padding: 0 18px 18px; text-align: center; }
        .history-more-button { padding: 9px 14px; border: 1px solid var(--border-color); border-radius: 8px; background: #fff; color: var(--navy-deep); font: 600 12px 'Inter', sans-serif; cursor: pointer; }
        .history-more-button:hover { background: var(--paper); border-color: var(--amber); }

        .badge {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .badge-pending  { background-color: #FBEBD4; color: #8A5A17; }
        .badge-verified { background-color: #E1EFE6; color: #2F6A45; }
        .badge-rejected { background-color: #FBE7E5; color: #9B3B37; }

        .empty-row td {
            text-align: center;
            padding: 46px 18px;
            color: var(--text-secondary);
            font-size: 13px;
        }
        .empty-row tr:hover { background: none; }

        @media (max-width: 1080px) {
            .payments-layout { grid-template-columns: 1fr; }
        }
        @media (max-width: 860px) {
            .app-container { flex-direction: column; }
            .sidebar {
                width: 100%;
                flex-direction: row;
                align-items: center;
                padding: 16px 20px;
                overflow-x: auto;
            }
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
            @include('student.partials.page-header', ['title' => 'Payments', 'subtitle' => 'Review your payment status and dormitory dues.'])

            <!-- Dashboard Content -->
            <div class="dashboard-body">
                <div class="welcome-banner">
                    <div class="welcome-content">
                        <div class="eyebrow">Your Dormitory, Your Space</div>
                        <h1>Payments</h1>
                        <p>Hi {{ auth()->user()->name }}, submit a payment and track your dormitory dues.</p>
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

                <!-- Summary metrics -->
                <section class="metrics-grid">
                    <div class="metric-card">
                        <div class="metric-icon blue"><i class="fa-solid fa-user"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">STUDENT</span>
                            <div class="metric-value">{{ auth()->user()->name }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon orange"><i class="fa-solid fa-peso-sign"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">MONTHLY RATE</span>
                            <div class="metric-value">₱{{ number_format($monthlyRate, 2) }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon green"><i class="fa-solid fa-circle-check"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">TOTAL VERIFIED PAID</span>
                            <div class="metric-value">₱{{ number_format($totalPaid, 2) }}</div>
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-icon purple"><i class="fa-solid fa-hourglass-half"></i></div>
                        <div class="metric-info">
                            <span class="metric-title">PENDING SUBMISSIONS</span>
                            <div class="metric-value">{{ $pendingCount }}</div>
                        </div>
                    </div>
                </section>

                <section class="card-panel" style="margin-bottom:20px">
                    <h3><i class="fa-solid fa-file-invoice-dollar"></i> My Bills</h3>
                    <div style="overflow-x:auto">
                        <table>
                            <thead>
                                <tr><th>Billing Month</th><th>Due Date</th><th>Rent</th><th>Electricity</th><th>Water</th><th>Total</th><th>Balance</th></tr>
                            </thead>
                            <tbody>
                                @forelse($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->billing_month->format('F Y') }}</td>
                                        <td>{{ $bill->due_date?->format('M d, Y') ?? '—' }}</td>
                                        <td>₱{{ number_format($bill->rent, 2) }} <small>(₱{{ number_format($bill->balanceFor('rent'), 2) }} due)</small></td>
                                        <td>₱{{ number_format($bill->electricity, 2) }} <small>(₱{{ number_format($bill->balanceFor('electricity'), 2) }} due)</small></td>
                                        <td>₱{{ number_format($bill->water, 2) }} <small>(₱{{ number_format($bill->balanceFor('water'), 2) }} due)</small></td>
                                        <td>₱{{ number_format($bill->total, 2) }}</td>
                                        <td><strong>{{ $bill->balance <= 0 ? 'Settled' : '₱'.number_format($bill->balance, 2) }}</strong></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7">No bills have been posted for your account yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="payments-layout">
                    <div class="card-panel">
                        <h3><i class="fa-solid fa-money-bill-transfer"></i> Pay All Outstanding Dues</h3>
                        <form action="{{ route('payments.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="student_name">Student Name</label>
                                <input type="text" id="student_name" value="{{ auth()->user()->name }}" readonly>
                                <div class="form-hint">Auto-filled from your account — this payment will be recorded under your name.</div>
                            </div>

                            <div class="form-group">
                                <label for="amount">Total dues to pay (&#8369;)</label>
                                <input type="text" id="amount" value="&#8369;{{ number_format($payableTotal, 2) }}" readonly>
                                <div class="form-hint">This combines every unpaid bill item. Amounts already submitted and awaiting review are excluded.</div>
                            </div>

                            <div class="form-group">
                                <label for="method">Payment Method</label>
                                <select id="method" name="method" required>
                                    <option value="" disabled {{ old('method') ? '' : 'selected' }}>Select method</option>
                                    <option value="GCash" {{ old('method') == 'GCash' ? 'selected' : '' }}>GCash</option>
                                    <option value="Cash" {{ old('method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                </select>
                            </div>

                            <div class="form-group" id="gcashQrPanel" style="display:none">
                                <label>Pay using the dormitory GCash QR</label>
                                @if ($gcashQrUrl)
                                    <img src="{{ $gcashQrUrl }}" alt="Dormitory GCash QR code" style="display:block;max-width:240px;width:100%;height:auto;margin:12px auto;border:1px solid #E3DFD5;border-radius:12px;padding:10px;background:#fff">
                                    <div class="form-hint">Scan this code in GCash and pay the amount shown above. The portal will create a transaction reference for your submission. It stays pending until an admin verifies the transfer in GCash.</div>
                                @else
                                    <div class="form-hint">The administrator has not uploaded a GCash QR code yet. Select Cash or contact the dormitory office.</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes (optional)</label>
                                <textarea id="notes" name="notes" placeholder="e.g. Payment for September rent">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit" class="btn-submit" {{ $payableTotal <= 0 ? 'disabled' : '' }}>{{ $payableTotal > 0 ? 'Submit Payment for Verification' : 'No Dues Available to Pay' }}</button>
                        </form>
                    </div>

                    <div class="card-panel history-card">
                        <h3><i class="fa-solid fa-clock-rotate-left"></i> Payment History</h3>
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
                                @forelse($transactions as $transactionIndex => $payment)
                                    <tr data-transaction-index="{{ $transactionIndex }}" @if($transactionIndex >= 6) hidden @endif>
                                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                        <td class="amount-cell">₱{{ number_format($payment->transaction_total, 2) }}</td>
                                        <td>{{ $payment->method }}</td>
                                        <td class="ref-cell">{{ $payment->reference_number }}</td>
                                        <td>
                                            <span class="badge badge-{{ $payment->transaction_status }}">{{ $payment->transaction_status }}</span>
                                            @if ($payment->provider_reference)<div class="form-hint">Provider ref: {{ $payment->provider_reference }}</div>@endif
                                            @if ($payment->transaction_status === 'verified')
                                                <a href="{{ route('payments.receipt', ['reference' => $payment->reference_number]) }}" target="_blank" rel="noopener">Print receipt</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-row">
                                        <td colspan="5">No payments yet. Submit one using the form to start your record.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($transactions->count() > 6)
                            <div class="history-more-wrap">
                                <button type="button" class="history-more-button" id="historyMoreButton">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                    Show older transactions ({{ $transactions->count() - 6 }} more)
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include('student.partials.announcement-bell-script')
    <script>
        (() => {
            const method = document.getElementById('method');
            const qrPanel = document.getElementById('gcashQrPanel');
            const updatePaymentOptions = () => {
                const selected = method.value;
                qrPanel.style.display = selected === 'GCash' ? 'block' : 'none';
            };
            method.addEventListener('change', updatePaymentOptions);
            updatePaymentOptions();

            const moreButton = document.getElementById('historyMoreButton');
            if (moreButton) {
                const rows = [...document.querySelectorAll('[data-transaction-index]')];
                const pageSize = 6;
                let visibleCount = Math.min(pageSize, rows.length);

                moreButton.addEventListener('click', () => {
                    if (visibleCount >= rows.length) {
                        visibleCount = Math.min(pageSize, rows.length);
                    } else {
                        visibleCount = Math.min(visibleCount + pageSize, rows.length);
                    }

                    rows.forEach((row, index) => { row.hidden = index >= visibleCount; });

                    if (visibleCount >= rows.length) {
                        moreButton.innerHTML = '<i class="fa-solid fa-chevron-up"></i> Show fewer transactions';
                    } else {
                        moreButton.innerHTML = '<i class="fa-solid fa-clock-rotate-left"></i> Show older transactions (' + (rows.length - visibleCount) + ' more)';
                    }
                });
            }
        })();
    </script>
</body>
</html>
