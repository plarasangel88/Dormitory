<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Dorm Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f7f5f0;color:#172b4d;font-family:Inter,Arial,sans-serif}.wrap{max-width:1100px;margin:0 auto;padding:30px}.header{display:flex;align-items:center;gap:14px;margin-bottom:22px}.back,.btn{border:0;border-radius:9px;background:#172b4d;color:#fff;padding:11px 15px;text-decoration:none;font-weight:600;cursor:pointer}.heading h1{font-size:24px;margin:0 0 4px}.heading p{margin:0;color:#78869c;font-size:14px}.banner{background:#172b4d;color:#fff;border-radius:18px;padding:26px 30px;margin:18px 0 22px}.banner h2{font-size:24px;margin:0 0 8px}.banner p{margin:0;color:#d8e0ee}.filters,.card{background:#fff;border:1px solid #e1e6ee;border-radius:14px;padding:18px;margin-bottom:16px}.filters{display:flex;align-items:end;gap:12px;flex-wrap:wrap}.field{display:grid;gap:6px;color:#64748b;font-size:12px;font-weight:600}.field input{height:40px;border:1px solid #d9e0ea;border-radius:8px;padding:0 10px;font:inherit;color:#172b4d}.grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}.card h3{margin:0 0 7px;font-size:16px}.card p{color:#78869c;font-size:13px;line-height:1.5;margin:0 0 14px}.card a{display:inline-block;background:#172b4d;color:#fff;border-radius:8px;padding:9px 12px;text-decoration:none;font-size:13px;font-weight:600}@media(max-width:700px){.wrap{padding:18px}.grid{grid-template-columns:1fr}.banner{padding:22px}}
        .filters, .card { padding: 14px; margin-bottom: 12px; }
        .filters { gap: 10px; }
        .grid { gap: 12px; }
        .card p { margin-bottom: 12px; }
    </style>
</head>
<body>
    <main class="wrap">
        <header class="header">
            <a class="back" href="{{ route('admin.dashboard') }}" aria-label="Back to dashboard"><i class="fa-solid fa-arrow-left"></i></a>
            <div class="heading"><h1>Reports</h1><p>Download operational records for a selected date range.</p></div>
        </header>
        <section class="banner"><h2>Admin Reports</h2><p>Export payment activity, maintenance requests, and payment review history.</p></section>
        <form class="filters" method="GET" action="{{ route('admin.reports.index') }}">
            <label class="field">From date<input type="date" name="from" value="{{ $from }}" required></label>
            <label class="field">To date<input type="date" name="to" value="{{ $to }}" required></label>
            <button class="btn" type="submit">Update Range</button>
        </form>
        @if ($errors->any())
            <div class="card" role="alert" style="color:#9b3b37">{{ $errors->first() }}</div>
        @endif
        <section class="grid">
            @foreach ([
                ['payments', 'Payment Records', 'Bill allocations and payment statuses submitted during this period.', 'fa-wallet'],
                ['payment-audit', 'Payment Audit Trail', 'Who recorded, changed, verified, or removed each payment entry.', 'fa-clipboard-check'],
                ['maintenance', 'Maintenance Requests', 'Request status, assigned administrator, deadline, and resolution dates.', 'fa-screwdriver-wrench'],
            ] as [$type, $title, $description, $icon])
                <article class="card">
                    <h3><i class="fa-solid {{ $icon }}"></i> {{ $title }}</h3>
                    <p>{{ $description }}</p>
                    <a href="{{ route('admin.reports.export', ['type' => $type, 'from' => $from, 'to' => $to]) }}"><i class="fa-solid fa-download"></i> Download CSV</a>
                </article>
            @endforeach
        </section>
    </main>
</body>
</html>
