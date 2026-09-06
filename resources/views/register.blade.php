<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Dormitory Management System</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .card {
            background: #ffffff;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 420px;
        }
        .card h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 8px;
            font-size: 24px;
        }
        .card p {
            color: #7f8c8d;
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #34495e;
        }
        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #dcdfe6;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            outline: none;
            background-color: #fff;
        }
        .form-group input:focus, 
        .form-group select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.15);
        }
        .password-wrapper {
            position: relative;
        }
        .password-wrapper input {
            padding-right: 40px;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            display: flex;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 10px;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #6c757d;
        }
        .footer-text a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }
        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Student Registration</h2>
        <p>Create your account to access the dormitory system</p>
        
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
                    <input type="password" id="password" name="password" placeholder="•••••••" required>
                    <span class="password-toggle" onclick="togglePassword()">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>