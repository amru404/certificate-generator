<div id="sidebar" class="position-fixed d-flex flex-column" style="background-color:#D3D6DB; width: 240px; height: calc(100vh - 56px); top: 56px; transition: width 0.3s;">
    <!-- Header -->
    @if (Auth::user() && Auth::user()->role === 'super-admin')
        <div id="sidebar-header" class="d-flex align-items-center justify-content-between py-3 px-3">
            <!-- Teks Dashboard -->
            <span id="dashboardText" class="me-2">Dashboard</span>
            
            <!-- Tombol Toggle -->
            <button id="toggleSidebar" class="btn btn-sm"style="background-color: #D3D6DB;">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Menu Items -->
        <a href="{{ route('superadmin') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-speedometer2 me-2"></i> <span class="menu-text">Dashboard</span>
        </a>

        <a href="{{ route('superadmin.user') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
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
        <a href="{{ route('setting') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-gear me-2"></i> <span class="menu-text">Setting</span>
        </a>
    @endif

    @if (Auth::user() && Auth::user()->role === 'admin')
    <div id="sidebar-header" class="d-flex align-items-center justify-content-between py-3 px-3">
            <!-- Teks Dashboard -->
            <span id="dashboardText" class="me-2">Dashboard</span>
            
            <!-- Tombol Toggle -->
            <button id="toggleSidebar" class="btn btn-sm"style="background-color: #D3D6DB;">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Menu Items -->
        <a href="{{ route('admin.home') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-speedometer2 me-2"></i> <span class="menu-text">Dashboard</span>
        </a>
        <a href="{{ route('admin.event') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-clipboard-data me-2"></i> <span class="menu-text">Data Event</span>
        </a>
        <a href="#" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-clock-history me-2"></i> <span class="menu-text">History</span>
        </a>
        <a href="{{ route('setting') }}" class="d-flex align-items-center py-3 px-3 text-dark text-decoration-none">
            <i class="bi bi-gear me-2"></i> <span class="menu-text">Setting</span>
        </a>
    @endif

</div>


