<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt {{ $transaction->reference_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px; background: #FBF8F2; color: #16213E; font-family: Inter, Arial, sans-serif; }
        .receipt { max-width: 760px; margin: 0 auto; padding: 36px; background: #fff; border: 1px solid #E3DFD5; border-radius: 18px; }
        .receipt-head { display: flex; justify-content: space-between; gap: 20px; align-items: flex-start; border-bottom: 2px solid #F0A857; padding-bottom: 22px; }
        h1 { margin: 0 0 6px; font-size: 28px; } p { margin: 5px 0; color: #68758E; }
        .status { background: #E1EFE6; color: #28724B; padding: 8px 12px; border-radius: 999px; font-weight: 700; text-transform: uppercase; font-size: 12px; }
        .details { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 22px 0; }
        .label { color: #8993A8; font-size: 12px; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 5px; }
        .value { font-weight: 600; overflow-wrap: anywhere; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { padding: 13px 10px; border-bottom: 1px solid #E3DFD5; text-align: left; }
        th { color: #68758E; font-size: 12px; text-transform: uppercase; }
        td.amount, th.amount { text-align: right; }
        tfoot td { font-weight: 700; font-size: 18px; border-bottom: 0; }
        .actions { max-width: 760px; margin: 18px auto 0; display: flex; justify-content: flex-end; }
        button { border: 0; border-radius: 9px; background: #16213E; color: #fff; padding: 12px 18px; font-weight: 700; cursor: pointer; }
        .actions { justify-content: space-between; gap: 12px; }
        .back-button { display: inline-flex; align-items: center; gap: 8px; min-height: 40px; padding: 10px 16px; border: 1px solid #d8deea; border-radius: 9px; background: #fff; color: #16213E; font: 700 13px Inter, Arial, sans-serif; text-decoration: none; cursor: pointer; }
        .back-button:hover { background: #f5f7fb; }
        body { padding: 24px; font-size: 13px; line-height: 1.55; }
        .receipt { padding: 28px; border-color: #e8eaf0; border-radius: 16px; box-shadow: 0 10px 28px #172b4d0d; }
        h1 { font-size: 26px; letter-spacing: -.02em; }
        p, .value { font-size: 13px; }
        .details { gap: 16px 20px; padding: 18px 0; }
        .label { font-size: 12px; }
        th { font-size: 12px; letter-spacing: .05em; }
        td { font-size: 13px; }
        button { min-height: 40px; padding: 10px 16px; font-size: 13px; }
        @media print { body { padding: 0; background: #fff; } .receipt { max-width: none; border: 0; border-radius: 0; padding: 12mm; } .actions { display: none; } }
        @media (max-width: 560px) { body { padding: 16px; } .receipt { padding: 24px 20px; } .receipt-head { gap: 12px; } h1 { font-size: 25px; } .details { grid-template-columns: 1fr; gap: 16px; } th, td { padding: 12px 8px; font-size: 12px; } }
    </style>
</head>
<body>
    <main class="receipt">
        <header class="receipt-head">
            <div>
                <h1>Dorm Portal</h1>
                <p>Official payment receipt</p>
            </div>
            <span class="status">Verified</span>
        </header>

        <section class="details">
            <div><div class="label">Student</div><div class="value">{{ auth()->user()->name }}</div></div>
            <div><div class="label">Transaction reference</div><div class="value">{{ $transaction->reference_number }}</div></div>
            <div><div class="label">Payment method</div><div class="value">{{ $transaction->method }}</div></div>
            <div><div class="label">Verified date</div><div class="value">{{ ($transaction->payment_date ?? $transaction->updated_at)->format('M d, Y') }}</div></div>
            @if ($transaction->provider_reference)
                <div><div class="label">Provider reference</div><div class="value">{{ $transaction->provider_reference }}</div></div>
            @endif
        </section>

        <table>
            <thead><tr><th>Bill item</th><th>Billing month</th><th class="amount">Amount</th></tr></thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ ucfirst($payment->applies_to ?? 'Payment') }}</td>
                        <td>{{ $payment->bill?->billing_month?->format('F Y') ?? '—' }}</td>
                        <td class="amount">₱{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot><tr><td colspan="2">Total paid</td><td class="amount">₱{{ number_format($total, 2) }}</td></tr></tfoot>
        </table>
        <p style="margin-top:22px">This receipt confirms payment recorded and verified by the dormitory administrator.</p>
    </main>
    <div class="actions">
        <a class="back-button" href="{{ route('payments') }}" aria-label="Back to payments">← Back to Payments</a>
        <button type="button" onclick="window.print()">Print receipt</button>
    </div>
</body>
</html>
