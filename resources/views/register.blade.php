<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Dormitory Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy-deep: #16213E;
            --navy-mid: #24345C;
            --navy-soft: #3A4E7A;
            --amber: #F0A857;
            --amber-soft: #F6C98B;
            --paper: #FBF8F2;
            --ink: #2A2620;
            --slate: #8993A8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            color: var(--ink);
        }

        body {
            display: flex;
            min-height: 100vh;
            background: var(--navy-deep);
        }

        .hero {
            position: relative;
            flex: 1.1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 56px;
            background: linear-gradient(180deg, #1B2A4D 0%, #16213E 55%, #101A33 100%);
            overflow: hidden;
        }

        .hero svg.skyline {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
        }

        .hero .moon {
            position: absolute;
            top: 64px;
            right: 72px;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: var(--amber-soft);
            box-shadow: 0 0 60px 12px rgba(240, 168, 87, 0.25);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 380px;
        }

        .hero-content .eyebrow-mark {
            width: 34px;
            height: 3px;
            background: var(--amber);
            margin-bottom: 22px;
        }

        .hero-content h1 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 34px;
            line-height: 1.25;
            color: var(--paper);
            margin-bottom: 14px;
        }

        .hero-content p {
            font-size: 14.5px;
            line-height: 1.65;
            color: #B7C0D6;
            max-width: 320px;
        }

        .panel {
            flex: 1;
            min-width: 400px;
            background: var(--paper);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .form-card {
            width: 100%;
            max-width: 380px;
        }

        .form-card .mark {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
        }

        .form-card .mark .key-badge {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--navy-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .form-card .mark span {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.2px;
            color: var(--navy-deep);
        }

        .form-card h2 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 27px;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .form-card > p.sub {
            font-size: 14px;
            color: var(--slate);
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 500;
            color: #5B6478;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #E3DFD5;
            border-radius: 9px;
            font-size: 14.5px;
            font-family: 'Inter', sans-serif;
            background: #FFFFFF;
            color: var(--ink);
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            outline: none;
        }

        .form-group select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%235B6478' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 38px;
        }

        .form-group input::placeholder {
            color: #B7B2A6;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--navy-soft);
            box-shadow: 0 0 0 3.5px rgba(58, 78, 122, 0.13);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 44px;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            transition: background-color 0.15s ease;
        }

        .password-toggle:hover {
            background-color: #F0ECE2;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background-color: var(--navy-deep);
            color: var(--paper);
            border: none;
            border-radius: 9px;
            font-size: 14.5px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 6px;
        }

        .btn-submit:hover {
            background-color: var(--navy-mid);
        }

        .btn-submit:focus-visible,
        .form-group input:focus-visible,
        .form-group select:focus-visible,
        .password-toggle:focus-visible {
            outline: 2.5px solid var(--amber);
            outline-offset: 2px;
        }

        .footer-text {
            text-align: center;
            margin-top: 22px;
            font-size: 13.5px;
            color: var(--slate);
        }

        .footer-text a {
            color: var(--navy-deep);
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1.5px solid var(--amber);
        }

        .footer-text a:hover {
            color: var(--navy-mid);
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }

        @media (max-width: 860px) {
            body { flex-direction: column; }
            .hero {
                flex: none;
                min-height: 220px;
                padding: 32px 28px;
            }
            .hero-content h1 { font-size: 24px; }
            .hero-content p { display: none; }
            .panel { min-width: 0; padding: 32px 24px 48px; }
        }
    </style>
</head>
<body>

    <div class="hero">
        <div class="moon"></div>
        <svg class="skyline" viewBox="0 0 700 220" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="0" y="70" width="110" height="150" fill="#1F2E52"/>
            <rect x="120" y="30" width="90" height="190" fill="#243769"/>
            <rect x="220" y="95" width="130" height="125" fill="#1B2A4D"/>
            <rect x="360" y="10" width="100" height="210" fill="#263C74"/>
            <rect x="470" y="60" width="110" height="160" fill="#1F2E52"/>
            <rect x="590" y="40" width="110" height="180" fill="#243769"/>
            <g fill="#F0A857" opacity="0.85">
                <rect x="18" y="90" width="12" height="16" rx="1.5"/>
                <rect x="46" y="90" width="12" height="16" rx="1.5"/>
                <rect x="18" y="120" width="12" height="16" rx="1.5"/>
                <rect x="74" y="120" width="12" height="16" rx="1.5"/>
                <rect x="140" y="55" width="12" height="16" rx="1.5"/>
                <rect x="168" y="85" width="12" height="16" rx="1.5"/>
                <rect x="140" y="115" width="12" height="16" rx="1.5"/>
                <rect x="196" y="145" width="12" height="16" rx="1.5"/>
                <rect x="248" y="120" width="12" height="16" rx="1.5"/>
                <rect x="276" y="150" width="12" height="16" rx="1.5"/>
                <rect x="304" y="120" width="12" height="16" rx="1.5"/>
                <rect x="386" y="40" width="12" height="16" rx="1.5"/>
                <rect x="414" y="70" width="12" height="16" rx="1.5"/>
                <rect x="386" y="100" width="12" height="16" rx="1.5"/>
                <rect x="442" y="130" width="12" height="16" rx="1.5"/>
                <rect x="494" y="85" width="12" height="16" rx="1.5"/>
                <rect x="522" y="115" width="12" height="16" rx="1.5"/>
                <rect x="550" y="145" width="12" height="16" rx="1.5"/>
                <rect x="612" y="65" width="12" height="16" rx="1.5"/>
                <rect x="640" y="95" width="12" height="16" rx="1.5"/>
                <rect x="612" y="125" width="12" height="16" rx="1.5"/>
            </g>
            <g fill="#4A5A85" opacity="0.6">
                <rect x="46" y="150" width="12" height="16" rx="1.5"/>
                <rect x="168" y="115" width="12" height="16" rx="1.5"/>
                <rect x="304" y="150" width="12" height="16" rx="1.5"/>
                <rect x="414" y="160" width="12" height="16" rx="1.5"/>
                <rect x="550" y="85" width="12" height="16" rx="1.5"/>
                <rect x="640" y="155" width="12" height="16" rx="1.5"/>
            </g>
        </svg>

        <div class="hero-content">
            <div class="eyebrow-mark"></div>
            <h1>One key,<br>every room you'll ever need.</h1>
            <p>Create your account to manage room assignments, dues, and maintenance requests for your residence hall — all in one place.</p>
        </div>
    </div>

    <div class="panel">
        <div class="form-card">
            <div class="mark">
                <div class="key-badge">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#F0A857" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="15" r="4"></circle>
                        <path d="M10.5 12.5L19 4M19 4h-4M19 4v4"></path>
                    </svg>
                </div>
                <span>Dormitory Management System</span>
            </div>

            <h2>Create your account</h2>
            <p class="sub">Fill in your details to register for the dormitory system.</p>

            <form action="/register" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Angel Plaras" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="student@example.com" required>
                </div>
                <div class="form-group">
                    <label for="course">Course</label>
                    <select name="course" id="course" required>
                        <option value="" disabled selected>Select a course</option>
                        <option value="BS Information Technology">BS Information Technology</option>
                        <option value="BS Office Administration">BS Computer Science</option>
                        <option value="BS Criminology">BS Information Systems</option>
                        <option value="BS Elementary Education">BS Business Administration</option>
                        <option value="BS Political Science">BS Business Administration</option>
                        <option value="BS Communication">BS Business Administration</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="angelplaras" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <span class="password-toggle" id="togglePassword" role="button" tabindex="0" aria-label="Show password">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#5B6478" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events: none;">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Register Account</button>
            </form>

            <div class="footer-text">
                Already have an account? <a href="/login">Login here</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    </script>

</body>
</html>