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
        @media print { body { padding: 0; background: #fff; } .receipt { max-width: none; border: 0; border-radius: 0; padding: 12mm; } .actions { display: none; } }
        @media (max-width: 560px) { body { padding: 12px; } .receipt { padding: 22px; } .details { grid-template-columns: 1fr; } }
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
    <div class="actions"><button type="button" onclick="window.print()">Print receipt</button></div>
</body>
</html>
