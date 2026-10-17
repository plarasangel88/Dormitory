<header class="top-header student-shared-header">
    <div class="header-left">
        <button class="student-menu-toggle" type="button" data-student-sidebar-toggle aria-label="Open navigation"><i class="fa-solid fa-bars"></i></button>
        <div class="page-heading">
            <h2>{{ $title }}</h2>
            <p>{{ $subtitle }}</p>
        </div>
    </div>

    <div class="header-right">
        <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="Search..." aria-label="Search">
        </div>
        @include('student.partials.announcement-bell')
        <div class="user-profile">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}</div>
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name ?? 'Student' }}</span>
                <span class="user-role">{{ strtoupper(auth()->user()->role ?? 'STUDENT') }}</span>
            </div>
        </div>
    </div>
</header>
