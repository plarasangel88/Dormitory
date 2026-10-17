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
        padding: 25px 18px !important; background: var(--navy-deep) !important;
        color: #fff !important; border: 0 !important; box-shadow: none !important;
    }
    .sidebar-brand, .shell .brand {
        position: relative;
        display: flex !important; align-items: center; gap: 12px; min-height: 68px;
        margin: 0 0 0 !important; padding: 5px 10px 22px !important;
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
    .sidebar-menu, .shell .nav { display: flex; flex-direction: column; gap: 7px; flex-grow: 1; margin-top: 27px; }
    .sidebar-menu::before, .shell .nav::before {
        content: 'MAIN MENU'; margin: 0 12px 5px; color: #9baac0;
        font: 600 10px 'Poppins', sans-serif; letter-spacing: 1.5px;
    }
    .menu-item, .shell .nav a {
        display: flex !important; align-items: center; gap: 13px; min-height: 48px;
        padding: 13px 14px !important; margin: 0 !important; border: 0 !important;
        border-radius: 10px !important; background: transparent !important;
        color: #d3dbea !important; font-size: 13px !important; font-weight: 500 !important;
        text-decoration: none; box-shadow: none !important; transition: background .2s ease, color .2s ease;
    }
    .menu-item i, .shell .nav a i { width: 19px; text-align: center; font-size: 15px; }
    .menu-item:hover, .shell .nav a:hover { background: #ffffff14 !important; color: #fff !important; }
    .menu-item.active, .shell .nav a.active { background: var(--amber) !important; color: var(--navy-deep) !important; font-weight: 700 !important; box-shadow: none !important; }
    .sidebar-footer, .shell .logout { margin-top: auto !important; padding: 18px 0 0 !important; border-top: 1px solid #ffffff20 !important; }
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
    .metric-card { padding: 20px !important; }
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
        .menu-item, .shell .nav a { flex-basis: 135px; padding: 10px !important; }
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
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (document.body.classList.contains('admin-dashboard')) return;

        const sidebar = document.querySelector('.sidebar');
        const main = document.querySelector('.main-content, .shell > main');
        if (!sidebar || !main) return;

        const header = main.querySelector('.top-header');
        const toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'admin-menu-toggle';
        toggle.setAttribute('aria-label', 'Toggle navigation');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.innerHTML = '<i class="fa-solid fa-bars" aria-hidden="true"></i>';
        (header || main).prepend(toggle);

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
