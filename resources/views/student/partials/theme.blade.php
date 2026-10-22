<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --navy: #172b4d;
        --navy-light: #223d65;
        --cream: #f7f5ef;
        --white: #fff;
        --amber: #f3b33d;
        --amber-light: #fff3d6;
        --text: #26364b;
        --muted: #7d8797;
        --border: #e8eaf0;
        --green: #26996f;
        --red: #e84b4b;
    }

    body { display: block !important; min-height: 100vh; font-family: 'Poppins', sans-serif !important; background: var(--cream) !important; color: var(--text); }
    /* Keep typography consistent even when a page has legacy local font rules. */
    .main, .main :not(i):not(svg):not(path), .dashboard-body, .dashboard-body :not(i):not(svg):not(path) {
        font-family: 'Poppins', sans-serif !important;
    }
    .main h1, .dashboard-body h1 { font-size: 22px !important; line-height: 1.35; font-weight: 700 !important; color: var(--navy) !important; }
    .main .page-head .sub, .dashboard-body .page-heading p { font-size: 12px !important; line-height: 1.6; }
    .main .section-title, .dashboard-body h2 { font-size: 14px !important; line-height: 1.4; font-weight: 700 !important; }
    .main .profile-identity .who { font-size: 16px !important; line-height: 1.4; font-weight: 700 !important; }
    .main .profile-identity .where { font-size: 11px !important; }
    .main .profile-avatar { font-size: 20px !important; font-weight: 700 !important; }
    .main .form-group label { font-size: 11px !important; font-weight: 600 !important; }
    .main .form-group input, .main .form-group select, .main .form-group textarea,
    .main .info-row, .main .btn-save { font-size: 13px !important; }
    .main .info-row .label { font-size: 10px !important; }
    .main .alert-success, .main .alert-error { font-size: 12px !important; }
    .app-container { display: block !important; min-height: 100vh; }
    .sidebar, .sidebar-wrapper .sidebar {
        position: fixed !important; inset: 0 auto 0 0; z-index: 1000; width: 255px !important; height: 100vh;
        padding: 25px 18px !important; overflow-y: auto; display: flex; flex-direction: column;
        background: var(--navy) !important; color: var(--white) !important; border: 0 !important; transition: transform .25s ease;
    }
    .sidebar.collapsed { width: 255px !important; padding: 25px 18px !important; }
    .sidebar-brand, .brand, .logo { color: var(--white) !important; font: 700 19px 'Poppins', sans-serif !important; margin: 0 !important; padding: 5px 10px 30px !important; border-bottom: 1px solid #ffffff20; }
    .brand { display: flex; align-items: center; gap: 12px; }
    .brand-icon { width: 43px; height: 43px; flex: 0 0 43px; display: grid; place-items: center; border-radius: 12px; background: var(--amber); color: var(--navy); font-size: 21px; }
    .brand-name { font: 800 19px 'Poppins', sans-serif !important; letter-spacing: .3px; }
    .brand-subtitle { margin-top: 2px; color: #b7c4d7; font: 400 10px 'Poppins', sans-serif !important; }
    .sidebar-label { margin: 27px 12px 12px; color: #9baac0; font: 600 10px 'Poppins', sans-serif !important; letter-spacing: 1.5px; text-transform: uppercase; }
    .sidebar-menu, .nav-menu, .sidebar nav { display: flex; flex-direction: column; gap: 7px; flex-grow: 1; }
    .menu-item, .nav-link, .sidebar nav > a {
        display: flex; align-items: center; gap: 13px; padding: 13px 14px !important; border-radius: 10px !important;
        color: #d3dbea !important; background: transparent; text-decoration: none; font: 500 13px 'Poppins', sans-serif !important;
        transition: background .2s ease, color .2s ease;
    }
    .nav-link i { width: 19px; text-align: center; font-size: 15px; }
    .menu-item:hover, .nav-link:hover, .sidebar nav > a:hover { color: #fff !important; background: #ffffff14 !important; }
    .menu-item.active, .nav-link.active, .sidebar nav > a.active { color: var(--navy) !important; background: var(--amber) !important; box-shadow: none !important; font-weight: 700 !important; }
    .sidebar-footer, .sidebar-bottom, .logout-form { margin-top: auto; padding-top: 18px !important; border-top: 1px solid #ffffff20 !important; }
    .sidebar-bottom { width: 100%; }
    .help-card { margin: 0 0 18px; padding: 16px; border: 1px solid #ffffff18; border-radius: 13px; background: #ffffff0d; }
    .help-card i { margin-bottom: 8px; color: var(--amber); }
    .help-card h4 { margin: 0 0 5px; color: white; font: 700 12px 'Poppins', sans-serif !important; }
    .help-card p { margin: 0; color: #bdc9d9; font: 400 10px 'Poppins', sans-serif !important; line-height: 1.6; }
    .logout-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 9px; color: #f3b5b5; font-size: 12px; text-decoration: none; }
    .logout-link:hover { background: #e84b4b20; }
    .logout-btn, .btn-logout { color: #f3b5b5 !important; border: 1px solid #ffffff20 !important; border-radius: 10px !important; font: 600 12px 'Poppins', sans-serif !important; }
    .logout-btn:hover, .btn-logout:hover { background: #e84b4b !important; color: #fff !important; }
    .main-content, .main { margin-left: 255px !important; min-width: 0; min-height: 100vh; padding: 0 !important; }
    .top-header, .student-shared-header {
        position: sticky; top: 0; z-index: 500; min-height: 83px; padding: 12px 30px !important;
        display: flex; align-items: center; justify-content: space-between; gap: 18px;
        background: var(--white) !important; border-bottom: 1px solid var(--border) !important;
    }
    .student-shared-header .header-left, .student-shared-header .header-right { display: flex; align-items: center; gap: 18px; min-width: 0; }
    .student-shared-header .header-right { margin-left: auto; }
    .student-shared-header .page-heading h2 { margin: 0; color: var(--navy); font-size: 15px; font-weight: 700; }
    .student-shared-header .page-heading p { margin: 3px 0 0; color: var(--muted); font-size: 10px; }
    .search-bar { max-width: 300px; min-width: 150px; border-radius: 10px !important; background: #f6f7fa !important; border-color: var(--border) !important; }
    .student-shared-header .search-bar { display: flex; align-items: center; gap: 10px; width: 250px; padding: 10px 13px; color: var(--muted); }
    .student-shared-header .search-bar input { width: 100%; min-width: 0; padding: 0; border: 0; outline: 0; background: transparent; color: var(--text); font: 400 11px 'Poppins', sans-serif; }
    .admin-profile-badge, .user-profile { display: flex; align-items: center; gap: 10px; }
    .user-info { display: flex !important; flex-direction: column !important; min-width: 0; line-height: 1.25; }
    .user-name { display: block !important; color: var(--navy) !important; font: 700 12px 'Poppins', sans-serif !important; white-space: nowrap; }
    .user-role { display: block !important; margin-top: 3px; color: var(--muted) !important; font: 500 10px 'Poppins', sans-serif !important; letter-spacing: .04em; }
    .avatar { width: 42px; height: 42px; flex: 0 0 42px; display: flex; align-items: center; justify-content: center; background: var(--navy) !important; color: var(--amber) !important; border-radius: 12px !important; font: 700 16px 'Poppins', sans-serif !important; }
    .dashboard-body { padding: 30px 35px !important; overflow: visible !important; max-width: 1600px; margin: 0 auto; }
    .main > .page-head, .main > .section-title, .main > .profile-card { margin-left: 35px; margin-right: 35px; }
    .main > .page-head { margin-top: 28px; }
    .main > .welcome-banner { margin: 28px 35px 26px; }
    .welcome-banner {
        position: relative; display: flex; align-items: center; justify-content: space-between; gap: 20px;
        margin-bottom: 28px; padding: 28px 30px; overflow: hidden; border-radius: 17px;
        background: var(--navy); color: #fff;
    }
    .welcome-banner::after {
        content: ""; position: absolute; width: 220px; height: 220px; border-radius: 50%;
        border: 35px solid rgba(255,255,255,0.045); right: 100px; top: -100px; pointer-events: none;
    }
    .welcome-banner h1 { position: relative; z-index: 1; margin: 0; color: #fff !important; font-size: 25px !important; line-height: 1.4; }
    .welcome-banner p { position: relative; z-index: 1; max-width: 560px; margin: 8px 0 0; color: #c5d0df !important; font-size: 12px !important; line-height: 1.8; }
    .welcome-content { position: relative; z-index: 1; }
    .welcome-content .eyebrow { margin-bottom: 10px; color: var(--amber); font-size: 10px; font-weight: 600; letter-spacing: 1.7px; text-transform: uppercase; }
    .welcome-date { position: relative; z-index: 1; min-width: 155px; padding: 15px 18px; border: 1px solid #ffffff20; border-radius: 12px; background: #ffffff17; }
    .welcome-date span { display: block; margin-bottom: 5px; color: #c5d0df; font-size: 10px; }
    .welcome-date strong { color: var(--amber); font-size: 13px; }
    .card-panel, .metric-card, .room-overview-card, .profile-card, .payment-card {
        border: 1px solid var(--border) !important; border-radius: 14px !important; box-shadow: 0 5px 20px #172b4d0f !important;
    }
    .profile-card.profile-landscape {
        display: grid; grid-template-columns: minmax(220px, .72fr) minmax(0, 1.28fr); gap: 12px;
        width: auto; max-width: none; padding: 14px !important; align-items: stretch;
    }
    .profile-summary { grid-column: 1; grid-row: 1; padding: 14px; border: 1px solid var(--border); border-radius: 12px; background: #f7f8fb; }
    .profile-summary-title, .profile-form-title { margin: 0 0 16px; color: var(--muted); font-size: 10px; font-weight: 700; letter-spacing: .09em; text-transform: uppercase; }
    .profile-landscape .profile-identity { padding: 0 0 18px; margin: 0 0 10px; border-bottom: 1px solid var(--border); }
    .profile-landscape .profile-avatar { width: 54px; height: 54px; }
    .profile-landscape .account-facts { margin: 0; padding: 0; border: 0; }
    .profile-landscape .info-row { padding: 10px 0; font-size: 12px !important; }
    .profile-landscape form { grid-column: 2; grid-row: 1; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; align-content: center; }
    .profile-landscape .profile-form-title { grid-column: 1 / -1; margin-bottom: 0; color: var(--navy); font-size: 13px; letter-spacing: 0; text-transform: none; }
    .profile-landscape .form-group { margin: 0; }
    .profile-landscape .form-group label { margin-bottom: 5px; }
    .profile-landscape .form-group input, .profile-landscape .form-group select { padding: 9px 11px; }
    .profile-landscape .alert-success, .profile-landscape .alert-error, .profile-landscape .btn-save { grid-column: 1 / -1; }
    .profile-landscape .alert-success, .profile-landscape .alert-error { margin: 0; padding: 9px 12px; }
    .profile-landscape .btn-save { width: auto; justify-self: start; margin-top: 2px; padding: 10px 22px; }
    .form-group input, .form-group select, .form-group textarea, input.form-control, select.form-control, textarea.form-control {
        border: 1px solid var(--border) !important; border-radius: 9px !important; font: 400 13px 'Poppins', sans-serif !important;
    }
    .btn-submit, .btn-save, .primary-button { border-radius: 9px !important; font-family: 'Poppins', sans-serif !important; }
    table { border-color: var(--border); }
    thead, thead th { background: #f6f7fa !important; }
    th { color: var(--muted) !important; font-size: 10px !important; letter-spacing: .08em; }
    td { border-color: var(--border) !important; }
    .notification-wrapper { position: relative; flex: 0 0 auto; }
    .student-menu-toggle { display: none; width: 40px; height: 40px; flex: 0 0 40px; place-items: center; border: 1px solid var(--border); border-radius: 10px; background: #fff; color: var(--navy); font-size: 16px; }
    .page-back-button { display: inline-grid; place-items: center; flex: 0 0 34px; width: 34px; height: 34px; padding: 0; border: 1px solid var(--border); border-radius: 8px; background: #fff; color: var(--navy); cursor: pointer; transition: background .15s ease, border-color .15s ease; }
    .page-back-button:hover { border-color: #b9c5d7; background: #f5f7fb; }
    .page-back-button i { font-size: 13px; line-height: 1; }
    .student-shared-header .page-heading { margin: 0; color: var(--navy); }
    .student-mobile-overlay { display: none; }
    .notification-button { width: 42px; height: 42px; display: grid; place-items: center; position: relative; border: 1px solid var(--border); border-radius: 12px; background: #fff; color: var(--navy); font-size: 17px; }
    .notification-button:hover { background: var(--amber-light); border-color: var(--amber); }
    .notification-badge { position: absolute; top: -5px; right: -5px; min-width: 19px; height: 19px; padding: 0 5px; border: 2px solid white; border-radius: 50px; background: var(--red); color: white; font-size: 10px; font-weight: 700; display: grid; place-items: center; }
    .notification-badge[hidden] { display: none; }
    .notification-dropdown { display: none; position: absolute; top: 52px; right: 0; z-index: 1200; width: 340px; max-width: calc(100vw - 24px); overflow: hidden; border: 1px solid var(--border); border-radius: 14px; background: white; box-shadow: 0 12px 35px #172b4d26; }
    .notification-dropdown.open { display: block; }
    .notification-header { display: flex; align-items: center; justify-content: space-between; padding: 15px 17px; border-bottom: 1px solid var(--border); }
    .notification-header h3 { margin: 0; color: var(--navy); font-size: 13px; }
    .notification-header button { border: 0; background: none; color: #3768a5; font: 600 10px 'Poppins', sans-serif; }
    .notification-list { max-height: 350px; overflow-y: auto; }
    .notification-item { display: flex; gap: 12px; padding: 14px 16px; border-bottom: 1px solid #f0f1f4; cursor: pointer; }
    .notification-item:hover, .notification-item.unread { background: #fffaf0; }
    .notification-link { color: inherit; text-decoration: none; }
    .notification-icon { width: 34px; height: 34px; flex: 0 0 34px; display: grid; place-items: center; border-radius: 10px; background: var(--amber-light); color: #a66b00; }
    .notification-text { min-width: 0; }
    .notification-text h4 { margin: 0 0 3px; color: var(--navy); font-size: 11px; overflow-wrap: anywhere; }
    .notification-text p { margin: 0; color: #687589; font-size: 10px; line-height: 1.65; overflow-wrap: anywhere; }
    .notification-time { display: block; margin-top: 5px; color: #99a1af; font-size: 9px; }
    .empty-notification { padding: 25px 15px; color: var(--muted); text-align: center; font-size: 11px; }
    @media (max-width: 900px) {
        .student-menu-toggle { display: grid; }
        .sidebar, .sidebar-wrapper .sidebar { transform: translateX(-100%); }
        .sidebar.show, .sidebar-wrapper .sidebar.show { transform: translateX(0); }
        .student-mobile-overlay.show { display: block; position: fixed; inset: 0; z-index: 900; background: #0006; }
        .main-content, .main { margin-left: 0 !important; }
        .dashboard-body { padding: 24px !important; }
        .welcome-banner { padding: 23px 22px; }
        .profile-card.profile-landscape { grid-template-columns: minmax(180px, .65fr) minmax(0, 1.35fr); gap: 12px; padding: 14px !important; }
        .app-container { flex-direction: initial !important; }
    }
    @media (max-width: 600px) {
        .top-header, .student-shared-header { min-height: 72px; padding: 10px 14px !important; gap: 10px; }
        .student-shared-header .header-left, .student-shared-header .header-right { gap: 10px; }
        .dashboard-body { padding: 18px 14px !important; }
        .welcome-banner { flex-direction: column; align-items: flex-start; padding: 20px 18px; }
        .welcome-date { width: 100%; }
        .main > .page-head, .main > .section-title, .main > .profile-card { margin-left: 14px; margin-right: 14px; }
        .main > .page-head { margin-top: 20px; }
        .main > .welcome-banner { margin: 20px 14px 22px; }
        .profile-card.profile-landscape { grid-template-columns: minmax(0, 1fr); gap: 12px; padding: 12px !important; }
        .profile-landscape .profile-summary, .profile-landscape form { grid-column: 1; grid-row: auto; }
        .profile-landscape form { grid-template-columns: minmax(0, 1fr); }
        .search-bar { display: none; }
        .user-info { display: none; }
        .notification-dropdown { right: -55px; }
    }

    /* Shared type scale and spacing for student pages. */
    .main, .main-content { font-size: 14px; line-height: 1.65; }
    .student-shared-header .page-heading h2 { font-size: 17px; }
    .student-shared-header .page-heading p { font-size: 12px; }
    .user-name { font-size: 13px !important; }
    .user-role { font-size: 11px !important; }
    .dashboard-body { padding: 24px 28px !important; }
    .welcome-banner { padding: 22px 28px !important; margin-bottom: 22px !important; }
    .welcome-banner h1 { font-size: 24px !important; line-height: 1.3 !important; }
    .welcome-banner p { font-size: 13px !important; line-height: 1.55 !important; }
    .main h1, .dashboard-body h1 { font-size: 23px !important; line-height: 1.3 !important; }
    .main .section-title, .dashboard-body h2 { font-size: 16px !important; line-height: 1.4 !important; }
    .main .form-group label { font-size: 11px !important; }
    .main .form-group input, .main .form-group select, .main .form-group textarea,
    .main .info-row, .main .btn-save { font-size: 13px !important; }
    .main .info-row .label { font-size: 10px !important; }
    .main td { font-size: 12px !important; line-height: 1.45; }
    .main th { font-size: 10px !important; }
    .main th, .main td { padding: 10px 11px; }
    .notification-text h4 { font-size: 13px; }
    .notification-text p { font-size: 12px; }

    @media (max-width: 900px) {
        .dashboard-body { padding: 20px 18px !important; }
        .welcome-banner { padding: 20px 22px !important; }
    }
    @media (max-width: 600px) {
        .dashboard-body { padding: 16px 12px !important; }
        .welcome-banner { padding: 18px 16px !important; }
        .welcome-banner h1 { font-size: 21px !important; }
        .welcome-banner p { font-size: 12px !important; }
        .main th, .main td { padding: 9px 8px; }
    }
    .top-header, .student-shared-header { min-height: 72px; padding: 9px 22px !important; gap: 12px; }
    .student-shared-header .header-left, .student-shared-header .header-right { gap: 12px; }
    .main .form-grid { gap: 11px 14px; }
    .main .form-group { margin-bottom: 11px; }
    .main .btn-save, .main .btn-submit { min-height: 40px; padding: 9px 16px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
    .main .search-bar { gap: 8px; padding: 8px 12px; }
    .main .search-bar i { flex: 0 0 auto; line-height: 1; }
    .main .actions button, .main .action-buttons button { min-width: 34px; min-height: 34px; display: inline-flex; align-items: center; justify-content: center; }
    /* Compact card and form spacing shared by student pages. */
    .main .metrics-grid,
    .main .stats-grid,
    .main .content-grid,
    .main .roommates-grid,
    .main .quick-actions-grid,
    .main .amenities-grid { gap: 8px; }
    .main .metric-card,
    .main .card-panel,
    .main .room-overview-card,
    .main .payment-card { padding: 14px; }
    .main .metric-card { min-height: 88px; }
    .main .card-panel { margin-bottom: 14px; }
    .main .form-grid { gap: 9px 12px; }
    .main .form-group { margin-bottom: 9px; }
    .main .form-group input,
    .main .form-group select,
    .main .form-group textarea,
    .main input.form-control,
    .main select.form-control,
    .main textarea.form-control { min-height: 38px; padding: 8px 10px; }
    .main .form-group textarea,
    .main textarea.form-control { min-height: 86px; }
    .main .btn-save, .main .btn-submit { min-height: 38px; padding: 8px 14px; }
    .main .content-grid { grid-template-columns: minmax(0, 1.4fr) minmax(260px, .9fr); }
    .main-content .metrics-grid,
    .main-content .stats-grid,
    .main-content .content-grid,
    .main-content .quick-actions,
    .main-content .quick-actions-grid,
    .main-content .amenities-grid,
    .main-content .roommates-grid { gap: 8px; }
    .main-content .metric-card,
    .main-content .stat-card,
    .main-content .card-panel,
    .main-content .room-overview-card,
    .main-content .payment-card { padding: 14px; }
    .main-content .metric-card { min-height: 88px; }
    .main-content .card-panel { margin-bottom: 14px; }
    .main-content .form-grid { gap: 9px 12px; }
    .main-content .form-group { margin-bottom: 9px; }
    .main-content .form-group input,
    .main-content .form-group select,
    .main-content .form-group textarea,
    .main-content input.form-control,
    .main-content select.form-control,
    .main-content textarea.form-control { min-height: 38px; padding: 8px 10px; }
    .main-content .form-group textarea,
    .main-content textarea.form-control { min-height: 86px; }
    .main-content .btn-save, .main-content .btn-submit { min-height: 38px; padding: 8px 14px; }
    @media (max-width: 900px) {
        .main-content .content-grid { grid-template-columns: minmax(0, 1fr); }
        .main .content-grid { grid-template-columns: minmax(0, 1fr); }
    }
    @media (max-width: 600px) {
        .top-header, .student-shared-header { min-height: 64px; padding: 8px 12px !important; gap: 8px; }
        .main .metric-card, .main .card-panel, .main .payment-card { padding: 12px; }
        .main-content .metric-card, .main-content .stat-card, .main-content .card-panel, .main-content .payment-card { padding: 12px; }
        .main-content .content-grid { gap: 0; }
        .main .content-grid { gap: 0; }
    }

    /* Keep student metric cards aligned across dashboard, room, payments, and maintenance. */
    .main-content .metrics-grid,
    .main-content .stats-grid,
    .main-content .stat-grid,
    .main .metrics-grid,
    .main .stats-grid,
    .main .stat-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        align-items: stretch;
        gap: 12px !important;
        margin-bottom: 18px !important;
    }
    .main-content .metric-card,
    .main-content .stat-card,
    .main .metric-card,
    .main .stat-card {
        display: flex;
        min-width: 0;
        min-height: 92px !important;
        align-items: center;
        padding: 14px !important;
        gap: 12px;
    }
    .main-content .content-grid,
    .main-content .room-content-grid,
    .main-content .maintenance-layout,
    .main .content-grid,
    .main .room-content-grid,
    .main .maintenance-layout { align-items: start; gap: 12px !important; }
    .main-content .card-panel,
    .main-content .payment-card,
    .main-content .room-overview-card,
    .main .card-panel,
    .main .payment-card,
    .main .room-overview-card { min-width: 0; padding: 14px !important; margin-bottom: 12px; }
    @media (max-width: 1000px) {
        .main-content .metrics-grid,
        .main-content .stats-grid,
        .main-content .stat-grid,
        .main .metrics-grid,
        .main .stats-grid,
        .main .stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
    }
    @media (max-width: 600px) {
        .main-content .metrics-grid,
        .main-content .stats-grid,
        .main-content .stat-grid,
        .main .metrics-grid,
        .main .stats-grid,
        .main .stat-grid { gap: 8px !important; margin-bottom: 12px !important; }
        .main-content .metric-card,
        .main-content .stat-card,
        .main .metric-card,
        .main .stat-card { min-height: 82px !important; padding: 12px !important; gap: 8px; }
        .main-content .card-panel,
        .main-content .payment-card,
        .main .card-panel,
        .main .payment-card { padding: 12px !important; }
    }

    /* Maintenance uses the same navy hero and card treatment as the dashboard. */
    body.maintenance-page .dashboard-body { padding: 24px 28px !important; }
    body.maintenance-page .welcome-banner {
        display: flex !important;
        margin: 0 0 20px !important;
        padding: 22px 28px !important;
    }
    body.maintenance-page .metrics-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        gap: 12px !important;
        margin-bottom: 20px !important;
    }
    body.maintenance-page .metric-card {
        display: flex !important;
        align-items: center;
        justify-content: flex-start;
        min-width: 0;
        min-height: 92px !important;
        padding: 14px !important;
        gap: 12px !important;
        border-radius: 12px !important;
        box-shadow: 0 5px 20px #172b4d0f !important;
    }
    body.maintenance-page .metric-info { display: block; min-width: 0; }
    body.maintenance-page .metric-icon {
        flex: 0 0 42px;
        width: 42px;
        height: 42px;
        border-radius: 10px;
        font-size: 16px;
    }
    body.maintenance-page .metric-title { display: block; min-width: 0; font-size: 10px; line-height: 1.35; letter-spacing: .45px; }
    body.maintenance-page .metric-value { min-width: 0; margin-top: 3px; font-size: 19px; line-height: 1.25; overflow-wrap: anywhere; }
    body.maintenance-page .maintenance-layout { gap: 12px !important; }
    body.maintenance-page .maintenance-layout > .card-panel { padding: 14px !important; border-radius: 14px !important; }
    body.maintenance-page .card-panel { margin-bottom: 12px !important; }
    @media (max-width: 1200px) {
        body.maintenance-page .metrics-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
    }
    @media (max-width: 900px) {
        body.maintenance-page .dashboard-body { padding: 20px 18px !important; }
        body.maintenance-page .welcome-banner { padding: 20px 22px !important; }
    }
    @media (max-width: 600px) {
        body.maintenance-page .dashboard-body { padding: 16px 12px !important; }
        body.maintenance-page .welcome-banner { flex-direction: column; align-items: flex-start; padding: 18px 16px !important; }
        body.maintenance-page .metrics-grid { gap: 12px !important; margin-bottom: 20px !important; }
        body.maintenance-page .metric-card { min-height: 82px !important; padding: 12px !important; gap: 8px !important; }
        body.maintenance-page .metric-icon { flex-basis: 36px; width: 36px; height: 36px; }
        body.maintenance-page .maintenance-layout { gap: 12px !important; }
        body.maintenance-page .maintenance-layout > .card-panel { padding: 12px !important; }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-page-back]').forEach(button => {
            button.addEventListener('click', () => {
                const referrer = document.referrer;
                if (referrer && new URL(referrer).origin === window.location.origin) {
                    window.history.back();
                    return;
                }

                window.location.href = button.dataset.fallback;
            });
        });
    });
</script>
