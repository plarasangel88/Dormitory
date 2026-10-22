<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --navy-deep: #172b4d;
        --navy-mid: #223d65;
        --navy-soft: #365c8e;
        --amber: #f3b33d;
        --amber-soft: #ffd778;
        --paper: #f7f5ef;
        --ink: #26364b;
        --slate: #7d8797;
        --bg-main: var(--paper);
        --sidebar-bg: var(--navy-deep);
        --card-bg: #fff;
        --text-primary: var(--ink);
        --text-secondary: var(--slate);
        --border-color: #e8eaf0;
        --primary-blue: var(--navy-soft);
        --primary-hover: var(--navy-mid);
        --warning-orange: var(--amber);
    }

    body, body *:not(i):not(svg):not(path) { font-family: 'Poppins', sans-serif !important; }
    body { background: var(--paper) !important; color: var(--ink); }
    .app-container { min-height: 100vh; }
    .sidebar, .shell > .sidebar {
        width: 255px !important; min-width: 255px; min-height: 100vh; height: 100vh;
        position: sticky; top: 0; overflow-y: auto; flex: 0 0 255px;
        padding: 18px 16px !important; background: var(--navy-deep) !important;
        color: #fff !important; border: 0 !important; box-shadow: none !important;
    }
    .sidebar-brand, .shell .brand {
        position: relative;
        display: flex !important; align-items: center; gap: 10px; min-height: 60px;
        margin: 0 !important; padding: 4px 8px 16px !important;
        color: #fff !important; background: transparent !important; border: 0 !important;
        border-bottom: 1px solid #ffffff20 !important; border-radius: 0 !important;
        font-size: 19px !important; font-weight: 800 !important; letter-spacing: .3px;
        text-decoration: none;
    }
    .sidebar-brand::after, .shell .brand::after {
        content: 'ADMIN MANAGEMENT'; position: absolute; left: 63px; bottom: 7px;
        color: #b7c4d7; font: 400 10px 'Poppins', sans-serif; letter-spacing: .02em;
    }
    .sidebar-brand i, .shell .brand i { color: var(--navy-deep); background: var(--amber); border-radius: 12px; width: 43px; height: 43px; display: grid; place-items: center; font-size: 20px; }
    .sidebar-menu, .shell .nav { display: flex; flex-direction: column; gap: 4px; flex-grow: 1; margin-top: 18px; }
    .sidebar-menu::before, .shell .nav::before {
        content: 'MAIN MENU'; margin: 0 10px 4px; color: #9baac0;
        font: 600 10px 'Poppins', sans-serif; letter-spacing: 1.5px;
    }
    .menu-item, .shell .nav a {
        display: flex !important; align-items: center; gap: 10px; min-height: 42px;
        padding: 10px 12px !important; margin: 0 !important; border: 0 !important;
        border-radius: 10px !important; background: transparent !important;
        color: #d3dbea !important; font-size: 13px !important; font-weight: 500 !important;
        text-decoration: none; box-shadow: none !important; transition: background .2s ease, color .2s ease;
    }
    .menu-item i, .shell .nav a i { width: 18px; text-align: center; font-size: 14px; }
    .menu-item:hover, .shell .nav a:hover { background: #ffffff14 !important; color: #fff !important; }
    .menu-item.active, .shell .nav a.active { background: var(--amber) !important; color: var(--navy-deep) !important; font-weight: 700 !important; box-shadow: none !important; }
    .sidebar-footer, .shell .logout { margin-top: auto !important; padding: 12px 0 0 !important; border-top: 1px solid #ffffff20 !important; }
    .logout-btn, .shell .logout button {
        width: 100%; min-height: 42px; padding: 10px 12px !important; border: 1px solid #ffffff24 !important;
        border-radius: 9px !important; background: transparent !important; color: #f3b5b5 !important;
        justify-content: center; font-size: 12px !important; font-weight: 600 !important;
    }
    .logout-btn:hover, .shell .logout button:hover { background: #e84b4b !important; color: #fff !important; }
    .main-content, .shell > main { min-width: 0; flex: 1; background: var(--paper); }
    .top-header {
        min-height: 83px; padding: 12px 30px !important; gap: 18px; display: flex; align-items: center;
        background: #fff !important; border-bottom: 1px solid var(--border-color) !important;
        box-shadow: none !important;
    }
    .shell > main > .top-header { margin: -30px -30px 28px; }
    .admin-page-heading { flex: 1 1 auto; min-width: 150px; margin-right: auto; }
    .admin-page-heading strong { display: block; color: var(--navy-deep); font-size: 15px; font-weight: 700; }
    .admin-page-heading small { display: block; margin-top: 3px; color: var(--slate); font-size: 10px; }
    .search-bar { border: 1px solid var(--border-color) !important; border-radius: 10px !important; background: #f6f7fa !important; }
    .search-bar input { font-size: 13px !important; }
    .admin-profile-badge { gap: 10px !important; }
    .admin-profile-badge .avatar { width: 42px; height: 42px; flex: 0 0 42px; border-radius: 12px !important; background: var(--navy-deep) !important; color: var(--amber) !important; font: 700 16px 'Poppins', sans-serif !important; }
    .user-info { display: flex; flex-direction: column; gap: 3px; }
    .user-name { color: var(--navy-deep) !important; font-size: 12px !important; font-weight: 700 !important; }
    .user-role { color: var(--slate) !important; font-size: 10px !important; font-weight: 500 !important; letter-spacing: .04em; }
    .dashboard-body { padding: 30px 35px !important; }
    .welcome-banner {
        padding: 26px 32px !important; margin-bottom: 28px !important; border: 0 !important;
        border-radius: 17px !important; background: var(--navy-deep) !important; color: #fff !important;
        box-shadow: none !important;
        position: relative; overflow: hidden;
    }
    .welcome-banner::after { content: ""; position: absolute; width: 220px; height: 220px; border-radius: 50%; border: 35px solid rgba(255,255,255,.045); right: 100px; top: -100px; pointer-events: none; }
    .welcome-banner .banner-feature-name {
        display: block !important; flex: 0 0 100%; width: 100%; visibility: visible !important; opacity: 1 !important;
        position: relative; z-index: 1; margin: 0 0 8px !important; color: #fff !important;
        font: 700 25px/1.35 'Poppins', sans-serif !important;
    }
    .main-content h1, .shell main h1 { color: var(--navy-deep) !important; font: 700 22px/1.35 'Poppins', sans-serif !important; }
    .welcome-banner p { color: #d3dbea !important; font-size: 12px !important; margin-bottom: 0 !important; }
    .sub { color: var(--slate) !important; font-size: 12px !important; }
    .main-content h2, .shell main h2, .dashboard-body h2 { color: var(--navy-deep); font: 700 16px/1.4 'Poppins', sans-serif !important; }
    .main-content label, .shell > main label { color: var(--navy-deep); font-size: 11px !important; font-weight: 600 !important; }
    .metric-card, .card, .panel, .content-card, .stat-card, .table-container {
        background: #fff !important; border: 1px solid var(--border-color) !important;
        border-radius: 14px !important; box-shadow: 0 5px 20px #172b4d0f !important;
    }
    .metric-card { padding: 14px !important; }
    .metric-value, .metric-card h2, .metric-card h3 { color: var(--navy-deep); }
    .data-table, .shell table { width: 100%; border-color: var(--border-color) !important; }
    .data-table th, .data-table td, .shell th, .shell td { padding: 12px 11px; border-color: var(--border-color) !important; }
    .data-table td, .shell td { color: var(--ink); font-size: 12px !important; }
    .data-table thead, .data-table th, .shell thead, .shell th { background: #f6f7fa !important; color: var(--slate) !important; font-size: 10px !important; letter-spacing: .06em; }
    .data-table tbody tr:hover, .shell tbody tr:hover { background: #fffaf0; }
    input:not([type="checkbox"]):not([type="radio"]), select, textarea {
        border: 1px solid var(--border-color) !important; border-radius: 9px !important;
        font-size: 13px !important; background-color: #fff;
    }
    button, .btn, [type="submit"] { font-family: 'Poppins', sans-serif !important; }
    .btn-primary, button.primary, .primary-button { border-radius: 9px !important; background: var(--navy-deep) !important; color: #fff !important; }
    .badge, .status-badge, .pill { border-radius: 999px !important; font-size: 10px !important; font-weight: 700 !important; }
    dialog { max-height: calc(100vh - 32px); overflow-y: auto; border-radius: 14px !important; }
    .table-wrap, .table-responsive { max-width: 100%; overflow-x: auto; }

    @media (max-width: 900px) {
        body:not(.admin-dashboard) .sidebar, body.admin-dashboard .sidebar, .shell > .sidebar {
            position: fixed !important; inset: 0 auto 0 0; z-index: 1000;
            width: 255px !important; min-width: 255px; height: 100vh; min-height: 100vh;
            transform: translateX(-100%); transition: transform .25s ease;
        }
        body.admin-sidebar-open:not(.admin-dashboard) .sidebar,
        body.admin-dashboard.sidebar-open .sidebar { transform: translateX(0); }
        body:not(.admin-dashboard) .sidebar-backdrop { display: none; }
        body.admin-sidebar-open:not(.admin-dashboard) .admin-sidebar-backdrop { display: block; }
        body.admin-dashboard .sidebar-backdrop { display: none; }
        body.admin-dashboard.sidebar-open .sidebar-backdrop { display: block; position: fixed; inset: 0; background: #172b4d80; z-index: 900; }
        .admin-menu-toggle { display: grid !important; }
        .menu-toggle { display: inline-flex !important; }
        .main-content, .shell > main { margin-left: 0 !important; }
        .shell > main { padding: 24px 20px !important; }
        .shell > main > .top-header { margin: -24px -20px 24px; }
        .dashboard-body { padding: 24px 20px !important; }
        .top-header { flex-wrap: wrap; }
    }
    @media (max-width: 600px) {
        .top-header { min-height: 72px; padding: 10px 14px !important; gap: 10px; }
        .admin-page-heading { min-width: 0; }
        .admin-page-heading small { display: none; }
        .dashboard-body { padding: 18px 14px !important; }
        .sidebar, .shell > .sidebar { padding: 18px 14px !important; }
        .sidebar-menu, .shell .nav { gap: 5px; }
        .menu-item, .shell .nav a { flex-basis: 135px; min-height: 38px; padding: 8px 10px !important; }
        .form-grid { grid-template-columns: minmax(0, 1fr) !important; }
        .stat-grid { grid-template-columns: minmax(0, 1fr) !important; }
        .metrics-grid { grid-template-columns: repeat(auto-fit, minmax(145px, 1fr)) !important; }
        .admin-profile-badge .user-info { display: none; }
        .shell > main { padding: 18px 12px !important; }
        .shell > main > .top-header { margin: -18px -12px 20px; }
        .shell .nav a { flex: 1 1 130px; }
    }
    .admin-menu-toggle { display: none; place-items: center; width: 40px; height: 40px; flex: 0 0 40px; border: 1px solid var(--border-color); border-radius: 10px; background: #fff; color: var(--navy-deep); cursor: pointer; }
    .admin-sidebar-backdrop { display: none; position: fixed; inset: 0; z-index: 900; background: #172b4d80; }
    @media (max-width: 600px) {
        .welcome-banner { padding: 22px 20px !important; }
        .welcome-banner .banner-feature-name { font-size: 21px !important; }
        .shell > main { padding: 18px 12px !important; }
    }

    /* Shared type scale and spacing for admin pages. */
    .main-content, .shell > main { font-size: 14px; line-height: 1.6; }
    .admin-page-heading strong { font-size: 17px; }
    .admin-page-heading small { font-size: 12px; }
    .admin-profile-badge .user-name { font-size: 13px !important; }
    .admin-profile-badge .user-role { font-size: 11px !important; }
    .dashboard-body { padding: 24px 28px !important; }
    .welcome-banner { padding: 22px 28px !important; margin-bottom: 22px !important; }
    .welcome-banner .banner-feature-name { font-size: 24px !important; line-height: 1.3 !important; }
    .welcome-banner p { font-size: 13px !important; line-height: 1.55 !important; }
    .main-content h1, .shell main h1 { font-size: 23px !important; line-height: 1.3 !important; }
    .main-content h2, .shell main h2, .dashboard-body h2 { font-size: 16px !important; line-height: 1.4 !important; }
    .main-content label, .shell > main label { font-size: 11px !important; }
    .data-table th, .shell th { font-size: 11px !important; }
    .data-table td, .shell td { font-size: 12px !important; line-height: 1.45; }
    .data-table th, .data-table td, .shell th, .shell td { padding: 10px 11px; }
    .metric-card { padding: 14px !important; }
    .search-bar input, input:not([type="checkbox"]):not([type="radio"]), select, textarea { font-size: 13px !important; }
    .btn-add, .action-btn, .post-btn, .quick-actions-grid a { display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-add i, .action-btn i, .post-btn i, .quick-actions-grid i { flex: 0 0 auto; line-height: 1; }

    body.admin-dashboard .dashboard-body { padding: 22px 28px !important; }
    body.admin-dashboard .welcome-banner { padding: 20px 28px !important; margin-bottom: 18px !important; }
    body.admin-dashboard .welcome-banner .banner-feature-name { font-size: 24px !important; }
    body.admin-dashboard .welcome-banner p { margin-top: 3px !important; }
    body.admin-dashboard .metrics-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-bottom: 18px; }
    body.admin-dashboard .metric-card { min-height: 92px; padding: 14px !important; gap: 12px; }
    body.admin-dashboard .metric-icon { width: 40px; height: 40px; flex: 0 0 40px; font-size: 17px; }
    body.admin-dashboard .metric-info { min-width: 0; }
    body.admin-dashboard .metric-title { display: block; font-size: 10px; line-height: 1.3; letter-spacing: .04em; }
    body.admin-dashboard .metric-value { margin-top: 3px; font-size: 21px; line-height: 1.2; overflow-wrap: anywhere; }
    body.admin-dashboard .metric-value small { display: block; margin-top: 3px; font-size: 10px; line-height: 1.35; }
    body.admin-dashboard .dashboard-main-grid { gap: 12px; }
    body.admin-dashboard .card-panel { margin-bottom: 12px; padding: 14px; }
    body.admin-dashboard .panel-header { margin-bottom: 10px; }
    body.admin-dashboard .quick-actions-grid { grid-auto-rows: 52px; gap: 8px; margin-top: 9px; }
    body.admin-dashboard .action-btn { min-height: 52px; height: 100%; padding: 9px 11px; font-size: 12px; }

    @media (max-width: 900px) {
        .dashboard-body { padding: 22px 20px !important; }
        .welcome-banner { padding: 20px 22px !important; }
        body.admin-dashboard .metrics-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 600px) {
        .dashboard-body { padding: 16px 12px !important; }
        .welcome-banner { padding: 18px 16px !important; }
        .welcome-banner .banner-feature-name { font-size: 21px !important; }
        .welcome-banner p { font-size: 12px !important; }
        body.admin-dashboard .dashboard-body { padding: 16px 12px !important; }
        body.admin-dashboard .metrics-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; gap: 8px; }
        body.admin-dashboard .metric-card { min-height: 82px; padding: 12px !important; gap: 8px; }
        body.admin-dashboard .metric-icon { width: 34px; height: 34px; flex-basis: 34px; font-size: 14px; }
        body.admin-dashboard .metric-value { font-size: 18px; }
        body.admin-dashboard .metric-value small { font-size: 9px; }
    }
    .top-header { min-height: 72px; padding: 9px 22px !important; gap: 12px; }
    .page-back-button { display: inline-grid; place-items: center; flex: 0 0 34px; width: 34px; height: 34px; padding: 0; border: 1px solid #d8deea; border-radius: 8px; background: #fff; color: var(--navy-deep); cursor: pointer; transition: background .15s ease, border-color .15s ease; }
    .page-back-button:hover { border-color: #b9c5d7; background: #f5f7fb; }
    .page-back-button i { font-size: 13px; line-height: 1; }
    .main-content .top-header .search-bar, .shell .top-header .search-bar {
        display: flex !important; align-items: center; flex: 0 1 340px; gap: 9px;
        width: min(340px, 34vw) !important; max-width: 340px; min-width: 190px; height: 42px;
        padding: 4px 5px 4px 12px; border: 1px solid #d8deea !important;
        border-radius: 9px !important; background: #fff !important; box-shadow: none;
        color: var(--slate); transition: border-color .15s ease, box-shadow .15s ease;
    }
    .top-header .search-bar:focus-within { border-color: var(--navy-soft) !important; box-shadow: 0 0 0 3px #365c8e18; }
    .top-header .search-bar > i { flex: 0 0 16px; width: 16px; line-height: 1; font-size: 14px; color: #7d8797; }
    .top-header .search-bar input:not([type="hidden"]) {
        flex: 1 1 auto; width: 100%; min-width: 0; height: 32px; padding: 0 !important;
        border: 0 !important; border-radius: 0 !important; outline: 0 !important;
        background: transparent !important; box-shadow: none !important; color: var(--ink); font-size: 12px !important;
    }
    .top-header .search-bar input::placeholder { color: #929bab; opacity: 1; }
    .top-header .search-bar button {
        display: grid; place-items: center; flex: 0 0 32px; width: 32px; height: 32px;
        padding: 0; border: 0; border-radius: 7px; background: var(--navy-deep); color: #fff;
        cursor: pointer; font-size: 12px; transition: background .15s ease;
    }
    .top-header .search-bar button:hover { background: var(--navy-mid); color: #fff; }
    .toolbar { gap: 10px; margin-bottom: 14px; }
    .form-grid { gap: 11px 14px; }
    .form-group { margin-bottom: 11px; }
    dialog { padding: 18px !important; }
    dialog form { gap: 10px; }
    .action-btn, .btn-add, .post-btn, .live-badge { line-height: 1.3; }
    .action-btn i, .btn-add i, .post-btn i, .live-badge i { display: inline-flex; align-items: center; justify-content: center; }
    .actions button, .action-buttons button { min-width: 34px; min-height: 34px; display: inline-flex; align-items: center; justify-content: center; }
    .pagination-wrap { width: 100%; margin-top: 12px !important; }
    .pagination-wrap nav { display: block !important; width: 100%; font-size: 12px; }
    .pagination-wrap nav > div:first-child { display: none !important; }
    .pagination-wrap nav > div:nth-child(2) {
        display: flex !important; align-items: center; justify-content: space-between;
        gap: 12px; width: 100%;
    }
    .pagination-wrap nav > div:nth-child(2) > div:first-child,
    .pagination-wrap nav > div:nth-child(2) > div:first-child p { margin: 0; color: var(--slate); font-size: 11px; line-height: 1.4; }
    .pagination-wrap nav > div:nth-child(2) > div:last-child { display: flex; justify-content: flex-end; }
    .pagination-wrap nav > div:nth-child(2) > div:last-child > span { display: inline-flex !important; align-items: center; }
    .pagination-wrap nav a,
    .pagination-wrap nav [aria-current="page"] > span,
    .pagination-wrap nav [aria-disabled="true"] > span {
        display: inline-flex !important; align-items: center; justify-content: center;
        min-width: 34px; height: 34px; padding: 0 9px !important; margin-left: -1px;
        border: 1px solid #d8deea !important; border-radius: 0 !important;
        background: #fff !important; color: var(--navy-deep) !important;
        font-size: 12px !important; font-weight: 600; line-height: 1;
        text-decoration: none; box-shadow: none !important; transition: background .15s ease, border-color .15s ease;
    }
    .pagination-wrap nav a:hover { z-index: 1; border-color: var(--navy-soft) !important; background: #f5f7fb !important; }
    .pagination-wrap nav [aria-current="page"] > span { z-index: 1; border-color: var(--navy-deep) !important; background: var(--navy-deep) !important; color: #fff !important; }
    .pagination-wrap nav [aria-disabled="true"] > span { color: #a2aaba !important; background: #f6f7fa !important; }
    .pagination-wrap nav svg { display: block; width: 15px !important; height: 15px !important; max-width: 15px; }
    .pagination-wrap nav > div:nth-child(2) > div:last-child > span > :first-child,
    .pagination-wrap nav > div:nth-child(2) > div:last-child > span > :first-child > span { border-top-left-radius: 7px !important; border-bottom-left-radius: 7px !important; }
    .pagination-wrap nav > div:nth-child(2) > div:last-child > span > :last-child,
    .pagination-wrap nav > div:nth-child(2) > div:last-child > span > :last-child > span { border-top-right-radius: 7px !important; border-bottom-right-radius: 7px !important; }
    @media (max-width: 600px) {
        .top-header { min-height: 64px; padding: 8px 12px !important; gap: 8px; }
        .main-content .top-header .search-bar, .shell .top-header .search-bar {
            order: 3; flex: 1 0 100%; width: 100% !important; max-width: none; min-width: 0;
        }
        body.admin-dashboard .top-header { min-height: 64px; }
        .pagination-wrap nav > div:nth-child(2) { flex-direction: column; align-items: flex-start; }
        .pagination-wrap nav > div:nth-child(2) > div:last-child { width: 100%; justify-content: flex-start; }
    }

    /* Compact card and form spacing shared by admin pages. */
    .main-content .metrics-grid,
    .main-content .metric-grid,
    .main-content .stats-grid,
    .main-content .stat-grid,
    .main-content .bed-summary-grid,
    .main-content .dashboard-main-grid,
    .main-content .content-grid,
    .main-content .form-grid { gap: 10px; }
    .main-content .card-panel,
    .main-content .metric-card,
    .main-content .bed-summary-card,
    .main-content .panel,
    .main-content .stat-card { padding: 14px; }
    .main-content .panel-header { margin-bottom: 10px; }
    .main-content .data-table th,
    .main-content .data-table td { padding: 9px 10px; }
    .main-content form .form-control,
    .main-content form .form-select,
    .main-content form .form-group input,
    .main-content form .form-group select,
    .main-content form .form-group textarea {
        min-height: 38px; padding: 8px 10px; font-size: 13px !important;
    }
    .main-content form .form-group textarea { min-height: 86px; }
    body.admin-dashboard .dashboard-main-grid { gap: 12px; }
    body.admin-dashboard .card-panel { padding: 14px; }

    /* Use the same metric-card rhythm on every admin page. */
    .main-content .metrics-grid,
    .main-content .metric-grid,
    .main-content .stats-grid,
    .main-content .stat-grid,
    .main-content .bed-summary-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        align-items: stretch;
        gap: 12px !important;
        margin-bottom: 18px !important;
    }
    .shell > main .metrics-grid,
    .shell > main .metric-grid,
    .shell > main .stats-grid,
    .shell > main .stat-grid,
    .shell > main .bed-summary-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        align-items: stretch;
        gap: 12px !important;
        margin-bottom: 18px !important;
    }
    .main-content .metric-card,
    .main-content .stat-card,
    .main-content .bed-summary-card {
        display: flex;
        min-width: 0;
        min-height: 92px !important;
        align-items: center;
        padding: 14px !important;
        gap: 12px;
    }
    .shell > main .metric-card,
    .shell > main .stat-card,
    .shell > main .bed-summary-card {
        display: flex;
        min-width: 0;
        min-height: 92px !important;
        align-items: center;
        padding: 14px !important;
        gap: 12px;
    }
    .main-content .dashboard-main-grid,
    .main-content .content-grid,
    .main-content .form-grid { align-items: start; gap: 12px !important; }
    .main-content .card-panel,
    .main-content .panel,
    .main-content .table-container { min-width: 0; padding: 14px !important; margin-bottom: 12px; }
    .shell > main .card,
    .shell > main .card-panel,
    .shell > main .panel,
    .shell > main .table-container { min-width: 0; padding: 14px !important; margin-bottom: 12px; }
    @media (max-width: 1000px) {
        .main-content .metrics-grid,
        .main-content .metric-grid,
        .main-content .stats-grid,
        .main-content .stat-grid,
        .main-content .bed-summary-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
        .shell > main .metrics-grid,
        .shell > main .metric-grid,
        .shell > main .stats-grid,
        .shell > main .stat-grid,
        .shell > main .bed-summary-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
    }
    @media (max-width: 600px) {
        .main-content .metrics-grid,
        .main-content .metric-grid,
        .main-content .stats-grid,
        .main-content .stat-grid,
        .main-content .bed-summary-grid { gap: 8px !important; margin-bottom: 12px !important; }
        .main-content .metric-card,
        .main-content .stat-card,
        .main-content .bed-summary-card { min-height: 82px !important; padding: 12px !important; gap: 8px; }
        .main-content .card-panel,
        .main-content .panel,
        .main-content .table-container { padding: 12px !important; }
        .shell > main .metrics-grid,
        .shell > main .metric-grid,
        .shell > main .stats-grid,
        .shell > main .stat-grid,
        .shell > main .bed-summary-grid { gap: 8px !important; margin-bottom: 12px !important; }
        .shell > main .metric-card,
        .shell > main .stat-card,
        .shell > main .bed-summary-card { min-height: 82px !important; padding: 12px !important; gap: 8px; }
        .shell > main .card,
        .shell > main .card-panel,
        .shell > main .panel,
        .shell > main .table-container { padding: 12px !important; }
    }

    .admin-notification-wrapper { position: relative; flex: 0 0 auto; }
    .admin-notification-button { position: relative; display: grid; width: 42px; height: 42px; place-items: center; border: 1px solid var(--border-color); border-radius: 10px; background: #fff; color: var(--navy-deep); font-size: 16px; cursor: pointer; }
    .admin-notification-button:hover { border-color: var(--amber); background: #fffaf0; }
    .admin-notification-badge { position: absolute; top: -5px; right: -5px; display: grid; min-width: 18px; height: 18px; place-items: center; padding: 0 4px; border: 2px solid #fff; border-radius: 999px; background: #e84b4b; color: #fff; font-size: 9px; font-weight: 700; }
    .admin-notification-badge[hidden] { display: none; }
    .admin-notification-dropdown { position: absolute; top: 50px; right: 0; z-index: 1200; display: none; width: 340px; max-width: calc(100vw - 24px); overflow: hidden; border: 1px solid var(--border-color); border-radius: 13px; background: #fff; box-shadow: 0 12px 35px #172b4d26; }
    .admin-notification-dropdown.open { display: block; }
    .admin-notification-header { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 12px 14px; border-bottom: 1px solid var(--border-color); }
    .admin-notification-header h3 { margin: 0; color: var(--navy-deep); font-size: 13px; }
    .admin-notification-header button { border: 0; background: none; color: var(--navy-soft); font: 600 10px 'Poppins', sans-serif; cursor: pointer; }
    .admin-notification-list { max-height: 340px; overflow-y: auto; }
    .admin-notification-item { display: flex; align-items: flex-start; gap: 10px; padding: 12px 13px; border-bottom: 1px solid #f0f1f4; color: inherit; text-decoration: none; }
    .admin-notification-item:hover, .admin-notification-item.unread { background: #fffaf0; }
    .admin-notification-icon { display: grid; width: 32px; height: 32px; flex: 0 0 32px; place-items: center; border-radius: 9px; background: #fff3d6; color: #a66b00; }
    .admin-notification-text { min-width: 0; }
    .admin-notification-text strong { display: block; margin-bottom: 2px; color: var(--navy-deep); font-size: 11px; }
    .admin-notification-text p { margin: 0; color: var(--slate); font-size: 10px; line-height: 1.5; overflow-wrap: anywhere; }
    .admin-notification-time { display: block; margin-top: 4px; color: #929bab; font-size: 9px; }
    .admin-notification-empty { padding: 22px 14px; color: var(--slate); text-align: center; font-size: 11px; }
    @media (max-width: 600px) { .admin-notification-dropdown { right: -48px; } }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.querySelector('.sidebar');
        const main = document.querySelector('.main-content, .shell > main');
        if (!main) return;

        const header = main.querySelector('.top-header');
        if (!header) return;

        const isDashboard = document.body.classList.contains('admin-dashboard');
        let toggle = header.querySelector('.menu-toggle, .admin-menu-toggle');
        if (!toggle && sidebar) {
            toggle = document.createElement('button');
            toggle.type = 'button';
            toggle.className = 'admin-menu-toggle';
            toggle.setAttribute('aria-label', 'Toggle navigation');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.innerHTML = '<i class="fa-solid fa-bars" aria-hidden="true"></i>';
            header.prepend(toggle);
        }

        const backButton = document.createElement('button');
        backButton.type = 'button';
        backButton.className = 'page-back-button';
        backButton.setAttribute('aria-label', 'Go back');
        backButton.title = 'Go back';
        backButton.innerHTML = '<i class="fa-solid fa-arrow-left" aria-hidden="true"></i>';
        if (toggle) {
            toggle.after(backButton);
        } else {
            header.prepend(backButton);
        }
        backButton.addEventListener('click', () => {
            const referrer = document.referrer;
            if (referrer && new URL(referrer).origin === window.location.origin) {
                window.history.back();
                return;
            }

            window.location.href = isDashboard ? @json(route('login')) : @json(route('admin.dashboard'));
        });

        if (isDashboard || !sidebar || !toggle) return;

        const backdrop = document.createElement('div');
        backdrop.className = 'admin-sidebar-backdrop';
        backdrop.setAttribute('aria-hidden', 'true');
        document.body.append(backdrop);

        const closeMenu = () => {
            document.body.classList.remove('admin-sidebar-open');
            toggle.setAttribute('aria-expanded', 'false');
        };
        toggle.addEventListener('click', () => {
            const open = document.body.classList.toggle('admin-sidebar-open');
            toggle.setAttribute('aria-expanded', String(open));
        });
        backdrop.addEventListener('click', closeMenu);
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') closeMenu();
        });
    });
</script>
