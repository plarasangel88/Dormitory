
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Student Dashboard | Dorm Portal</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --navy: #172b4d;
            --navy-light: #223d65;
            --cream: #f7f5ef;
            --white: #ffffff;
            --amber: #f3b33d;
            --amber-light: #fff3d6;
            --text: #26364b;
            --muted: #7d8797;
            --border: #e8eaf0;
            --green: #26996f;
            --red: #e84b4b;
            --shadow: 0 5px 20px rgba(23, 43, 77, 0.06);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--text);
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        /* SIDEBAR */

        .sidebar {
            width: 255px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--navy);
            color: var(--white);
            padding: 25px 18px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 10px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            background: var(--amber);
            color: var(--navy);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .brand-name {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: 0.3px;
        }

        .brand-subtitle {
            color: #b7c4d7;
            font-size: 10px;
            margin-top: 2px;
        }

        .sidebar-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #9baac0;
            margin: 27px 12px 12px;
            font-weight: 600;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            color: #d3dbea;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            transition: 0.2s;
        }

        .nav-link i {
            width: 19px;
            text-align: center;
            font-size: 15px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: white;
        }

        .nav-link.active {
            background: var(--amber);
            color: var(--navy);
            font-weight: 700;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 25px;
        }

        .help-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 13px;
            padding: 16px;
            margin-bottom: 18px;
        }

        .help-card i {
            color: var(--amber);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .help-card h4 {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .help-card p {
            color: #bdc9d9;
            font-size: 10px;
            line-height: 1.7;
        }

        .logout-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #f3b5b5;
            padding: 12px 14px;
            font-size: 13px;
            border-radius: 10px;
        }

        .logout-link:hover {
            background: rgba(232,75,75,0.13);
        }

        /* MAIN CONTENT */

        .main-content {
            margin-left: 255px;
            min-height: 100vh;
        }

        /* HEADER */

        .top-header {
            height: 83px;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 35px;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 500;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--navy);
            font-size: 20px;
        }

        .page-heading h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--navy);
        }

        .page-heading p {
            color: var(--muted);
            font-size: 11px;
            margin-top: 3px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-bar {
            width: 230px;
            height: 40px;
            background: #f6f7fa;
            border: 1px solid var(--border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 13px;
        }

        .search-bar i {
            color: var(--muted);
            font-size: 13px;
        }

        .search-bar input {
            width: 100%;
            min-width: 0;
            border: none;
            outline: none;
            background: transparent;
            font-size: 11px;
            color: var(--text);
        }

        /* NOTIFICATION BELL */

        .notification-wrapper {
            position: relative;
        }

        .notification-button {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--white);
            border: 1px solid var(--border);
            color: var(--navy);
            font-size: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: 0.2s;
        }

        .notification-button:hover {
            background: var(--amber-light);
            border-color: var(--amber);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 19px;
            height: 19px;
            padding: 0 5px;
            border-radius: 50px;
            background: var(--red);
            color: white;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        .notification-badge[hidden] {
            display: none;
        }

        .notification-dropdown {
            position: absolute;
            top: 53px;
            right: 0;
            width: 340px;
            max-width: calc(100vw - 25px);
            background: white;
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: 0 12px 35px rgba(23,43,77,0.15);
            overflow: hidden;
            display: none;
            z-index: 1200;
        }

        .notification-dropdown.open {
            display: block;
        }

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 17px;
            border-bottom: 1px solid var(--border);
        }

        .notification-header h3 {
            font-size: 14px;
            color: var(--navy);
        }

        .notification-header button {
            border: none;
            background: none;
            color: #3768a5;
            font-size: 10px;
            font-weight: 600;
        }

        .notification-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 15px 17px;
            border-bottom: 1px solid #f0f1f4;
            cursor: pointer;
        }

        .notification-item:hover {
            background: #fafbfe;
        }

        .notification-item.unread {
            background: #fffaf0;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            border-radius: 10px;
            background: var(--amber-light);
            color: #a66b00;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .notification-text {
            min-width: 0;
            flex: 1;
        }

        .notification-text h4 {
            font-size: 12px;
            color: var(--navy);
            margin-bottom: 4px;
            overflow-wrap: anywhere;
        }

        .notification-text p {
            font-size: 10px;
            line-height: 1.7;
            color: #687589;
            overflow-wrap: anywhere;
        }

        .notification-time {
            display: block;
            margin-top: 6px;
            font-size: 9px;
            color: #99a1af;
        }

        .empty-notification {
            text-align: center;
            padding: 28px 15px;
            color: var(--muted);
            font-size: 11px;
        }

        .empty-notification i {
            display: block;
            font-size: 25px;
            margin-bottom: 10px;
            color: #c5cbd5;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 12px;
            background: var(--navy);
            color: var(--amber);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            font-weight: 700;
        }

        .user-name {
            display: block;
            color: var(--navy);
            font-size: 12px;
            font-weight: 700;
        }

        .user-role {
            display: block;
            color: var(--muted);
            font-size: 10px;
            margin-top: 3px;
        }

        /* DASHBOARD BODY */

        .dashboard-body {
            padding: 30px 35px 40px;
            max-width: 1600px;
            margin: 0 auto;
        }

        .welcome-banner {
            background: var(--navy);
            color: white;
            border-radius: 17px;
            padding: 28px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            position: relative;
            overflow: hidden;
            margin-bottom: 28px;
        }

        .welcome-banner::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            border: 35px solid rgba(255,255,255,0.045);
            right: 100px;
            top: -100px;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .welcome-content .eyebrow {
            color: var(--amber);
            text-transform: uppercase;
            letter-spacing: 1.7px;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .welcome-content h1 {
            font-size: 25px;
            line-height: 1.4;
            margin-bottom: 8px;
        }

        .welcome-content p {
            color: #c5d0df;
            font-size: 12px;
            line-height: 1.8;
            max-width: 560px;
        }

        .welcome-date {
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.09);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 15px 18px;
            border-radius: 12px;
            min-width: 155px;
        }

        .welcome-date span {
            display: block;
            font-size: 10px;
            color: #c5d0df;
            margin-bottom: 5px;
        }

        .welcome-date strong {
            font-size: 13px;
            color: var(--amber);
        }

        /* SECTION HEADINGS */

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 17px;
        }

        .section-heading h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--navy);
        }

        .section-heading p {
            font-size: 10px;
            color: var(--muted);
            margin-top: 4px;
        }

        .section-link {
            color: #315e95;
            font-size: 10px;
            font-weight: 600;
        }

        /* SUMMARY CARDS */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            box-shadow: var(--shadow);
            min-width: 0;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 19px;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 17px;
        }

        .icon-amber {
            background: var(--amber-light);
            color: #a66b00;
        }

        .icon-blue {
            background: #e8f0ff;
            color: #416bb1;
        }

        .icon-green {
            background: #e3f6ed;
            color: var(--green);
        }

        .icon-red {
            background: #ffe9e9;
            color: var(--red);
        }

        .stat-label {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.6;
        }

        .stat-value {
            color: var(--navy);
            font-size: 23px;
            font-weight: 800;
            margin-top: 5px;
            overflow-wrap: anywhere;
        }

        .stat-note {
            color: var(--muted);
            font-size: 9px;
            margin-top: 7px;
        }

        /* MAIN GRID */

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(280px, 0.9fr);
            gap: 22px;
            align-items: start;
        }

        .card-panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 22px;
            box-shadow: var(--shadow);
            min-width: 0;
            margin-bottom: 22px;
        }

        /* QUICK ACTIONS */

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 13px;
        }

        .action-card {
            display: flex;
            align-items: center;
            gap: 13px;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 13px;
            transition: 0.2s;
            min-width: 0;
        }

        .action-card:hover {
            border-color: var(--amber);
            background: #fffdf7;
            transform: translateY(-2px);
        }

        .action-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--amber-light);
            color: #9c690b;
            font-size: 16px;
        }

        .action-text {
            min-width: 0;
        }

        .action-text h4 {
            font-size: 11px;
            color: var(--navy);
            margin-bottom: 4px;
        }

        .action-text p {
            font-size: 9px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ROOM INFORMATION */

        .room-card {
            background: #f9fafc;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 17px;
        }

        .room-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .room-top h4 {
            color: var(--navy);
            font-size: 13px;
        }

        .status-badge {
            background: #e1f6eb;
            color: #18794e;
            border-radius: 20px;
            padding: 5px 9px;
            font-size: 9px;
            font-weight: 700;
        }

        .room-number {
            font-size: 25px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 4px;
        }

        .room-description {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.7;
        }

        .room-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .room-detail span {
            display: block;
            color: var(--muted);
            font-size: 9px;
            margin-bottom: 5px;
        }

        .room-detail strong {
            display: block;
            color: var(--navy);
            font-size: 11px;
            overflow-wrap: anywhere;
        }

        /* PAYMENT */

        .payment-amount {
            font-size: 26px;
            font-weight: 800;
            color: var(--navy);
            margin: 8px 0 5px;
        }

        .payment-caption {
            font-size: 10px;
            color: var(--muted);
            line-height: 1.7;
        }

        .payment-status {
            display: inline-block;
            margin-top: 13px;
            background: var(--amber-light);
            color: #956100;
            border-radius: 20px;
            padding: 6px 10px;
            font-size: 9px;
            font-weight: 700;
        }

        .primary-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 15px;
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 10px;
            font-weight: 600;
            margin-top: 17px;
            transition: 0.2s;
        }

        .primary-button:hover {
            background: var(--navy-light);
        }

        /* ANNOUNCEMENT PREVIEW */

        .announcement-list {
            list-style: none;
        }

        .announcement-item {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 16px 0;
            border-bottom: 1px solid #eff0f3;
        }

        .announcement-item:first-child {
            padding-top: 3px;
        }

        .announcement-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .ann-icon {
            width: 37px;
            height: 37px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--amber-light);
            color: #9c690b;
            font-size: 14px;
        }

        .ann-content {
            flex: 1;
            min-width: 0;
        }

        .ann-title {
            font-size: 12px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 6px;
            overflow-wrap: anywhere;
        }

        .ann-body {
            color: #697587;
            font-size: 10px;
            line-height: 1.8;
            overflow-wrap: anywhere;
        }

        .ann-meta {
            display: block;
            color: #9aa2ae;
            font-size: 9px;
            margin-top: 8px;
        }

        .pin-tag {
            display: inline-block;
            background: var(--amber-light);
            color: #926000;
            border-radius: 4px;
            padding: 3px 5px;
            font-size: 8px;
            margin-left: 5px;
            vertical-align: middle;
        }

        .empty-message {
            color: var(--muted);
            font-size: 11px;
            text-align: center;
            padding: 20px 10px;
        }

        /* FOOTER */

        .dashboard-footer {
            padding: 5px 0 15px;
            text-align: center;
            color: #9aa2ae;
            font-size: 10px;
        }

        .mobile-overlay {
            display: none;
        }

        /* RESPONSIVE DESIGN */

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .dashboard-body {
                padding: 25px;
            }

            .top-header {
                padding: 0 25px;
            }
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .mobile-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.35);
                z-index: 900;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .top-header {
                height: 72px;
                padding: 0 15px;
                gap: 10px;
            }

            .page-heading h2 {
                font-size: 15px;
            }

            .page-heading p {
                display: none;
            }

            .header-right {
                gap: 10px;
            }

            .search-bar {
                display: none;
            }

            .user-info {
                display: none;
            }

            .avatar {
                width: 37px;
                height: 37px;
            }

            .dashboard-body {
                padding: 20px 15px 30px;
            }

            .welcome-banner {
                padding: 23px 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .welcome-content h1 {
                font-size: 21px;
            }

            .welcome-date {
                min-width: 0;
                width: 100%;
            }

            .stats-grid {
                gap: 12px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-value {
                font-size: 20px;
            }

            .card-panel {
                padding: 17px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .notification-dropdown {
                right: -85px;
            }
        }
    </style>
</head>

<body>

    @include('student.partials.sidebar')

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOP HEADER -->
        <header class="top-header">

            <div class="header-left">
                <button class="menu-toggle" id="menuToggle" aria-label="Open navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="page-heading">
                    <h2>Student Dashboard</h2>
                    <p>Manage your dormitory information in one place.</p>
                </div>
            </div>

            <div class="header-right">

                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="dashboardSearch" placeholder="Search announcements...">
                </div>

                <!-- ANNOUNCEMENT NOTIFICATION BELL -->
                <div class="notification-wrapper">

                    <button
                        class="notification-button"
                        id="notificationButton"
                        type="button"
                        aria-label="View announcements"
                        aria-expanded="false"
                        aria-controls="notificationDropdown">

                        <i class="fa-regular fa-bell"></i>

                        <span class="notification-badge"
                              id="notificationBadge"
                              hidden>1</span>
                    </button>

                    <div class="notification-dropdown" id="notificationDropdown">

                        <div class="notification-header">
                            <h3>Announcements</h3>
                            <button type="button" id="markAllRead">Mark all as read</button>
                        </div>

                        <div class="notification-list" id="notificationList">
                            <div class="empty-notification">
                                <i class="fa-regular fa-bell-slash"></i>
                                Loading announcements...
                            </div>
                        </div>

                    </div>
                </div>

                <!-- STUDENT PROFILE -->
                <div class="user-profile">
                    <div class="avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                    </div>

                    <div class="user-info">
                        <span class="user-name">
                            {{ auth()->user()->name ?? 'Student' }}
                        </span>
                        <span class="user-role">
                            {{ strtoupper(auth()->user()->role ?? 'STUDENT') }}
                        </span>
                    </div>
                </div>

            </div>
        </header>

        <!-- DASHBOARD BODY -->
        <section class="dashboard-body">

            <!-- WELCOME BANNER -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <div class="eyebrow">Your Dormitory, Your Space</div>

                    <h1>
                        Welcome back,
                        {{ explode(' ', trim(auth()->user()->name ?? 'Student'))[0] }}!
                    </h1>

                    <p>
                        Welcome to your student dashboard. Check your room information,
                        review your payments, submit maintenance requests, and stay
                        updated with the latest dormitory announcements.
                    </p>
                </div>

                <div class="welcome-date">
                    <span><i class="fa-regular fa-calendar"></i> Today's Date</span>
                    <strong>{{ now()->format('F d, Y') }}</strong>
                </div>
            </div>

            <!-- SUMMARY CARDS -->
            <div class="section-heading">
                <div>
                    <h3>Overview</h3>
                    <p>A quick look at your dormitory information.</p>
                </div>
            </div>

            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">My Room</div>
                            <div class="stat-value">
                                {{ $room->room_number ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="stat-icon icon-amber">
                            <i class="fa-solid fa-bed"></i>
                        </div>
                    </div>

                    <div class="stat-note">Your assigned room</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">Payment Status</div>
                            <div class="stat-value" style="font-size:18px;">
                                {{ $paymentStatus ?? 'Pending' }}
                            </div>
                        </div>

                        <div class="stat-icon icon-blue">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                    </div>

                    <div class="stat-note">Check your payment records</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">Maintenance Requests</div>
                            <div class="stat-value">
                                {{ $maintenanceCount ?? 0 }}
                            </div>
                        </div>

                        <div class="stat-icon icon-green">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                    </div>

                    <div class="stat-note">Your submitted requests</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">Announcements</div>
                            <div class="stat-value" id="announcementTotal">
                                {{ isset($announcements) ? $announcements->count() : 0 }}
                            </div>
                        </div>

                        <div class="stat-icon icon-red">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                    </div>

                    <div class="stat-note">Updates from the administrator</div>
                </div>

            </div>

            <!-- MAIN CONTENT GRID -->
            <div class="content-grid">

                <div class="left-column">

                    <!-- QUICK ACTIONS -->
                    <div class="card-panel">
                        <div class="section-heading">
                            <div>
                                <h3>Quick Actions</h3>
                                <p>Quickly access common student services.</p>
                            </div>
                        </div>

                        <div class="quick-actions">

                            <a href="{{ route('room') }}" class="action-card">
                                <div class="action-icon">
                                    <i class="fa-solid fa-bed"></i>
                                </div>
                                <div class="action-text">
                                    <h4>View My Room</h4>
                                    <p>Check your room assignment.</p>
                                </div>
                            </a>

                            <a href="{{ route('payments') }}" class="action-card">
                                <div class="action-icon">
                                    <i class="fa-solid fa-credit-card"></i>
                                </div>
                                <div class="action-text">
                                    <h4>View Payments</h4>
                                    <p>Review your payment information.</p>
                                </div>
                            </a>

                            <a href="{{ route('maintenance.index') }}" class="action-card">
                                <div class="action-icon">
                                    <i class="fa-solid fa-screwdriver-wrench"></i>
                                </div>
                                <div class="action-text">
                                    <h4>Request Maintenance</h4>
                                    <p>Report a room-related concern.</p>
                                </div>
                            </a>

                            <a href="{{ route('profile') }}" class="action-card">
                                <div class="action-icon">
                                    <i class="fa-solid fa-user-pen"></i>
                                </div>
                                <div class="action-text">
                                    <h4>My Profile</h4>
                                    <p>View your student information.</p>
                                </div>
                            </a>

                        </div>
                    </div>

                    <!-- ANNOUNCEMENTS PREVIEW -->
                    <div class="card-panel">
                        <div class="section-heading">
                            <div>
                                <h3><i class="fa-solid fa-bullhorn"></i> Latest Announcements</h3>
                                <p>Important updates from your dorm administrator.</p>
                            </div>

                            <button type="button"
                                    class="section-link"
                                    id="openAllAnnouncements"
                                    style="background:none;border:none;cursor:pointer;">
                                View in bell <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>

                        <ul class="announcement-list" id="dashboardAnnouncementList">
                            @forelse(($announcements ?? collect()) as $a)
                                <li class="announcement-item"
                                    data-announcement-id="{{ $a->id }}">

                                    <span class="ann-icon">
                                        <i class="fa-solid {{ $a->is_pinned ? 'fa-thumbtack' : 'fa-bullhorn' }}"></i>
                                    </span>

                                    <div class="ann-content">
                                        <div class="ann-title">
                                            {{ $a->title }}

                                            @if($a->is_pinned)
                                                <span class="pin-tag">PINNED</span>
                                            @endif
                                        </div>

                                        <div class="ann-body">{!! nl2br(e($a->body)) !!}</div>

                                        <span class="ann-meta">
                                            Posted {{ $a->created_at?->diffForHumans() ?? '' }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="empty-message">
                                    No announcements right now.
                                </li>
                            @endforelse
                        </ul>
                    </div>

                </div>

                <div class="right-column">

                    <!-- ROOM INFORMATION -->
                    <div class="card-panel">
                        <div class="section-heading">
                            <div>
                                <h3><i class="fa-solid fa-door-open"></i> Room Information</h3>
                                <p>Your current room assignment.</p>
                            </div>
                        </div>

                        @if(isset($room) && $room)
                            <div class="room-card">
                                <div class="room-top">
                                    <h4>Assigned Room</h4>
                                    <span class="status-badge">Assigned</span>
                                </div>

                                <div class="room-number">
                                    {{ $room->room_number ?? 'N/A' }}
                                </div>

                                <div class="room-description">
                                    Your assigned dormitory room.
                                </div>

                                <div class="room-details">
                                    <div class="room-detail">
                                        <span>Room Type</span>
                                        <strong>{{ $room->room_type ?? 'Not specified' }}</strong>
                                    </div>

                                    <div class="room-detail">
                                        <span>Capacity</span>
                                        <strong>{{ $room->capacity ?? 'N/A' }}</strong>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="empty-message">
                                <i class="fa-solid fa-bed" style="font-size:24px;margin-bottom:10px;"></i>
                                <p>No room information is available yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- PAYMENT INFORMATION -->
                    <div class="card-panel">
                        <div class="section-heading">
                            <div>
                                <h3><i class="fa-solid fa-wallet"></i> Payment Information</h3>
                                <p>Your payment overview.</p>
                            </div>
                        </div>

                        <div class="payment-caption">Current payment status</div>

                        <div class="payment-amount">
                            {{ $paymentStatus ?? 'Pending' }}
                        </div>

                        <div class="payment-caption">
                            Visit the payments section to review your records
                            and any outstanding balance.
                        </div>

                        <span class="payment-status">
                            {{ strtoupper($paymentStatus ?? 'PENDING') }}
                        </span>

                        <br>

                        <a href="{{ route('payments') }}" class="primary-button">
                            View Payments
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- REMINDERS -->
                    <div class="card-panel">
                        <div class="section-heading">
                            <div>
                                <h3><i class="fa-regular fa-lightbulb"></i> Reminders</h3>
                                <p>Helpful reminders for residents.</p>
                            </div>
                        </div>

                        <ul style="list-style:none;">
                            <li style="display:flex;gap:10px;margin-bottom:15px;">
                                <i class="fa-solid fa-circle-check"
                                   style="color:var(--green);margin-top:3px;"></i>
                                <span style="font-size:10px;line-height:1.8;color:#687589;">
                                    Keep your room clean and organized.
                                </span>
                            </li>

                            <li style="display:flex;gap:10px;margin-bottom:15px;">
                                <i class="fa-solid fa-circle-check"
                                   style="color:var(--green);margin-top:3px;"></i>
                                <span style="font-size:10px;line-height:1.8;color:#687589;">
                                    Check announcements for dormitory updates.
                                </span>
                            </li>

                            <li style="display:flex;gap:10px;">
                                <i class="fa-solid fa-circle-check"
                                   style="color:var(--green);margin-top:3px;"></i>
                                <span style="font-size:10px;line-height:1.8;color:#687589;">
                                    Report maintenance problems promptly.
                                </span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <footer class="dashboard-footer">
                &copy; {{ date('Y') }} Dorm Portal. Student Dashboard.
            </footer>

        </section>
    </main>

    <!-- ANNOUNCEMENT DATA FROM LARAVEL -->
    @php
        $announcementData = ($announcements ?? collect())->map(function ($announcement) {
            return [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'body' => $announcement->body,
                'is_pinned' => (bool) $announcement->is_pinned,
                'created_at' => $announcement->created_at?->toIso8601String(),
                'created_human' => $announcement->created_at?->diffForHumans(),
            ];
        })->values();
    @endphp
    <script type="application/json" id="announcementData">@json($announcementData)</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            const mobileOverlay = document.getElementById('mobileOverlay');

            const notificationButton = document.getElementById('notificationButton');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationBadge = document.getElementById('notificationBadge');
            const notificationList = document.getElementById('notificationList');
            const markAllReadButton = document.getElementById('markAllRead');

            const announcementDataElement = document.getElementById('announcementData');
            const dashboardAnnouncementList = document.getElementById('dashboardAnnouncementList');
            const announcementTotal = document.getElementById('announcementTotal');
            const searchInput = document.getElementById('dashboardSearch');
            const openAllAnnouncements = document.getElementById('openAllAnnouncements');

            /*
             * These read IDs are stored per browser and per logged-in user.
             * A new announcement ID will increase the unread count.
             */
            const userId = @json(auth()->id());
            const storagePrefix = 'dormPortalAnnouncements:' + userId + ':';
            const lastSeenKey = storagePrefix + 'lastSeenId';
            const readIdsKey = storagePrefix + 'readIds';

            let announcements = [];
            let isRefreshing = false;

            function readStoredIds() {
                try {
                    return JSON.parse(localStorage.getItem(readIdsKey) || '[]')
                        .map(String);
                } catch (error) {
                    return [];
                }
            }

            function saveReadIds(ids) {
                localStorage.setItem(readIdsKey, JSON.stringify(ids));
            }

            function getLastSeenId() {
                return localStorage.getItem(lastSeenKey);
            }

            function getCurrentData() {
                try {
                    const data = JSON.parse(announcementDataElement.textContent || '[]');
                    return Array.isArray(data) ? data : [];
                } catch (error) {
                    return [];
                }
            }

            function formatDate(dateString, humanDate) {
                if (humanDate) {
                    return humanDate;
                }

                if (!dateString) {
                    return 'Recently posted';
                }

                const date = new Date(dateString);

                if (Number.isNaN(date.getTime())) {
                    return 'Recently posted';
                }

                return date.toLocaleString();
            }

            function getUnreadAnnouncements() {
                const readIds = readStoredIds();

                return announcements.filter(function (item) {
                    return !readIds.includes(String(item.id));
                });
            }

            function updateBadge() {
                const unreadCount = getUnreadAnnouncements().length;

                if (unreadCount > 0) {
                    notificationBadge.hidden = false;
                    notificationBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                } else {
                    notificationBadge.hidden = true;
                    notificationBadge.textContent = '';
                }
            }

            function makeElement(tag, className, text) {
                const element = document.createElement(tag);

                if (className) {
                    element.className = className;
                }

                if (text !== undefined && text !== null) {
                    element.textContent = text;
                }

                return element;
            }

            function renderNotifications() {
                notificationList.replaceChildren();

                if (announcements.length === 0) {
                    const empty = makeElement('div', 'empty-notification');
                    const icon = makeElement('i', 'fa-regular fa-bell-slash');

                    empty.appendChild(icon);
                    empty.appendChild(document.createTextNode('No announcements right now.'));

                    notificationList.appendChild(empty);
                    updateBadge();
                    return;
                }

                const readIds = readStoredIds();

                announcements.forEach(function (item) {
                    const isUnread = !readIds.includes(String(item.id));

                    const row = makeElement(
                        'div',
                        'notification-item' + (isUnread ? ' unread' : '')
                    );

                    row.dataset.announcementId = String(item.id);

                    const iconWrap = makeElement('div', 'notification-icon');
                    const icon = makeElement(
                        'i',
                        'fa-solid ' + (item.is_pinned ? 'fa-thumbtack' : 'fa-bullhorn')
                    );

                    iconWrap.appendChild(icon);

                    const content = makeElement('div', 'notification-text');
                    const title = makeElement('h4', '', item.title || 'Announcement');
                    const body = makeElement('p', '', item.body || '');
                    const time = makeElement(
                        'span',
                        'notification-time',
                        'Posted ' + formatDate(item.created_at, item.created_human)
                    );

                    content.appendChild(title);
                    content.appendChild(body);
                    content.appendChild(time);

                    row.appendChild(iconWrap);
                    row.appendChild(content);

                    row.addEventListener('click', function () {
                        markAnnouncementRead(item.id);
                        scrollToAnnouncement(item.id);
                        closeDropdown();
                    });

                    notificationList.appendChild(row);
                });

                updateBadge();
            }

            function markAnnouncementRead(id) {
                const readIds = readStoredIds();
                const idString = String(id);

                if (!readIds.includes(idString)) {
                    readIds.push(idString);
                    saveReadIds(readIds);
                }

                updateBadge();
                renderNotifications();
            }

            function markAllRead() {
                saveReadIds(announcements.map(function (item) {
                    return String(item.id);
                }));

                if (announcements.length > 0) {
                    localStorage.setItem(
                        lastSeenKey,
                        String(announcements[0].id)
                    );
                }

                updateBadge();
                renderNotifications();
            }

            function renderDashboardAnnouncements() {
                if (!dashboardAnnouncementList) {
                    return;
                }

                dashboardAnnouncementList.replaceChildren();

                if (announcements.length === 0) {
                    dashboardAnnouncementList.appendChild(
                        makeElement('li', 'empty-message', 'No announcements right now.')
                    );
                    return;
                }

                announcements.slice(0, 5).forEach(function (item) {
                    const li = makeElement('li', 'announcement-item');
                    li.dataset.announcementId = String(item.id);

                    const iconWrap = makeElement('span', 'ann-icon');
                    const icon = makeElement(
                        'i',
                        'fa-solid ' + (item.is_pinned ? 'fa-thumbtack' : 'fa-bullhorn')
                    );

                    iconWrap.appendChild(icon);

                    const content = makeElement('div', 'ann-content');
                    const title = makeElement('div', 'ann-title', item.title || 'Announcement');

                    if (item.is_pinned) {
                        title.appendChild(makeElement('span', 'pin-tag', 'PINNED'));
                    }

                    const body = makeElement('div', 'ann-body');
                    body.style.whiteSpace = 'pre-line';
                    body.textContent = item.body || '';

                    const meta = makeElement(
                        'span',
                        'ann-meta',
                        'Posted ' + formatDate(item.created_at, item.created_human)
                    );

                    content.appendChild(title);
                    content.appendChild(body);
                    content.appendChild(meta);

                    li.appendChild(iconWrap);
                    li.appendChild(content);

                    dashboardAnnouncementList.appendChild(li);
                });
            }

            function applySearch() {
                if (!searchInput) {
                    return;
                }

                const query = searchInput.value.trim().toLowerCase();

                document.querySelectorAll('#dashboardAnnouncementList .announcement-item')
                    .forEach(function (item) {
                        item.style.display = item.textContent.toLowerCase().includes(query)
                            ? ''
                            : 'none';
                    });
            }

            function scrollToAnnouncement(id) {
                const item = dashboardAnnouncementList.querySelector(
                    '[data-announcement-id="' + String(id).replace(/"/g, '') + '"]'
                );

                if (item) {
                    item.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    item.style.background = '#fff3d6';

                    setTimeout(function () {
                        item.style.background = '';
                    }, 1800);
                }
            }

            function openDropdown() {
                notificationDropdown.classList.add('open');
                notificationButton.setAttribute('aria-expanded', 'true');
            }

            function closeDropdown() {
                notificationDropdown.classList.remove('open');
                notificationButton.setAttribute('aria-expanded', 'false');
            }

            function toggleDropdown() {
                if (notificationDropdown.classList.contains('open')) {
                    closeDropdown();
                } else {
                    openDropdown();
                }
            }

            function loadAnnouncementData(data, updateLastSeen) {
                const oldIds = announcements.map(function (item) {
                    return String(item.id);
                });

                announcements = Array.isArray(data) ? data : [];

                /*
                 * First visit: treat the announcements already present as
                 * existing, so old announcements are not all marked new.
                 */
                if (updateLastSeen && getLastSeenId() === null) {
                    const ids = announcements.map(function (item) {
                        return String(item.id);
                    });

                    saveReadIds(ids);

                    if (ids.length > 0) {
                        localStorage.setItem(lastSeenKey, ids[0]);
                    }
                } else {
                    /*
                     * Do not automatically mark new announcements as read.
                     * They stay unread until the student clicks them or
                     * chooses "Mark all as read".
                     */
                    const newIds = announcements
                        .map(function (item) {
                            return String(item.id);
                        })
                        .filter(function (id) {
                            return !oldIds.includes(id);
                        });

                    if (newIds.length > 0 && getLastSeenId() === null) {
                        localStorage.setItem(lastSeenKey, newIds[0]);
                    }
                }

                if (announcementTotal) {
                    announcementTotal.textContent = announcements.length;
                }

                renderNotifications();
                renderDashboardAnnouncements();
                applySearch();
            }

            async function refreshAnnouncements() {
                if (isRefreshing) {
                    return;
                }

                isRefreshing = true;

                try {
                    /*
                     * The dashboard route must return the current announcements
                     * when fetched. Laravel renders them into announcementData.
                     */
                    const response = await fetch(window.location.href, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        },
                        cache: 'no-store'
                    });

                    if (!response.ok) {
                        throw new Error('Could not refresh announcements.');
                    }

                    const html = await response.text();
                    const parsedDocument = new DOMParser().parseFromString(html, 'text/html');
                    const newDataElement = parsedDocument.getElementById('announcementData');

                    if (!newDataElement) {
                        throw new Error('Announcement data was not found.');
                    }

                    const data = JSON.parse(newDataElement.textContent || '[]');

                    if (Array.isArray(data)) {
                        announcementDataElement.textContent = JSON.stringify(data);
                        loadAnnouncementData(data, false);
                    }
                } catch (error) {
                    console.warn('Announcement refresh failed:', error);
                } finally {
                    isRefreshing = false;
                }
            }

            // Initialize from Laravel data.
            loadAnnouncementData(getCurrentData(), true);

            // Check for new announcements every 30 seconds.
            window.setInterval(refreshAnnouncements, 30000);

            // Refresh when the user returns to the tab.
            document.addEventListener('visibilitychange', function () {
                if (!document.hidden) {
                    refreshAnnouncements();
                }
            });

            // Notification controls.
            notificationButton.addEventListener('click', function (event) {
                event.stopPropagation();
                toggleDropdown();
            });

            notificationDropdown.addEventListener('click', function (event) {
                event.stopPropagation();
            });

            document.addEventListener('click', function () {
                closeDropdown();
            });

            markAllReadButton.addEventListener('click', markAllRead);

            if (openAllAnnouncements) {
                openAllAnnouncements.addEventListener('click', function () {
                    openDropdown();
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', applySearch);
            }

            // Mobile sidebar.
            function closeSidebar() {
                sidebar.classList.remove('show');
                mobileOverlay.classList.remove('show');
            }

            menuToggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                mobileOverlay.classList.toggle('show');
            });

            mobileOverlay.addEventListener('click', closeSidebar);

            sidebar.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 900) {
                        closeSidebar();
                    }
                });
            });
        });
    </script>

</body>
</html>
