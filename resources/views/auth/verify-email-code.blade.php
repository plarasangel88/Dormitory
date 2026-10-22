<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Dorm Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;background:#16213E;color:#2A2620;font-family:Inter,sans-serif;padding:24px}.card{width:min(100%,440px);background:#FBF8F2;border-radius:16px;padding:38px;box-shadow:0 20px 60px #101a3355}.brand{color:#A9721F;font-weight:700;margin-bottom:26px}.brand span{color:#16213E}h1{font:500 30px Fraunces,serif;margin:0 0 8px}p{color:#8993A8;line-height:1.6;margin:0 0 24px}label{display:block;font-size:13px;font-weight:600;margin:0 0 8px}input{width:100%;padding:12px 14px;border:1px solid #E3DFD5;border-radius:8px;font:inherit;margin-bottom:16px}button{width:100%;padding:13px;border:0;border-radius:8px;background:#16213E;color:#fff;font:600 14px Inter,sans-serif;cursor:pointer}button:hover{background:#24345C}.message{padding:11px 13px;border-radius:8px;margin-bottom:16px;background:#FBEBD4;color:#7A4C12;font-size:13px}.error{color:#9B3B37;font-size:13px;margin:-8px 0 12px}a{display:inline-block;margin-top:18px;color:#3A4E7A;font-size:13px;text-decoration:none}a:hover{text-decoration:underline}
        .card { padding: 30px; border: 1px solid #e8eaf0; border-radius: 18px; box-shadow: 0 18px 48px #101a3340; }
        h1 { font: 600 28px/1.25 Inter, sans-serif; letter-spacing: -.03em; }
        p { color: #6f7c90; font-size: 14px; line-height: 1.6; margin-bottom: 20px; }
        label { font-size: 13px; margin-bottom: 7px; }
        input { min-height: 44px; padding: 11px 13px; border-radius: 9px; font-size: 13px; margin-bottom: 12px; }
        button { min-height: 44px; border-radius: 9px; font-size: 13px; }
        .message, .error { font-size: 13px; line-height: 1.5; }
        a { font-size: 13px; }
        @media (max-width: 520px) { body { padding: 12px; } .card { padding: 24px 18px; border-radius: 15px; } h1 { font-size: 25px; } }
    </style>
</head>
<body>
    <main class="card">
        <div class="brand">◆ <span>Dorm Portal</span></div>
        <h1>Enter your verification code</h1>
        <p>We sent a six-digit code to your email address. Enter it below to verify your account or continue with password recovery.</p>
        @if (session('success')) <div class="message">{{ session('success') }}</div> @endif
        <form method="POST" action="{{ route('email.verification.code') }}">
            @csrf
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email') <div class="error">{{ $message }}</div> @enderror
            <label for="code">Verification code</label>
            <input id="code" type="text" name="code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" autocomplete="one-time-code" required>
            @error('code') <div class="error">{{ $message }}</div> @enderror
            <button type="submit">Verify email</button>
        </form>
        <form method="POST" action="{{ route('email.verification.code.resend') }}" style="margin-top:12px">
            @csrf
            <input type="hidden" name="email" value="{{ old('email') }}">
            <button type="submit">Send a new code</button>
        </form>
        <a href="{{ route('login') }}">← Back to login</a>
    </main>
</body>
</html>
