<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-icon"><i class="fa-solid fa-building"></i></div>
        <div>
            <div class="brand-name">Dorm Portal</div>
            <div class="brand-subtitle">STUDENT MANAGEMENT</div>
        </div>
    </div>

    <div class="sidebar-label">Main Menu</div>
    <nav class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i><span>Dashboard</span>
        </a>
        <a href="{{ route('room') }}" class="nav-link {{ request()->routeIs('room') ? 'active' : '' }}">
            <i class="fa-solid fa-bed"></i><span>My Room</span>
        </a>
        <a href="{{ route('payments') }}" class="nav-link {{ request()->routeIs('payments*') ? 'active' : '' }}">
            <i class="fa-solid fa-wallet"></i><span>Payments</span>
        </a>
        <a href="{{ route('maintenance.index') }}" class="nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
            <i class="fa-solid fa-screwdriver-wrench"></i><span>Maintenance</span>
        </a>
        <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
            <i class="fa-solid fa-user"></i><span>My Profile</span>
        </a>
    </nav>

    <div class="sidebar-label">Support</div>
    <nav class="nav-menu">
        <a href="{{ route('maintenance.index') }}" class="nav-link">
            <i class="fa-solid fa-circle-question"></i><span>Help Center</span>
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="help-card">
            <i class="fa-solid fa-headset"></i>
            <h4>Need Assistance?</h4>
            <p>Contact the dorm administrator if you need help with your room, payments, or concerns.</p>
        </div>
        <a href="{{ route('logout') }}" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket"></i><span>Log Out</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>
</aside>
<div class="mobile-overlay student-mobile-overlay" id="mobileOverlay" data-student-sidebar-overlay></div>
