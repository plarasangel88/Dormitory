<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose a New Password - Dorm Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;background:#16213E;color:#2A2620;font-family:Inter,sans-serif;padding:24px}.card{width:min(100%,440px);background:#FBF8F2;border-radius:16px;padding:38px;box-shadow:0 20px 60px #101a3355}.brand{color:#A9721F;font-weight:700;margin-bottom:26px}.brand span{color:#16213E}h1{font:500 30px Fraunces,serif;margin:0 0 8px}p{color:#8993A8;line-height:1.6;margin:0 0 24px}label{display:block;font-size:13px;font-weight:600;margin:0 0 8px}input{width:100%;padding:12px 14px;border:1px solid #E3DFD5;border-radius:8px;font:inherit;margin-bottom:16px}button{width:100%;padding:13px;border:0;border-radius:8px;background:#16213E;color:#fff;font:600 14px Inter,sans-serif;cursor:pointer}button:hover{background:#24345C}.error{color:#9B3B37;font-size:13px;margin:-8px 0 12px}a{display:inline-block;margin-top:18px;color:#3A4E7A;font-size:13px;text-decoration:none}a:hover{text-decoration:underline}
    </style>
</head>
<body>
    <main class="card">
        <div class="brand">◆ <span>Dorm Portal</span></div>
        <h1>Choose a new password</h1>
        <p>Use a password with at least eight characters.</p>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email">
            @error('email') <div class="error">{{ $message }}</div> @enderror
            <label for="password">New password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            @error('password') <div class="error">{{ $message }}</div> @enderror
            <label for="password_confirmation">Confirm new password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            <button type="submit">Reset password</button>
        </form>
        <a href="{{ route('login') }}">Back to login</a>
    </main>
</body>
</html>
