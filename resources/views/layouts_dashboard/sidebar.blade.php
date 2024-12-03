<div id="sidebar" class="position-fixed d-flex flex-column" style="background-color:#FFFABF; width: 240px; height: calc(100vh - 56px); top: 56px; transition: width 0.3s;">
    <!-- Header -->
    

@if (Auth::user() && Auth::user()->role === 'super-admin')
    <div id="sidebar-header" class="d-flex align-items-center py-3 px-3">
        <span id="dashboardText">Dashboard</span>
        
    </div>

    <a href="{{ route('superadmin.home') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
    <i class="bi bi-speedometer2 me-2"></i> <span class="menu-text">Dashboard</span>
    </a>

    <!-- Menu Items -->

    <a href="{{route('superadmin.user')}}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
    <i class="bi bi-people me-2"></i> <span class="menu-text">User</span>
    </a>

    <a href="{{ route('superadmin.certificate.createTemplate') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
        <i class="bi bi-files-alt me-2"></i> <span class="menu-text">Template Certificate</span>
    </a>
    <a href="{{ route('superadmin.event') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
    <i class="bi bi-clipboard-data me-2"></i> <span class="menu-text">Data Event</span>
    </a>
    <a href="#" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
        <i class="bi bi-clock-history me-2"></i> <span class="menu-text">History</span>
    </a>
    <a href="#" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
        <i class="bi bi-gear me-2"></i> <span class="menu-text">Setting</span>
    </a>
    <a href="#" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
        <i class="bi bi-question-circle me-2"></i> <span class="menu-text">Help</span>
    </a>
@endif

    <!-- Toggle Button -->
    <button id="toggleSidebar" class="btn position-absolute top-50 start-100 translate-middle-y p-0" style="background-color:#FF5622; width: 40px; height: 40px; border-radius: 50%;">
        <i class="bi bi-chevron-double-left"></i>
    </button>
</div>
