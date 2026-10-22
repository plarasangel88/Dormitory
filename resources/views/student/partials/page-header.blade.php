<header class="top-header student-shared-header">
    <div class="header-left">
        <button class="student-menu-toggle" type="button" data-student-sidebar-toggle aria-label="Open navigation"><i class="fa-solid fa-bars"></i></button>
        <button class="page-back-button" type="button" data-page-back data-fallback="{{ route('dashboard') }}" aria-label="Go back" title="Go back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button>
        <div class="page-heading">
            <h2>{{ $title }}</h2>
            <p>{{ $subtitle }}</p>
        </div>
    </div>

    <div class="header-right">
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
